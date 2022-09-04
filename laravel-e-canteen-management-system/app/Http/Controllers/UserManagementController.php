<?php

namespace App\Http\Controllers;

use App\Models\RestTime;
use App\Models\Role;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use function PHPSTORM_META\map;

class UserManagementController extends Controller
{
    public function index(){
        $users = User::all();
        $students = Student::all();
        return view('admin.user_management.index', compact('users', 'students'));
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
            'email' => 'unique:users,email|unique:students,email',
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

        return redirect()->route('admin.user_management')->with('swal-success', 'New user details save successful.');

    }

    public function delete(Request $request){
        User::destroy($request->user_id);
        return response()->json('User delete successful.');
    }

    public function showStudentCreateForm(){

        if(count(RestTime::all()) == 0){
            return redirect()->route('admin.user_management.student.rest_time');
        }

        $restTimes = RestTime::all();

        return view('admin.user_management.student.create', compact('restTimes'));
    }

    public function saveStudent(Request $request){

        $request->validate([
            'student_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required',
            'email' => 'nullable|unique:users,email|unique:students,email',
            'password' => 'required',
            'rest_id.*' => 'integer|gt:0',
        ],
        [
            'rest_id.*.gt' => 'The rest time field need to choose a rest time.',
        ]);

        //dd($request);

        $student = Student::create([
            'student_id' => $request->student_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        if($request->rest_id){
            foreach($request->rest_id as $id){
                $student->restTimes()->attach($id);
            }
        }

        return redirect()->route('admin.user_management')->with('swal-success', 'New Student Details save successful.');
    }
}
