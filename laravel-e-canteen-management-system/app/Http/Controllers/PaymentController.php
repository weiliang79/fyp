<?php

namespace App\Http\Controllers;

use App\Models\PaymentType;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(){
        $types = PaymentType::all();
        return view('admin.payment.index', compact('types'));
    }

    public function showCreateForm(){
        $type = null;
        return view('admin.payment.edit', compact('type'));
    }

    public function showEditForm($id){
        $type = PaymentType::find($id);
        return view('admin.payment.edit', compact('type'));
    }

    public function save(Request $request){
        //dd($request);

        $request->validate([
            'name' => 'required',
        ]);

        PaymentType::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.payment')->with('swal-success', 'Payment Type create successful.');
    }

    public function update(Request $request){
        //dd($request);

        $request->validate([
            'id' => 'required|integer',
            'name' => 'required',
        ]);

        $type = PaymentType::find($request->id);
        $type->name = $request->name;
        $type->description = $request->description;
        $type->save();

        return redirect()->route('admin.payment')->with('swal-success', 'Payment Type update successful.');
    }

    public function delete(Request $request){
        PaymentType::destroy($request->id);
        return response()->json('Payment Type delete successful.');
    }
}
