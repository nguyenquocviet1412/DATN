<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use App\Models\Variant;
use Illuminate\Http\Request;

class VariantConntroller extends Controller
{
    // Chức năng thêm, sửa, xóa biến thể
    public function variantCreate(Request $request,$productId){
        $product = Product::find($productId);
        if (!$product) {
            return redirect()->route('product.edit')->with('error', 'Sản phẩm không tồn tại.');
        }
        $colors= Color::get();
        $sizes = Size::get();
        return view('admin.addvariant',compact('product', 'colors', 'sizes'));
    }
public function variantStore(Request $request, $productId)
{
    $request->validate([
        'id_color' => 'required|exists:colors,id',
        'id_size' => 'required|exists:sizes,id',
        'price' => 'required|numeric',
        'quantity' => 'required|integer|min:1',
    ]);

    // Kiểm tra xem biến thể đã tồn tại chưa
    $existingVariant = Variant::where('id_product', $productId)
        ->where('id_color', $request->id_color)
        ->where('id_size', $request->id_size)
        ->first();

    if ($existingVariant) {
        return redirect()->back()->with('error', 'Biến thể này đã tồn tại!');
    }

    // Tạo biến thể mới
    Variant::create([
        'id_product' => $productId,
        'id_color' => $request->id_color,
        'id_size' => $request->id_size,
        'price' => $request->price,
        'quantity' => $request->quantity,
        'status' => $request->status ?? 1, // Mặc định còn hàng
    ]);

    return redirect()->route('product.edit')->with('success', 'Biến thể đã được thêm.');
}

public function variantUpdate(Request $request, $variantId)
{
    $variant = Variant::findOrFail($variantId);

    $request->validate([
        'price' => 'required|numeric',
        'quantity' => 'required|integer|min:1',
        'status' => 'required|boolean',
    ]);

    // Cập nhật thông tin
    $variant->update([
        'price' => $request->price,
        'quantity' => $request->quantity,
        'status' => $request->status,
    ]);

    return redirect()->back()->with('success', 'Biến thể đã được cập nhật.');
}

public function destroyVariant($variantId)
{
    $variant = Variant::findOrFail($variantId);
    $variant->delete();
    return redirect()->back()->with('success', 'Biến thể đã được xóa.');
}
}
