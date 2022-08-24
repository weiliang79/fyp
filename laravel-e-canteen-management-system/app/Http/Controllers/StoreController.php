<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function index(){
        $user = User::find(Auth::user()->id);
        if($user->isAdmin()){
            echo 'TODO';
        } else {

            $store = Store::with('user')->whereUserId($user->id)->get();
            //dd($store);

            return view('food_seller.store.index', compact('store'));
        }

    }
}
