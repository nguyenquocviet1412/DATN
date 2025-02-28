<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function categoryIndex()
    {
        $category = Category::all();
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

        $category = Category::all(); // Lấy lại danh sách danh mục sau khi thêm mới

        return redirect()->route('category.index')->with('success', 'Thêm mới danh mục thành công');
    }
    public function categoryDelete($id)
{
    $category = Category::find($id);

    if (!$category) {
        return redirect()->route('category.index')->with('error', 'Danh mục không tồn tại!');
    }

    // Kiểm tra nếu danh mục có sản phẩm liên kết
    if ($category->products()->exists()) {
        return redirect()->route('category.index')->with('error', 'Không thể xóa! Danh mục này có sản phẩm liên quan liên quan.');
    }

    $category->delete();

    return redirect()->route('category.index')->with('success', 'Xóa danh mục thành công!');
}

    public function categoryEdit($id)
{
    $category = Category::find($id);

    if (!$category) {
        return redirect()->route('category.index')->with('error', 'Danh mục không tồn tại');
    }

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

    return redirect()->route('category.index')->with('success', 'Cập nhật danh mục thành công');
}


}
