<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Color;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::withTrashed()->paginate(10);
        // Ghi log
        LogHelper::logAction('Vào trang danh sách màu');
        return view('admin.color.index', compact('colors'));
    }

    public function create()
    {
        // Ghi log
        LogHelper::logAction('Vào trang tạo màu');
        return view('admin.color.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:colors,name', // Kiểm tra không được trùng tên
        ]);

        Color::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.color.index')->with('success', 'Màu đã được thêm thành công.');
    }

    public function edit($id)
    {
        $color = Color::findOrFail($id);
        return view('admin.color.edit', compact('color'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|unique:colors,name,' . $id,
    ]);

    $color = Color::findOrFail($id);
    $color->update($request->only('name')); // Sửa lại thành 'name' thay vì 'color'

    return redirect()->route('admin.color.index')->with('success', 'Màu đã được cập nhật.');
}
public function softDelete($id)
{
    $color = Color::findOrFail($id);
    $color->delete(); // Xóa mềm
    return redirect()->route('admin.color.index')->with('success', 'Màu đã được xóa.');
}

public function restore($id)
{
    $color = Color::withTrashed()->findOrFail($id);
    $color->restore(); // Khôi phục
    return redirect()->route('admin.color.index')->with('success', 'Màu đã được khôi phục.');
}

public function trash()
{
    $colors = Color::onlyTrashed()->paginate(10);
return view('admin.color.trash', compact('colors')); // Hiển thị danh sách đã xóa
}
public function destroy($id)
{
    $color = Color::withTrashed()->findOrFail($id);
    $color->forceDelete(); // Xóa vĩnh viễn
    return redirect()->route('admin.color.index')->with('success', 'Màu đã bị xóa vĩnh viễn.');
}
}
