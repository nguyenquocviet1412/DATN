<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogHelper;
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
            'size' => 'required|string|unique:sizes,size',
        ], [
            'size.unique' => 'Kích thước này đã tồn tại.', // Tùy chỉnh thông báo lỗi
            'size.required' => 'Vui lòng nhập kích thước.',
        ]);
        // Kiểm tra xem kích thước đã tồn tại chưa
        $existingSize = Size::where('size', $request->size)->first();
        if ($existingSize) {
            return redirect()->route('admin.size.index')->with('error', 'Kích thước đã tồn tại.');
        }
        // Nếu chưa tồn tại, tiến hành thêm mới

        try {
            $size = Size::create($request->all());
            // Ghi log
            LogHelper::logAction('Thêm mới kích thước mới có id: '. $size->id);
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
    // Kiểm tra trùng lặp nhưng bỏ qua ID hiện tại
    $request->validate([
        'size' => 'required|string|unique:sizes,size,' . $id,
    ], [
        'size.unique' => 'Size đã tồn tại.', // Tùy chỉnh thông báo lỗi
    ]);
    // Nếu chưa tồn tại, tiến hành cập nhật

    try {
        $size = Size::findOrFail($id);
        $size->update($request->only('size'));
        // Ghi log
        LogHelper::logAction('Cập nhật kích thước có id: '. $size->id);

        return redirect()->route('admin.size.index')->with('success', 'Kích thước đã được cập nhật.');
    } catch (\Exception $e) {
        return redirect()->route('admin.size.index')->with('error', 'Có lỗi xảy ra khi cập nhật kích thước.');
    }
}

public function softDelete($id)
{
    $size = Size::findOrFail($id);
    $size->delete(); // Xóa mềm
    // Ghi log
    LogHelper::logAction('Xóa kích thước có id: '. $size->id);
    return redirect()->route('admin.size.index')->with('success', 'Kích thước đã được xóa.');
}

public function restore($id)
{
    $size = Size::withTrashed()->findOrFail($id);
    $size->restore(); // Khôi phục
    // Ghi log
    LogHelper::logAction('Khôi phục kích thước có id: '. $size->id);
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
        // Kiểm tra có tồn tại trong variant không
        if ($size->variants()->exists()) {
            return redirect()->back()->with('error', 'Không thể xóa kích thước này vì nó đang được sử dụng trong các biến thể.');
        }
        // Xóa vĩnh viễn
        $size->forceDelete();
        // Ghi log
        LogHelper::logAction('Xóa vĩnh viễn kích thước có id: '. $size->id);
        return redirect()->route('admin.size.index')->with('success', 'Kích thước đã bị xóa vĩnh viễn.');
    } catch (\Exception $e) {
        return redirect()->route('admin.size.index')->with('error', 'Có lỗi xảy ra khi xóa kích thước.');
    }
}
}
