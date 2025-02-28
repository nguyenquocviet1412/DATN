<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rate;

class RateController extends Controller
{
    public function Rindex()
    {
        $rate = Rate::all();
        return view('admin.rate.rate', compact('rate'));
    }

    public function Rcreate()
    {
        return view('admin.addrate');
    }

    public function Rstore(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required',
            'status' => 'required',
        ]);

        Rate::create($request->all());

        return redirect()->route('rate.index')->with('success', 'Rate created successfully.');
    }

    public function Redit($id)
    {
        $rate = Rate::findOrFail($id);
        return view('admin.rate.editrate', compact('rate'));
    }

    public function Rupdate(Request $request, $id)
    {
        $request->validate([
            'id_user' => 'required',
            'id_product' => 'required',
            'id_order_item' => 'required',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required',
            'status' => 'required',
        ]);

        $rate = Rate::findOrFail($id);
        $rate->update($request->all());

        return redirect()->route('rate.index')->with('success', 'Rate updated successfully.');
    }

    public function Rdestroy($id)
    {
        $rate = Rate::findOrFail($id);
        $rate->delete();

        return redirect()->route('rate.index')->with('success', 'Rate deleted successfully.');
    }

}
