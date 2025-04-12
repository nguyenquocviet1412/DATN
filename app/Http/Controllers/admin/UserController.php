<?php

namespace App\Http\Controllers\admin;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
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

        $users = User::orderBy('created_at', 'desc')->get();

        return view('admin.user.index', compact('users', 'sortBy', 'sortOrder', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $users = User::all();
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
        'birthday' => 'date',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|numeric|unique:users,phone',
        'address' => 'required|string',
    ]);

    // Tạo tài khoản người dùng
    $user = User::create([
        'password' => Hash::make($request->input('password')),
        'fullname' => $request->input('fullname'),
        'birthday' => $request->input('birthday'),
        'email' => $request->input('email'),
        'phone' => $request->input('phone'),
        'address' => $request->input('address'),
        'gender' => $request->input('gender'),
    ]);

    // Ghi log thao tác
    LogHelper::logAction('Tạo mới tài khoản người dùng có id: ' . $user->id);

    return redirect()->route('user.index')->with('success', 'Tài khoản người dùng đã được tạo thành công.');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
{
    $user = User::findOrFail($id);

    return view('admin.user.show', compact('user'));
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'password' => 'nullable|string|max:255',
            'fullname' => 'required|string',
            'birthday' => 'required|date',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|numeric|unique:users,phone,' . $id,
            'address' => 'required|string',
            'status' => 'required|boolean',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'password' => $request->input('password') ? Hash::make($request->input('password')) : $user->password,
            'fullname' => $request->input('fullname'),
            'birthday' => $request->input('birthday'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'status' => $request->input('status')
        ]);
        // Ghi log
        LogHelper::logAction('Cập nhật tài khoản người dùng có id: ' . $user->id);

        return redirect()->route('user.index')->with('success', ' Tài khoản người dùng đã được cập nhật thành công.');
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
        return redirect()->route('user.index')->with('success', 'Tài khoản người dùng đã được xóa.');
    }

    public function deleted()
    {
        $deletedUsers = User::onlyTrashed()->get();
        return view('admin.user.deleted', compact('deletedUsers'));
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();
        // Ghi log
        LogHelper::logAction('Khôi phục tài khoản người dùng có id: ' . $user->id);
        return redirect()->route('user.deleted')->with('success', 'Đã khôi phục tài khoản người dùng.');
    }
}
