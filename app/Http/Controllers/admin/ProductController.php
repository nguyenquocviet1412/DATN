<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller; // Thêm dòng này

use App\Models\Product;
use App\Models\Category;
use App\Models\Product_image;
use App\Models\Variant;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Hiển thị danh sách sản phẩm
    public function index(Request $request)
    {
        $sortBy = $request->input('sort_by', 'id'); // Mặc định sắp xếp theo ID
        $sortOrder = $request->input('sort_order', 'asc'); // Mặc định tăng dần
        $search = $request->input('search'); // Lấy giá trị tìm kiếm

        $query = Product::with('category', 'variants');

        // Nếu có từ khóa tìm kiếm, thực hiện lọc theo tên sản phẩm
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Thực hiện sắp xếp theo yêu cầu
        $products = Product::with(['category', 'variants.images'])->orderBy($sortBy, $sortOrder)->paginate(10);

        return view('admin.product', compact('products', 'sortBy', 'sortOrder', 'search'));
    }


    // Hiển thị form thêm sản phẩm
    public function create()
    {
        $categories = Category::all();
        return view('admin.addproduct', compact('categories'));
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'id_category' => 'required|exists:categories,id',
        'status' => 'required|boolean',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'image_url' => 'nullable|url',
    ]);

    $product = Product::create($request->only(['name', 'description', 'id_category', 'price', 'status']));

    // Lưu ảnh từ file hoặc link
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('products', 'public');
        Product_image::create([
            'id_variant' => null,
            'image_url' => 'storage/' . $imagePath,
            'is_primary' => 1,
        ]);
    } elseif ($request->image_url) {
        Product_image::create([
            'id_variant' => null,
            'image_url' => $request->image_url,
            'is_primary' => 1,
        ]);
    }

    return redirect()->route('product.index')->with('success', 'Sản phẩm đã được thêm.');
}

// Hiển thị form sửa
public function edit($id)
{
    $product = Product::with('variants')->findOrFail($id);
    $categories = Category::all();
    return view('admin.editproduct', compact('product', 'categories'));
}



// Cập nhật sản phẩm
public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);
    $product->update($request->only(['name', 'description', 'id_category', 'price', 'status']));

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('product', 'public');
        Product_image::updateOrCreate(
            ['id_variant' => null, 'is_primary' => 1],
            ['image_url' => 'storage/product' . $imagePath]
        );
    }

    return redirect()->route('product.index')->with('success', 'Sản phẩm đã được cập nhật.');
}


    // Xóa sản phẩm
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->variants()->delete(); // Xóa biến thể trước khi xóa sản phẩm
        $product->delete();

        return redirect()->route('product.index')->with('success', 'Sản phẩm đã được xóa.');
    }
}
