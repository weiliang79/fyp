<?php

namespace App\Http\Controllers;

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

    public function foodIndex(){

        $user = User::find(Auth::user()->id);

        if($user->isAdmin()){

        } else {
            return view('food_seller.menus.product.index');
        }
        
    }
}
