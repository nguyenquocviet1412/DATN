<?php

namespace App\Http\Controllers\admin;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        //
        $sortBy = $request->input('sort_by', 'id');
        $sortOrder = $request->input('sort_order', 'asc');
        $search = $request->input('search');

        $employees = Employee::orderBy('created_at', 'desc')->get();

        return view('admin.employee.index', compact('employees', 'sortBy', 'sortOrder', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $employees = Employee::all();
        // Ghi log
        LogHelper::logAction('Vào trang thêm nhân viên');
        return view('admin.employee.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'username' => 'required|string|max:255|unique:employees,username',
            'password' => 'required|string|max:255',
            'role' => 'required|string',
            'fullname' => 'required|string',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'required|numeric|unique:employees,phone',
            'gender' => 'required|string',
            'date_of_birth' => 'required|date',
            'address' => 'required|string',
            'position' => 'required|string',
            'status' => 'required|boolean',
        ]);
        //Kiểm tra xem tài khoản nhân viên có phải superadmin không
        $admin = Auth::guard('employee')->user(); // Lấy nhân viên đang đăng nhập
        if ($admin && $admin->role !='superadmin') {
            return redirect()->back()->withErrors(['error' => 'Bạn không có quyền thêm nhân viên mới.']);
        }

        $employees = Employee::create([
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('role'),
            'fullname' => $request->input('fullname'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'gender' => $request->input('gender'),
            'date_of_birth' => $request->input('date_of_birth'),
            'address' => $request->input('address'),
            'position' => $request->input('position'),
            'status' => $request->input('status'),
        ]);

        // Ghi log
        LogHelper::logAction('Tạo mới nhân viên có id: '. $employees->id);

        return redirect()->route('employee.index')->with('success', 'Tạo tài khoản nhân viên thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id, Request $request)
{
    $employee = Employee::findOrFail($id);

    // Lấy từ khóa tìm kiếm nếu có
    $search = $request->input('search');

    // Lấy danh sách logs có phân trang (10 logs/trang) và tìm kiếm nếu có từ khóa
    $logs = Log::where('id_employee', $id)
        ->when($search, function ($query, $search) {
            return $query->where('action', 'LIKE', "%{$search}%")
                         ->orWhere('details', 'LIKE', "%{$search}%");
        })
        ->orderBy('created_at', 'desc') // Sắp xếp mới nhất lên đầu
        ->paginate(10);
    return view('admin.employee.show', compact('employee', 'logs', 'search'));
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $employee = Employee::findOrFail($id);
        return view('admin.employee.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $admin = Auth::guard('employee')->user(); // Lấy tài khoản đang đăng nhập

    // Nếu tài khoản đăng nhập là "admin" nhưng muốn chỉnh sửa tài khoản khác -> Cấm
    if ($admin->role == 'admin' && $admin->id != $id) {
        return redirect()->back()->withErrors(['error' => 'Bạn không có quyền chỉnh sửa tài khoản này.']);
    }

    $request->validate([
        'username' => 'required|string|max:255|unique:employees,username,' . $id,
        'password' => 'nullable|string|max:255',
        'role' => 'required|string',
        'fullname' => 'required|string',
        'email' => 'required|email|unique:employees,email,' . $id,
        'phone' => 'required|numeric|unique:employees,phone,' . $id,
        'gender' => 'required|string',
        'date_of_birth' => 'required|date',
        'address' => 'required|string',
        'position' => 'required|string',
        'status' => 'required|boolean',
    ]);

    $employee = Employee::findOrFail($id);

    // Nếu tài khoản đăng nhập là admin -> Không cho phép thay đổi vai trò (role) và trạng thái (status)
    if ($admin->role == 'admin') {
        $request->merge([
            'role' => $employee->role, // Giữ nguyên role cũ
            'status' => $employee->status, // Giữ nguyên status cũ
        ]);
    }

    $employee->username = $request->input('username');
    if ($request->input('password')) {
        $employee->password = Hash::make($request->input('password'));
    }
    $employee->role = $request->input('role');
    $employee->fullname = $request->input('fullname');
    $employee->email = $request->input('email');
    $employee->phone = $request->input('phone');
    $employee->gender = $request->input('gender');
    $employee->date_of_birth = $request->input('date_of_birth');
    $employee->address = $request->input('address');
    $employee->position = $request->input('position');
    $employee->status = $request->input('status');

    $employee->save();

    // Ghi log
    LogHelper::logAction('Cập nhật thông tin nhân viên có id: ' . $employee->id);
    return redirect()->route('employee.index')->with('success', 'Cập nhật tài khoản nhân viên thành công');
}

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
{
    $admin = Auth::guard('employee')->user(); // Lấy tài khoản đăng nhập

    // Chỉ superadmin mới có quyền xóa
    if ($admin->role !== 'superadmin') {
        return redirect()->back()->withErrors(['error' => 'Bạn không có quyền xóa nhân viên.']);
    }

    $employee = Employee::findOrFail($id);

    // Không cho phép xóa chính mình để tránh mất quyền quản trị
    if ($admin->id == $employee->id) {
        return redirect()->back()->withErrors(['error' => 'Bạn không thể tự xóa tài khoản của mình.']);
    }

    $employee->delete();

    // Ghi log
    LogHelper::logAction('Xóa nhân viên có id: ' . $employee->id);

    return redirect()->route('employee.index')->with('success', 'Đã xóa nhân viên thành công.');
}

    public function deleted()
    {
        $deletedEmployees = Employee::onlyTrashed()->get();
        return view('admin.employee.deleted', compact('deletedEmployees'));
    }

    public function restore($id)
{
    $admin = Auth::guard('employee')->user(); // Lấy tài khoản đăng nhập

    // Chỉ superadmin mới có quyền khôi phục nhân viên
    if ($admin->role !== 'superadmin') {
        return redirect()->back()->withErrors(['error' => 'Bạn không có quyền khôi phục nhân viên.']);
    }

    $employee = Employee::onlyTrashed()->findOrFail($id);
    $employee->restore();

    // Ghi log
    LogHelper::logAction('Khôi phục nhân viên có id: ' . $employee->id);

    return redirect()->route('employee.deleted')->with('success', 'Nhân viên đã được khôi phục thành công.');
}
}
