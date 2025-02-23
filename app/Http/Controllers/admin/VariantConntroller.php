<?php

namespace App\Http\Controllers\admin;

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

        return view('admin.addvariant',compact('product', 'colors','sizes'));
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

    // Tạo biến thể
    $variant = Variant::create([
        'id_product' => $product->id,
        'id_color' => $request->id_color,
        'id_size' => $request->id_size,
        'price' => $request->price,
        'quantity' => $request->quantity,
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
                'is_primary' => ($index === 0) ? 1 : 0,
            ]);
        }
    }

    return redirect()->route('product.edit', $productId)->with('success', 'Biến thể đã được thêm.');
}




    //Hiển thị trang sửa biến thể cho sản phẩm
    public function variantEdit($variantId){
        $variant = Variant::with('product', 'color','size', 'images')->findOrFail($variantId);
        $colors= Color::get();
        $sizes = Size::get();
        return view('admin.editvariant',compact('variant', 'colors','sizes'));
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
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Kiểm tra xem có biến thể khác đã tồn tại với id_color & id_size hay không
    $existingVariant = Variant::where('id_product', $variant->id_product)
        ->where('id_color', $request->id_color)
        ->where('id_size', $request->id_size)
        ->where('id', '!=', $variantId) // Loại trừ chính biến thể đang sửa
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

    // Xử lý ảnh biến thể
        if ($request->hasFile('image')) {
            // Lấy ảnh cũ
            $oldImage = $variant->images->first();

            // Kiểm tra nếu ảnh cũ tồn tại và không phải là URL hoặc khoảng trắng
            if ($oldImage && !filter_var($oldImage->image_url, FILTER_VALIDATE_URL) && trim($oldImage->image_url) !== '') {
                $oldImagePath = public_path($oldImage->image_url);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
                $oldImage->delete();
            }

            // Lưu ảnh mới
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = 'storage/product/' . $imageName;
            $image->move(public_path('storage/product'), $imageName);

            // Thêm ảnh mới vào DB
            Product_image::create([
                'id_variant' => $variant->id,
                'image_url' => $imagePath,
                'is_primary' => 1,
            ]);
        }

    return redirect()->back()->with('success', 'Biến thể đã được cập nhật.');
}

    // Xóa ảnh biến thể cho sản phẩm
public function deleteImage($imageId)
{
    $image = Product_image::findOrFail($imageId);
    $variant = $image->variant;

    // Kiểm tra xem ảnh có phải ảnh chính không
    $wasPrimary = $image->is_primary;

    if ($wasPrimary) {
        // Lấy tất cả ảnh của biến thể (trừ ảnh đang xóa)
        $remainingImages = $variant->images()->where('id', '!=', $imageId)->get();

        if ($remainingImages->count() > 0) {
            // Chọn ảnh thứ hai làm ảnh chính
            $newPrimaryImage = $remainingImages->skip(0)->first(); // Ảnh thứ hai trong danh sách
            $newPrimaryImage->update(['is_primary' => 1]);
        }
    }

    // Kiểm tra nếu đường dẫn ảnh không phải URL và không rỗng thì xóa file
    if (!filter_var($image->image_url, FILTER_VALIDATE_URL) && trim($image->image_url) !== '') {
        $imagePath = public_path($image->image_url);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    // Xóa ảnh khỏi cơ sở dữ liệu
    $image->delete();

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

    return redirect()->route('product.edit', $productId)->with('success', 'Biến thể và ảnh liên quan đã được xóa.');
    }
}
