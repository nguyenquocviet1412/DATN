<?php

namespace App\Http\Controllers\admin;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(request $request)
    {
        //
        $sortBy = $request->input('sort_by', 'id');
        $sortOrder = $request->input('sort_order', 'asc');
        $search = $request->input('search');

        $users = User::all();
        $wallets = Wallet::all();
        $wallet_transactions = WalletTransaction::all();

        // Ghi log
        LogHelper::logAction('Vào trang hiển thị danh sách tài khoản người dùng');
        return view('admin.user.index', compact('users', 'sortBy', 'sortOrder', 'search', 'wallets', 'wallet_transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $users = User::all();
        // Ghi log
        LogHelper::logAction('Vào trang tạo mới tài khoản người dùng');
        return view('admin.user.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Xác thực dữ liệu đầu vào
    $request->validate([
        'password' => 'required|string|max:255',
        'fullname' => 'required|string',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|numeric|unique:users,phone',
        'address' => 'required|string',
    ]);

    // Tạo tài khoản người dùng
    $user = User::create([
        'password' => Hash::make($request->input('password')),
        'fullname' => $request->input('fullname'),
        'email' => $request->input('email'),
        'phone' => $request->input('phone'),
        'address' => $request->input('address'),
        'gender' => $request->input('gender'),
    ]);

    // Tạo ví tiền mặc định cho user vừa tạo
    Wallet::create([
        'id_user' => $user->id,
        'balance' => 0, // Mặc định số dư ban đầu là 0
        'currency' => 'VND', // Hoặc có thể là USD tùy vào hệ thống của bạn
        'status' => 'active', // Mặc định ví sẽ hoạt động
    ]);

    // Ghi log thao tác
    LogHelper::logAction('Tạo mới tài khoản người dùng có id: ' . $user->id);

    return redirect()->route('user.index')->with('success', 'User created successfully with wallet');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
{
    $user = User::findOrFail($id);
    $wallet = Wallet::where('id_user', $id)->first(); // Lấy ví theo id_user

    // if (!$wallet) {
    //     return back()->with('error', 'Người dùng chưa có ví.');
    // }

    // Nếu không có ví, vẫn cho phép truy cập, chỉ gán transactions = []
    $wallet_transactions = $wallet ? WalletTransaction::where('id_wallet', $wallet->id)->get() : collect();
    // Ghi log
    LogHelper::logAction('Xem chi tiết tài khoản người dùng có id: ' . $user->id);
    return view('admin.user.show', compact('user', 'wallet', 'wallet_transactions'));
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        // Ghi log
        LogHelper::logAction('Vào trang chỉnh sửa tài khoản người dùng có id: ' . $user->id);
        return view('admin.user.edit', compact('user'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'password' => 'nullable|string|max:255',
            'role' => 'required|string',
            'fullname' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|numeric|unique:users,phone,' . $id,
            'address' => 'required|string',
            'status' => 'required|boolean',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'password' => $request->input('password') ? Hash::make($request->input('password')) : $user->password,
            'role' => $request->input('role'),
            'fullname' => $request->input('fullname'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'status' => $request->input('status')
        ]);
        // Ghi log
        LogHelper::logAction('Cập nhật tài khoản người dùng có id: ' . $user->id);

        return redirect()->route('user.index')->with('success', 'User updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        // Ghi log
        LogHelper::logAction('Xóa tài khoản người dùng có id: ' . $user->id);
        return redirect()->route('user.index')->with('success', 'User deleted successfully.');
    }

    public function deleted()
    {
        $deletedUsers = User::onlyTrashed()->get();
        // Ghi log
        LogHelper::logAction('Vào trang hiển thị danh sách tài khoản người dùng đã xóa');
        return view('admin.user.deleted', compact('deletedUsers'));
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();
        // Ghi log
        LogHelper::logAction('Khôi phục tài khoản người dùng có id: ' . $user->id);
        return redirect()->route('user.deleted')->with('success', 'Employee restored successfully.');
    }
}
