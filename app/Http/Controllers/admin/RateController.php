<?php

namespace App\Http\Controllers\admin;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rate;

class RateController extends Controller
{
    public function Rindex()
    {
        $rates = Rate::selectRaw('id_product, MAX(id) as id, MAX(id_order_item) as id_order_item, AVG(rating) as average_rating')
                    ->groupBy('id_product')
                    ->get();
                    // dd($rates);
        return view('admin.rate.rate', compact('rates'));
    }

    public function show($id_product)
    {
        $rates = Rate::where('id_product', $id_product)->get();
        // Ghi log
        LogHelper::logAction('Xem chi tiết đánh giá sản phẩm có id: ' . $id_product);
        return view('admin.rate.show', compact('rates', 'id_product'));
    }


    public function Rdestroy($id)
    {
        $rate = Rate::findOrFail($id);
        $rate->delete();

        return redirect()->route('rate.index')->with('success', 'Rate deleted successfully.');
    }
}
