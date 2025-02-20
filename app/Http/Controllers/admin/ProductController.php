<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller; // Thêm dòng này

use App\Models\Product;
use App\Models\Category;
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
        $products = $query->orderBy($sortBy, $sortOrder)->paginate(10);
    
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
        'quantity' => 'required|integer|min:1',
        'id_category' => 'required|exists:categories,id',
        'status' => 'required|boolean',
        'description' => 'nullable|string',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Tạo sản phẩm
    $product = Product::create([
        'name' => $request->name,
        'price' => $request->price,
        'id_category' => $request->id_category,
        'status' => $request->status,
        'description' => $request->description,
    ]);

    // Lưu biến thể (Variant)
    Variant::create([
        'id_product' => $product->id,
        'price' => $product->price,
        'quantity' => $request->quantity, // Đảm bảo quantity lấy đúng từ request
        'status' => 1
    ]);

    // Chuyển hướng với thông báo thành công
    return redirect()->route('product.index')->with('success', 'Sản phẩm đã được thêm thành công!');
}


public function edit($id)
{
    $product = Product::with('variants')->findOrFail($id);
    $categories = Category::all();
    return view('admin.editproduct', compact('product', 'categories'));
}

    

public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    // Validate dữ liệu đầu vào
    $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'id_category' => 'required|exists:categories,id',
        'status' => 'required|boolean',
    ]);

    // Cập nhật sản phẩm
    $product->update($request->only(['name', 'description', 'id_category', 'price', 'status']));

    // Cập nhật biến thể
    if ($request->has('variant_id')) {
        foreach ($request->variant_id as $index => $variantId) {
            $variant = Variant::find($variantId);
            if ($variant) {
                $variant->update([
                    'quantity' => $request->variant_quantity[$index],
                    'price' => $request->variant_price[$index],
                ]);
            }
        }
    }

    // Cập nhật ảnh sản phẩm nếu có
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('products', 'public');
        $product->update(['image' => $imagePath]);
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
