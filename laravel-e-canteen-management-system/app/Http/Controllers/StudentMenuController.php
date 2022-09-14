<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentMenuController extends Controller
{
    public function index(Request $request)
    {
        $allStores = Store::all();
        $allCategories = ProductCategory::all();

        if ($request->has('stores') || $request->has('categories')) {

            if ($request->has('stores') && $request->has('categories')) {
                $products = Product::where('status', true)
                    ->whereIn('store_id', $request->stores)
                    ->orWhereIn('category_id', $request->categories)
                    ->get();
            } else if ($request->has('categories')) {
                $products = Product::where('status', true)
                    ->whereIn('category_id', $request->categories)
                    ->get();
            } else {
                $products = Product::where('status', true)
                    ->whereIn('store_id', $request->stores)
                    ->get();
            }

            //dd($products);
        } else {
            $products = Product::where('status', true)->get();
        }

        return view('menu.index', compact('allStores', 'allCategories', 'products'));
    }

    public function getFoodOptions(Request $request)
    {
        $product = Product::find($request->id);
        $options = $product->productOptions;
        $details = array();

        foreach ($options as $option) {
            $temp = $option->optionDetails;
            foreach ($temp as $detail) {
                array_push($details, $detail);
            }
        }

        return response()->json([
            'product' => $product,
            'options' => $product->productOptions,
            'details' => $details,
        ]);
    }

    public function addCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
        ]);

        Cart::create([
            'student_id' => Auth::guard('student')->user()->id,
            'product_id' => $request->product_id,
            'product_options' => $request->options,
            'notes' => $request->notes,
        ]);

        return response()->json('Add to cart successful.');
    }
}
