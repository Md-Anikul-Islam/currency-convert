<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;use Illuminate\Http\Request;
use Toastr;
class CurrencyController extends Controller
{
        public function index()
        {
            $currency = Currency::all();
            return view('admin.currency.index', compact('currency'));
        }

        public function store(Request $request)
        {
            try {
                $request->validate([

                    'rupee' => 'required',
                ]);
                $currency = new Currency();
                $currency->take = $request->take;
                $currency->rupee = $request->rupee;
                $currency->save();
                Toastr::success('Currency Added Successfully', 'Success');
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
                    'take' => 'required',
                    'rupee' => 'required',
                ]);
                $currency = Currency::find($id);
                $currency->take = $request->take;
                $currency->rupee = $request->rupee;
                $currency->status = $request->status;
                $currency->save();
                Toastr::success('Currency Updated Successfully', 'Success');
                return redirect()->back();
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
            }
        }

        public function destroy($id)
        {
            try {
                $currency = Currency::find($id);
                $currency->delete();
                Toastr::success('Currency Deleted Successfully', 'Success');
                return redirect()->back();
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
            }
        }
}
