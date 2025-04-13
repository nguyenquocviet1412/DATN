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
        return view('admin.color.index', compact('colors'));
    }

    public function create()
    {
        return view('admin.color.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|unique:colors,name',
    ], [
        'name.unique' => 'Tên màu này đã tồn tại.', // Tùy chỉnh thông báo lỗi
    ]);

    try {
        $color = Color::create($request->only('name')); // Chỉ lấy trường 'name'

        // Ghi log
        LogHelper::logAction('Thêm màu có ID: ' . $color->id);

        return redirect()->route('admin.color.index')->with('success', 'Màu đã được thêm thành công.');
    } catch (\Exception $e) {
        return redirect()->route('admin.color.index')->with('error', 'Có lỗi xảy ra khi thêm màu.');
    }
}


    public function edit($id)
    {
        $color = Color::findOrFail($id);
        return view('admin.color.edit', compact('color'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|unique:colors,name',
    ], [
        'name.unique' => 'Tên màu này đã tồn tại.', // Tùy chỉnh thông báo lỗi
    ]);

    try {
        $color = Color::findOrFail($id);
        $color->update($request->only('name'));
        // Ghi log
        LogHelper::logAction('Cập nhật màu có ID: ' . $color->id);
        return redirect()->route('admin.color.index')->with('success', 'Màu đã được cập nhật.');
    } catch (\Exception $e) {
        return redirect()->route('admin.color.index')->with('error', 'Có lỗi xảy ra khi cập nhật màu.');
    }
}
public function softDelete($id)
{
    $color = Color::findOrFail($id);
    // Kiểm tra xem màu có tồn tại trong các variant không
    if ($color->variants()->exists()) {
        return redirect()->back()->with('error', 'Không thể xóa màu này vì nó đang được sử dụng trong các biến thể.');
    }
    $color->delete(); // Xóa mềm
    // Ghi log
    LogHelper::logAction('Xóa màu có ID: ' . $color->id);
    return redirect()->route('admin.color.index')->with('success', 'Màu đã được xóa.');
}

public function restore($id)
{
    $color = Color::withTrashed()->findOrFail($id);

// Kiểm tra xem có màu nào cùng tên mà chưa bị xóa không
if (Color::where('name', $color->name)->whereNull('deleted_at')->exists()) {
    return redirect()->route('admin.color.index')->with('error', 'Không thể khôi phục vì đã tồn tại màu này.');
}

$color->restore();
// Ghi log
LogHelper::logAction('Khôi phục màu có ID: '. $color->id);
return redirect()->route('admin.color.index')->with('success', 'Màu đã được khôi phục.');

}

public function trash()
{
    $colors = Color::onlyTrashed()->paginate(10);
return view('admin.color.trash', compact('colors')); // Hiển thị danh sách đã xóa
}
public function destroy($id)
{
    try {
        $color= Color::withTrashed()->findOrFail($id);
        // Kiểm tra xem màu có tồn tại trong các variant không
        if ($color->variants()->exists()) {
            return redirect()->back()->with('error', 'Không thể xóa màu này vì nó đang được sử dụng trong các biến thể.');
        }
        $color->forceDelete();
        // Ghi log
        LogHelper::logAction('Xóa vĩnh viễn màu có ID: ' . $color->id);
        return redirect()->route('admin.color.index')->with('success', 'Màu đã bị xóa vĩnh viễn.');
    } catch (\Exception $e) {
        return redirect()->route('admin.color.index')->with('error', 'Có lỗi xảy ra khi xóa màu.');
    }

}
}
