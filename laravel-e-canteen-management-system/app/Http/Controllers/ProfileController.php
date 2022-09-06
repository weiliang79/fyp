<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{
    public function index(){
        return view('profile.user');
    }

    public function updateName(Request $request){

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
        ]);

        //dd($request);

        $user = User::find(auth()->user()->id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->save();

        if($user->isAdmin()){
            return redirect()->route('admin.profile')->with('swal-success', 'Profile update successful.');
        } else {
            return redirect()->route('food_seller.profile')->with('swal-success', 'Profile update successful.');
        }
        
    }

    public function updateEmail(Request $request){
        dd($request);
    }

    public function updatePassword(Request $request){

        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        //dd($request);

        $user = User::find(auth()->user()->id);
        $user->password = Hash::make($request->password);
        $user->save();

        if($user->isAdmin()){
            return redirect()->route('admin.profile')->with('swal-success', 'Password update successful.');
        } else {
            return redirect()->route('food_seller.profile')->with('swal-success', 'Password update successful.');
        }
        

    }
}
