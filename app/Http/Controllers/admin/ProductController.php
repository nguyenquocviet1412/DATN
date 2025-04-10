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
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    // Hiển thị danh sách sản phẩm
    public function index(Request $request)
    {
        $sortBy = $request->input('sort_by', 'id'); // Mặc định sắp xếp theo ID
        $sortOrder = $request->input('sort_order', 'desc'); // Mặc định tăng dần
        $search = $request->input('search'); // Lấy giá trị tìm kiếm

        $query = Product::with(['category', 'variants.images']);

        // Nếu có từ khóa tìm kiếm, thực hiện lọc theo tên sản phẩm
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Thực hiện sắp xếp theo yêu cầu
        $products = $query->orderBy($sortBy, $sortOrder)->get();

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

    //hàm tạo viết tắt
    private function generateAcronym($text)
    {
        return strtoupper(collect(explode(' ', $text))->map(fn($word) => $word[0])->implode(''));
    }
    // Thêm sản phẩm
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'id_category' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'status' => ['required', Rule::in(['active', 'inactive'])], // Cập nhật trạng thái
        ]);

        $category = Category::find($request->id_category);
        $categoryAcronym = $this->generateAcronym($category->name);
        $timestamp = now()->format('dmYHis');
        // Tạo sản phẩm mới
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'id_category' => $request->id_category,
            'price' => $request->price,
            'status' => $request->status,
            'sku' => $categoryAcronym . $timestamp,
        ]);
        // Ghi log
        LogHelper::logAction('Thêm sản phẩm mới có id: ' . $product->id);
        $variantCombinations = [];

        // Kiểm tra xem có biến thể nào được gửi lên không
        if ($request->has('variants')) {
            foreach ($request->variants as $variantData) {
                if (!isset($variantData['id_color'], $variantData['id_size'], $variantData['price'], $variantData['quantity'])) {
                    continue;
                }

                // Tạo khóa duy nhất cho biến thể (màu sắc + size)
                $variantKey = $variantData['id_color'] . '-' . $variantData['id_size'];
                if (in_array($variantKey, $variantCombinations)) {
                    return redirect()->back()->withInput()->with('error', 'Có biến thể bị trùng màu sắc và kích thước. Vui lòng kiểm tra lại.');
                }
                $variantCombinations[] = $variantKey;


                $productAcronym = $this->generateAcronym($request->name);
                $color = Color::find($variantData['id_color']);
                $size = Size::find($variantData['id_size']);
                $colorAcronym = $this->generateAcronym($color->name ?? '');
                // Thêm biến thể mới
                $variant = Variant::create([
                    'id_product' => $product->id,
                    'id_color' => $variantData['id_color'],
                    'id_size' => $variantData['id_size'],
                    'price' => $variantData['price'],
                    'quantity' => $variantData['quantity'],
                    'sku' => $product->id . $productAcronym . $colorAcronym . $size->size,
                ]);
                // Ghi log
                LogHelper::logAction('Thêm biến thể mới có id: ' . $variant->id . ' cho sản phẩm có id: ' . $product->id);

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


        return redirect()->route('product.index')->with('success', 'Sản phẩm và biến thể đã được thêm.');
    }



    // Hiển thị form sửa
    public function edit($id)
    {
        $product = Product::with('variants.images', 'variants.color', 'variants.size')->findOrFail($id);
        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();

        return view('admin.product.editproduct', compact('product', 'categories', 'colors', 'sizes'));
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

        $product->delete(); // Xoá mềm sản phẩm

        return redirect()->route('product.index')->with('success', 'Sản phẩm đã được xóa (mềm).');
    }


    //Cập nhật tất cả
    public function updateAll(Request $request, $id)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'id_category' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'status' => 'required|boolean',
            'variants.*.id' => 'required|exists:variants,id',
            'variants.*.id_color' => 'required|exists:colors,id',
            'variants.*.id_size' => 'required|exists:sizes,id',
            'variants.*.price' => 'required|numeric',
            'variants.*.quantity' => 'required|integer|min:1',
            'deleted_images' => 'array',
            'deleted_images.*' => 'exists:product_images,id',
            'variant_images.*.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $product->update([
            'name' => $request->name,
            'id_category' => $request->id_category,
            'price' => $request->price,
            'status' => $request->status,
        ]);

        // Cập nhật biến thể
        foreach ($request->variants as $variantData) {
            $variant = Variant::findOrFail($variantData['id']);
            $variant->update([
                'id_color' => $variantData['id_color'],
                'id_size' => $variantData['id_size'],
                'price' => $variantData['price'],
                'quantity' => $variantData['quantity'],
            ]);

            // Thêm ảnh mới nếu có
            if ($request->hasFile("variant_images.{$variant->id}")) {
                foreach ($request->file("variant_images.{$variant->id}") as $image) {
                    $path = $image->store('product', 'public'); // Lưu ảnh vào storage/app/public/product
                    Product_image::create([
                        'id_variant' => $variant->id,
                        'image_url' => 'storage/' . $path,
                    ]);
                }
            }
        }

        // Xóa ảnh đã chọn
        if (!empty($request->deleted_images)) {
            foreach ($request->deleted_images as $imageId) {
                $image = Product_image::find($imageId);
                if ($image) {
                    Storage::delete($image->image_url);
                    $image->delete();
                }
            }
        }

        return redirect()->back()->with('success', 'Sản phẩm và biến thể đã được cập nhật.');
    }
    // Hiển thị danh sách sản phẩm đã bị xóa mềm (có kèm ảnh, danh mục, tìm kiếm, sắp xếp)
public function trashed(Request $request)
{
    $sortBy = $request->input('sort_by', 'id'); // Mặc định sắp xếp theo ID
    $sortOrder = $request->input('sort_order', 'desc'); // Mặc định giảm dần
    $search = $request->input('search'); // Từ khóa tìm kiếm

    $query = Product::onlyTrashed()->with(['category', 'variants.images']); // Load quan hệ

    // Sắp xếp kết quả
    $trashedProducts = $query->orderBy($sortBy, $sortOrder)->paginate(10);

    // Trả về view kèm dữ liệu
    return view('admin.product.trashed', compact('trashedProducts', 'sortBy', 'sortOrder', 'search'));
}


    // Khôi phục một sản phẩm đã bị xóa mềm
    public function restore($id)
    {
        // Tìm sản phẩm đã bị xóa mềm theo ID, nếu không tồn tại thì trả về lỗi
        $product = Product::onlyTrashed()->findOrFail($id);

        // Khôi phục sản phẩm về trạng thái hoạt động
        $product->restore();

        // Quay lại trang trước với thông báo thành công
        return redirect()->back()->with('success', 'Đã khôi phục sản phẩm.');
    }

    // Xóa vĩnh viễn một sản phẩm khỏi database (không thể khôi phục)
    public function forceDelete($id)
    {
        // Tìm sản phẩm đã bị xóa mềm theo ID, nếu không tồn tại thì trả về lỗi
        $product = Product::onlyTrashed()->findOrFail($id);

        // Xóa vĩnh viễn sản phẩm khỏi cơ sở dữ liệu
        $product->forceDelete();

        // Quay lại trang trước với thông báo thành công
        return redirect()->back()->with('success', 'Đã xóa vĩnh viễn sản phẩm.');
    }


}
