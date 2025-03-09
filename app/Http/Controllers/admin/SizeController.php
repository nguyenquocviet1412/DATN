<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Size;

class SizeController extends Controller
{
    public function index()
    {
        $sizes = Size::withTrashed()->get();
        return view('admin.size.index', compact('sizes'));
    }

    public function create()
    {
        return view('admin.size.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'size' => 'required|unique:sizes,size',
        ]);

        try {
            Size::create($request->all());
            return redirect()->route('admin.size.index')->with('success', 'Kích thước đã được thêm thành công.');
        } catch (\Exception $e) {
            return redirect()->route('admin.size.index')->with('error', 'Có lỗi xảy ra khi thêm kích thước.');
        }
    }

    public function edit($id)
    {
        $size = Size::findOrFail($id);
        return view('admin.size.edit', compact('size'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'size' => 'required|string|unique:sizes,size,' . $id, // Kiểm tra trùng lặp nhưng bỏ qua ID hiện tại
    ]);

    try {
        $size = Size::findOrFail($id);
        $size->update($request->only('size'));

        return redirect()->route('admin.size.index')->with('success', 'Kích thước đã được cập nhật.');
    } catch (\Exception $e) {
        return redirect()->route('admin.size.index')->with('error', 'Có lỗi xảy ra khi cập nhật kích thước.');
    }
}

public function softDelete($id)
{
    $size = Size::findOrFail($id);
    $size->delete(); // Xóa mềm
    return redirect()->route('admin.size.index')->with('success', 'Kích thước đã được xóa.');
}

public function restore($id)
{
    $size = Size::withTrashed()->findOrFail($id);
    $size->restore(); // Khôi phục
    return redirect()->route('admin.size.index')->with('success', 'Kích thước đã được khôi phục.');
}

public function trash()
{
    $sizes = Size::onlyTrashed()->get();
    return view('admin.size.trash', compact('sizes')); // Hiển thị danh sách đã xóa
}
public function destroy($id)
{
    try {
        $size = Size::withTrashed()->findOrFail($id);
        $size->forceDelete();
        return redirect()->route('admin.size.index')->with('success', 'Kích thước đã bị xóa vĩnh viễn.');
    } catch (\Exception $e) {
        return redirect()->route('admin.size.index')->with('error', 'Có lỗi xảy ra khi xóa kích thước.');
    }
}
}
