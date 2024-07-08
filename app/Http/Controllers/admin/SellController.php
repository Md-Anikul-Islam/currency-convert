<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;use App\Models\Product;use App\Models\Sell;use Carbon\Carbon;use Illuminate\Http\Request;

class SellController extends Controller
{
    public function index()
    {
        $sell = Sell::latest()->get();
        $today = Carbon::today()->toDateString();
        $currency = Currency::whereDate('created_at', $today)->first();
        // Fallback if no currency rate is found for today
        if (!$currency) {
            return back()->with('error', 'Currency rate for today not found.');
        }

        $conversionRate = $currency->take;


        return view('admin.sell.index', compact('sell', 'conversionRate'));
    }

    public function sell(Request $request, $id)
    {
        $request->validate([
            'stock_sell' => 'required|numeric',
        ]);

        $sell = new Sell();
        $sell->product_id = $request->product_id;
        $sell->stock_sell = $request->stock_sell;
        $sell->save();

        //also update product table stock
        $product = Product::find($request->product_id);
        $product->available_stock = $product->available_stock - $request->stock_sell;
        $product->save();
        return redirect()->route('sell.section');
    }
}
