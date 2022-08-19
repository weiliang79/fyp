<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use function PHPSTORM_META\map;

class UserManagementController extends Controller
{
    public function index(){
        $users = User::get();
        return view('admin.user_management.index', compact('users'));
    }

    public function showCreateForm(){
        $roles = Role::get();
        return view('admin.user_management.create', compact('roles'));
    }

    public function save(Request $request){
        
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required',
            'email' => 'unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|integer|gt:0'
        ],
        [
            'role.gt' => 'The role field need to choose a role.',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'role_id' => $request->role,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.user_management')->with('swal-success', 'New user detail save successful.');

    }

    public function delete(Request $request){
        User::destroy($request->user_id);
        return response()->json('User delete successful.');
    }
}
