<?php

namespace App\Http\Controllers\admin;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller; // Thêm dòng này

use App\Models\Product;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product_image;
use App\Models\Size;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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

        // Ghi log
        LogHelper::logAction('Vào trang hiển thị danh sách sản phẩm');
        return view('admin.product.product', compact('products', 'sortBy', 'sortOrder', 'search'));
    }


    // Hiển thị form thêm sản phẩm
    public function create()
    {
        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();

        // Ghi log
        LogHelper::logAction('Vào trang thêm sản phẩm');
        return view('admin.product.addproduct', compact('categories', 'colors', 'sizes'));
    }

    // Thêm sản phẩm
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'id_category' => 'required|exists:categories,id',
        'price' => 'required|numeric|min:0',
        'status' => ['required', Rule::in(['active','inactive'])], // Cập nhật trạng thái
    ]);

    // Tạo sản phẩm mới
    $product = Product::create([
        'name' => $request->name,
        'description' => $request->description,
        'id_category' => $request->id_category,
        'price' => $request->price,
        'status' => $request->status,
    ]);

    // Kiểm tra xem có biến thể nào được gửi lên không
    if ($request->has('variants')) {
        foreach ($request->variants as $variantData) {
            if (!isset($variantData['id_color'], $variantData['id_size'], $variantData['price'], $variantData['quantity'])) {
                continue;
            }

            // Thêm biến thể mới
            $variant = Variant::create([
                'id_product' => $product->id,
                'id_color' => $variantData['id_color'],
                'id_size' => $variantData['id_size'],
                'price' => $variantData['price'],
                'quantity' => $variantData['quantity'],
            ]);

            // Kiểm tra nếu có ảnh được tải lên
            if ($variant && isset($variantData['images'])) {
                foreach ($variantData['images'] as $index => $image) {
                    if ($image->isValid()) {
                        $imageName = time() . '_' . $image->getClientOriginalName();
                        $image->move(public_path('storage/product'), $imageName);

                        Product_image::create([
                            'id_variant' => $variant->id,
                            'image_url' => 'storage/product/' . $imageName,
                            'is_primary' => ($index === 0) ? 1 : 0,
                        ]);
                    }
                }
            }
        }
    }

    // Ghi log
    LogHelper::logAction('Thêm sản phẩm mới có id: ' . $product->id);
    return redirect()->route('product.index')->with('success', 'Sản phẩm và biến thể đã được thêm.');
}


// Hiển thị form sửa
public function edit($id)
{
    $product = Product::with('variants')->findOrFail($id);
    $categories = Category::all();
    $colors = Color::all();
    $sizes = Size::all();

    // Ghi log
    LogHelper::logAction('Vào trang sửa sản phẩm: ' . $product->id);
    return view('admin.product.editproduct', compact('product', 'categories'));
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
    // Ghi log
    LogHelper::logAction('Cập nhật sản phẩm có id: ' . $product->id);
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
