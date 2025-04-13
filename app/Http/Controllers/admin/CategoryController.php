<?php

namespace App\Http\Controllers\admin;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function categoryIndex()
    {
        $category = Category::whereNull('deleted_at')->get();

        return view('admin.category.category', compact('category'));
    }

    public function categoryCreate()
    {

        return view('admin.category.addcategory');
    }

    public function categoryStore(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        Category::create([
            'name' => $request->name,
        ]);

        $category = Category::whereNull('deleted_at')->get(); // Lấy lại danh sách danh mục sau khi thêm mới
        // Ghi log
        LogHelper::logAction('Tạo danh mục mới: ' . $request->name);
        return redirect()->route('category.index')->with('success', 'Thêm mới danh mục thành công');
    }

    // 🗑 Xóa mềm danh mục (Cập nhật deleted_at)
    public function categoryDelete($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return redirect()->route('category.index')->with('error', 'Danh mục không tồn tại!');
        }
        // Kiểm tra xem danh mục có tồn tại trong sản phẩm không
        if ($category->products()->exists()) {
            return redirect()->route('category.index')->with('error', 'Danh mục không thể xóa vì vẫn còn sản phẩm liên quan.');
        }

        $category->delete(); // Xóa mềm (Cập nhật deleted_at)
        // Ghi log
        LogHelper::logAction('Xóa mềm danh mục: ' . $category->name);
        return redirect()->route('category.index')->with('success', 'Danh mục đã được đưa vào thùng rác!');
    }
    // Lấy danh sách danh mục đã bị xóa mềm
    public function categoryTrash()
    {
        $categories = Category::onlyTrashed()->get();
        return view('admin.category.trash', compact('categories'));
    }

    // Khôi phục danh mục đã xóa mềm
    public function categoryRestore($id)
    {
        $category = Category::onlyTrashed()->find($id);

        if (!$category) {
            return redirect()->route('category.index')->with('error', 'Danh mục không tồn tại trong thùng rác');
        }

        $category->restore();
        // Ghi log
        LogHelper::logAction('Khôi phục danh mục: ' . $category->name);
        return redirect()->route('category.index')->with('success', 'Danh mục đã được khôi phục!');
    }

    // Xóa vĩnh viễn danh mục
    public function categoryForceDelete($id)
    {
        $category = Category::onlyTrashed()->find($id);

        if (!$category) {
            return redirect()->route('category.index')->with('error', 'Danh mục không tồn tại');
        }
        // Kiểm tra xem danh mục có tồn tại trong sản phẩm không
        if ($category->products()->exists()) {
            return redirect()->route('category.index')->with('error', 'Danh mục không thể xóa vĩnh viễn vì vẫn còn sản phẩm liên quan.');
        }

        $category->forceDelete(); // Xóa vĩnh viễn
        // Ghi log
        LogHelper::logAction('Xóa vĩnh viễn danh mục: ' . $category->name);
        return redirect()->route('category.index')->with('success', 'Danh mục đã bị xóa vĩnh viễn!');
    }



    public function categoryEdit($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return redirect()->route('category.index')->with('error', 'Danh mục không tồn tại');
        }
        // Ghi log
        LogHelper::logAction('Vào trang chỉnh sửa danh mục: ' . $category->name);
        return view('admin.category.editcategory', compact('category'));
    }

    public function categoryUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $category = Category::find($id);

        if (!$category) {
            return redirect()->route('category.index')->with('error', 'Danh mục không tồn tại');
        }

        $category->update([
            'name' => $request->name,
        ]);
        // Ghi log
        LogHelper::logAction('Cập nhật danh mục: ' . $category->name);
        return redirect()->route('category.index')->with('success', 'Cập nhật danh mục thành công');
    }


}
