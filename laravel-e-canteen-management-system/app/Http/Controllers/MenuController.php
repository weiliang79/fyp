<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function categoryIndex(){
        $user = User::find(Auth::user()->id);
        $categories = ProductCategory::all();

        if($user->isAdmin()){
            return view('admin.menus.category.index', compact('categories'));
        } else {

            if($user->store()->count() == 0){
                return redirect()->route('food_seller.store');
            }

            return view('food_seller.menus.category.index', compact('categories'));
        }
        
    }

    public function showCategoryCreateForm(){
        $category = null;
        return view('admin.menus.category.edit', compact('category'));
    }

    public function showCategoryEditForm($id){
        $category = ProductCategory::find($id);
        return view('admin.menus.category.edit', compact('category'));
    }

    public function saveCategory(Request $request){
        //dd($request);

        $request->validate([
            'name' => 'required',
        ]);

        ProductCategory::create([
            'name' => $request->name,
            'description' => $request->description ? $request->description : '',
        ]);

        return redirect()->route('admin.menus.category')->with('swal-success', 'Product Category Save Successful.');
    }

    public function updateCategory(Request $request){

        $request->validate([
            'id' => 'required|integer',
            'name' => 'required',
        ]);

        $category = ProductCategory::find($request->id);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        return redirect()->route('admin.menus.category')->with('swal-success', 'Category update successful.');
    }

    public function deleteCategory(Request $request){
        ProductCategory::destroy($request->id);
        return response()->json('Category delete successful.');
    }

    public function productIndex(){

        $user = User::find(Auth::user()->id);

        if($user->isAdmin()){

        } else {

            if($user->store()->count() == 0){
                return redirect()->route('food_seller.store');
            }

            $products = $user->store->products;

            return view('food_seller.menus.product.index', compact('products'));
        }
        
    }

    public function showProductCreateForm(){
        $categories = ProductCategory::all();
        return view('food_seller.menus.product.edit', compact('categories'));
    }

    public function saveProduct(Request $request){

        //dd($request);

        $request->validate([
            'name' => 'required',
            'category_id' => 'required|integer|gt:0',
            'barcode' => 'nullable|numeric',
            'price' => 'required|regex:/^[0-9]*(\.[0-9]{0,2})?$/',
            'optionName.*' => 'required',
            'optionDetail.*.*' => 'required',
            'additionalPrice.*.*' => 'numeric',
        ],
        [
            'category_id.gt' => 'The category field need to choose a category.',
            'optionName.*.required' => 'The optionName field is required.',
            'optionDetail.*.*.required' => 'The optionDetail field is required.',
            'additionalPrice.*.*.numeric' => 'The additional price field must be a number.',
        ]);

        //dd($request);

        $user = User::find(Auth::user()->id);

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'media_path' => $request->image_path,
            'barcode' => $request->barcode,
            'price' => $request->price,
            'status' => $request->status == 'on' ? true : false,
            'store_id' => $user->store->id,
            'category_id' => $request->category_id,
        ]);

        if($request->optionName){
            foreach($request->optionName as $key => $value){
                //echo $key.' => '.$value.' <br>';
                //echo 'Description => '. $request->optionDescription[$key] . '<br>';
                $option = $product->productOptions()->create([
                    'name' => $value,
                    'description' => $request->optionDescription[$key],
                ]);

                foreach($request->optionDetail[$key] as $key1 => $value1){
                    //echo $key1.' => '.$value1.' <br>';
                    //echo 'Price => '. $request->additionalPrice[$key][$key1] . '<br>';
                    $option->optionDetails()->create([
                        'name' => $value1,
                        'extra_price' => $request->additionalPrice[$key][$key1],
                    ]);
                }

            }
        }

        return redirect()->route('food_seller.menus.product')->with('swal-success', 'Product info save successful.');
    }

    public function deleteProduct(Request $request){
        $product = Product::find($request->id);

        $product->productOptions()->optionDetails()->destory();
        $product->productOptions()->destory();
        $product->destory();

        return response()->json('Product delete successful.');
    }
}
