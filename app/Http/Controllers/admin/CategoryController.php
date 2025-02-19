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
        return view('admin.category', compact('category'));
    }

    public function categoryCreate()
    {
        return view('admin.addcategory');
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
}
