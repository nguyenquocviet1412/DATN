<?php 

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;

use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DetailProductController extends Controller
{
    public function show($id)
    {
        $product = Product::with('variants')->findOrFail($id);
        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();
        
        $product->load('rates');
        $averageRating = $product->rates->avg('rating');

        return view('home.detailproduct', compact('product', 'categories', 'colors', 'sizes', 'averageRating'));
    }
}