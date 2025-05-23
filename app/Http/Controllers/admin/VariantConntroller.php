<?php

namespace App\Http\Controllers\admin;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Order_item;
use App\Models\Product;
use App\Models\Product_image;
use App\Models\Size;
use App\Models\Variant;
use Illuminate\Http\Request;

class VariantConntroller extends Controller
{
    // Chức năng thêm, sửa, xóa biến thể

    // Hiển thị trang thêm biến thể mới cho sản phẩm
    public function variantCreate(Request $request, $productId){
        $product = Product::find($productId);
        if (!$product) {
            return redirect()->route('product.edit', $productId)->with('error', 'Sản phẩm không tồn tại.');
        }

        $colors = Color::all();
        $sizes = Size::all();

        // Ghi log
        LogHelper::logAction('Vào trang thêm biến thể cho sản phẩm có ID: ' . $productId);
        return view('admin.product.addvariant',compact('product', 'colors','sizes'));
    }
    //hàm tạo viết tắt
    private function generateAcronym($text)
    {
        return strtoupper(collect(explode(' ', $text))->map(fn($word) => $word[0])->implode(''));
    }

    // Thêm biến thể mới vào sản phẩm
    public function variantStore(Request $request, $productId)
{
    $request->validate([
        'id_color' => 'required|exists:colors,id',
        'id_size' => 'required|exists:sizes,id',
        'price' => 'required|numeric',
        'quantity' => 'required|integer|min:1',
        'images' => 'required',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $product = Product::findOrFail($productId);

    // Kiểm tra biến thể đã tồn tại chưa
    if ($product->variants()->where('id_color', $request->id_color)->where('id_size', $request->id_size)->exists()) {
        return redirect()->route('product.edit', $productId)->with('error', 'Biến thể đã tồn tại.');
    }
    // tạo sku
    $productAcronym = $this->generateAcronym($product->name);
    $color = Color::find($request['id_color']);
    $size = Size::find($request['id_size']);
    $colorAcronym = $this->generateAcronym($color->name ?? '');

    // Tạo biến thể
    $variant = Variant::create([
        'id_product' => $product->id,
        'id_color' => $request->id_color,
        'id_size' => $request->id_size,
        'price' => $request->price,
        'quantity' => $request->quantity,
        'sku' => $product->id . $productAcronym . $colorAcronym . $size->size,
    ]);

    if (!$variant) {
        return redirect()->route('product.edit', $productId)->with('error', 'Lỗi khi thêm biến thể.');
    }

    // Lưu ảnh biến thể
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $index => $image) {
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = 'storage/product/' . $imageName;
            $image->move(public_path('storage/product'), $imageName);

            Product_image::create([
                'id_variant' => $variant->id,
                'image_url' => $imagePath,
            ]);
        }
    }

        // Ghi log
        LogHelper::logAction('Thêm biến thể có ID:' .$variant->id. ' cho sản phẩm có ID: ' . $productId);

    return redirect()->route('product.edit', $productId)->with('success', 'Biến thể đã được thêm.');
}




    //Hiển thị trang sửa biến thể cho sản phẩm
    public function variantEdit($variantId){
        $variant = Variant::with('product', 'color','size', 'images')->findOrFail($variantId);
        $colors= Color::get();
        $sizes = Size::get();

        // Ghi log
        LogHelper::logAction('Vào trang chỉnh sửa biến thể có ID: ' . $variantId);
        return view('admin.product.editvariant',compact('variant', 'colors','sizes'));
    }

    // Cập nhật biến thể cho sản phẩm
public function variantUpdate(Request $request, $variantId)
{
    $variant = Variant::findOrFail($variantId);

    $request->validate([
        'id_color' => 'required|exists:colors,id',
        'id_size' => 'required|exists:sizes,id',
        'price' => 'required|numeric',
        'quantity' => 'required|integer|min:1',
        'status' => 'required|boolean',
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Hỗ trợ nhiều ảnh
    ]);

    // Kiểm tra xem biến thể khác đã tồn tại chưa
    $existingVariant = Variant::where('id_product', $variant->id_product)
        ->where('id_color', $request->id_color)
        ->where('id_size', $request->id_size)
        ->where('id', '!=', $variantId)
        ->first();

    if ($existingVariant) {
        return redirect()->back()->with('error', 'Biến thể với màu sắc và kích thước này đã tồn tại.');
    }

    // Cập nhật thông tin biến thể
    $variant->update([
        'id_color' => $request->id_color,
        'id_size' => $request->id_size,
        'price' => $request->price,
        'quantity' => $request->quantity,
        'status' => $request->status,
    ]);

    // Xử lý nhiều ảnh
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = 'storage/product/' . $imageName;
            $image->move(public_path('storage/product'), $imageName);

            // Thêm ảnh mới vào DB
            Product_image::create([
                'id_variant' => $variant->id,
                'image_url' => $imagePath,
            ]);
        }
    }
    // Ghi log
    LogHelper::logAction('Cập nhật biến thể có ID:' .$variantId. ' cho sản phẩm có ID: '. $variant->id_product);
    return redirect()->back()->with('success', 'Biến thể đã được cập nhật.');
}


    // Xóa ảnh biến thể cho sản phẩm
public function deleteImage($imageId)
{
    $image = Product_image::findOrFail($imageId);

    // Kiểm tra nếu đường dẫn ảnh không phải URL và không rỗng thì xóa file
    if (!filter_var($image->image_url, FILTER_VALIDATE_URL) && trim($image->image_url) !== '') {
        $imagePath = public_path($image->image_url);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    // Xóa ảnh khỏi cơ sở dữ liệu
    $image->delete();

        // Ghi log
        LogHelper::logAction('Xóa ảnh biến thể có ID: ' . $image->id_variant);
    return redirect()->back()->with('success', 'Ảnh biến thể đã được xóa.');
}



    // Xóa biến thể cho sản phẩm
    public function variantDelete($variantId)
    {
        $variant = Variant::findOrFail($variantId);
    $productId = $variant->id_product;

    // Kiểm tra nếu biến thể tồn tại trong bảng order_items
    if (Order_item::where('id_variant', $variantId)->exists()) {
        return redirect()->route('product.edit', $productId)->with('error', 'Không thể xóa biến thể vì nó đã có trong đơn hàng.');
    }

    // Lấy danh sách ảnh của biến thể
    $images = $variant->images;

    // Xóa từng ảnh trong thư mục
    foreach ($images as $image) {
        $imagePath = public_path('storage/product/' . basename($image->image_url));
        if (file_exists($imagePath)) {
            unlink($imagePath); // Xóa file ảnh khỏi thư mục
        }
    }

    // Xóa tất cả dữ liệu ảnh trong bảng Product_image
    Product_image::where('id_variant', $variantId)->delete();

    // Xóa biến thể
    $variant->delete();
    // Ghi log
    LogHelper::logAction('Xóa biến thể có ID: ' . $variantId . ' của sản phẩm có ID: ' . $productId);
    return redirect()->route('product.edit', $productId)->with('success', 'Biến thể và ảnh liên quan đã được xóa.');
    }
}
