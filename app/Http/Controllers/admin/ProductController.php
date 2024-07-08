<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;use App\Models\Product;use Carbon\Carbon;use Illuminate\Http\Request;
use Toastr;
class ProductController extends Controller
{
        public function index()
        {
            $product = Product::all();

            $today = Carbon::today()->toDateString();
            $currency = Currency::whereDate('created_at', $today)->first();


            // Fallback if no currency rate is found for today
            if (!$currency) {
                return back()->with('error', 'Currency rate for today not found.');
            }

            $conversionRate = $currency->take;

            return view('admin.product.index', compact('product', 'conversionRate'));
        }

        public function store(Request $request)
        {
            try {
                $request->validate([
                    'name' => 'required',

                ]);
                $product = new Product();
                $product->name = $request->name;
                $product->india_price = $request->india_price;
                $product->stock = $request->stock;
                $product->available_stock = $request->stock;
                $product->save();
                Toastr::success('Product Added Successfully', 'Success');
                return redirect()->back();
            } catch (\Exception $e) {
                // Handle the exception here
                return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
            }
        }

        public function update(Request $request, $id)
        {
            try {
                $request->validate([
                    'name' => 'required',

                ]);
                $product = Product::find($id);
                $product->name = $request->name;
                $product->india_price = $request->india_price;
                $product->status = $request->status;
                $product->save();
                Toastr::success('Product Updated Successfully', 'Success');
                return redirect()->back();
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
            }
        }

        public function destroy($id)
        {
            try {
                $product = Product::find($id);
                $product->delete();
                Toastr::success('Product Deleted Successfully', 'Success');
                return redirect()->back();
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
            }
        }
}
