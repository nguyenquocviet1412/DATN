<?php

namespace App\Http\Controllers\admin;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Log;
use Illuminate\Http\Request;
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

        $employees = Employee::all();

        // Ghi log
        LogHelper::logAction('Vào trang hiển thị danh sách nhân viên');
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

        return redirect()->route('employee.index')->with('success', 'Employee created successfully');
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
// Ghi log
LogHelper::logAction('Xem thông tin nhân viên có id: ' . $employee->id);
    return view('admin.employee.show', compact('employee', 'logs', 'search'));
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $employee = Employee::findOrFail($id);

        // Ghi log
        LogHelper::logAction('Vào trang chỉnh sửa nhân viên có id: ' . $employee->id);
        return view('admin.employee.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
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
        return redirect()->route('employee.index')->with('success', 'Employee updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        // Ghi log
        LogHelper::logAction('Xóa nhân viên có id: ' . $employee->id);
        return redirect()->route('employee.index')->with('success', 'Employee deleted successfully.');
    }

    public function deleted()
    {
        $deletedEmployees = Employee::onlyTrashed()->get();
        // Ghi log
        LogHelper::logAction('Vào trang danh sách nhân viên đã xóa');
        return view('admin.employee.deleted', compact('deletedEmployees'));
    }

    public function restore($id)
    {
        $employee = Employee::onlyTrashed()->findOrFail($id);
        $employee->restore();
        // Ghi log
        LogHelper::logAction('Khôi phục nhân viên có id: ' . $employee->id);
        return redirect()->route('employee.deleted')->with('success', 'Employee restored successfully.');
    }
}
