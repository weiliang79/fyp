<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Models\Store;
use Illuminate\Http\Request;

class StudentMenuController extends Controller
{
    public function index()
    {
        $stores = Store::all();
        $categories = ProductCategory::all();
        return view('menu.index', compact('stores', 'categories'));
    }
}
