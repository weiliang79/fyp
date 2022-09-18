<?php

namespace App\Http\Controllers;

use App\Models\PaymentType;
use Illuminate\Http\Request;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Session;

class PaymentController extends Controller
{
    // public function index(){
    //     $types = PaymentType::all();
    //     return view('admin.payment.index', compact('types'));
    // }

    // public function showCreateForm(){
    //     $type = null;
    //     return view('admin.payment.edit', compact('type'));
    // }

    // public function showEditForm($id){
    //     $type = PaymentType::find($id);
    //     return view('admin.payment.edit', compact('type'));
    // }

    // public function save(Request $request){
    //     //dd($request);

    //     $request->validate([
    //         'name' => 'required',
    //     ]);

    //     PaymentType::create([
    //         'name' => $request->name,
    //         'description' => $request->description,
    //     ]);

    //     return redirect()->route('admin.payment')->with('swal-success', 'Payment Type create successful.');
    // }

    // public function update(Request $request){
    //     //dd($request);

    //     $request->validate([
    //         'id' => 'required|integer',
    //         'name' => 'required',
    //     ]);

    //     $type = PaymentType::find($request->id);
    //     $type->name = $request->name;
    //     $type->description = $request->description;
    //     $type->save();

    //     return redirect()->route('admin.payment')->with('swal-success', 'Payment Type update successful.');
    // }

    // public function delete(Request $request){
    //     PaymentType::destroy($request->id);
    //     return response()->json('Payment Type delete successful.');
    // }

    public function index()
    {
        return view('admin.payment.general.index');
    }

    public function saveGeneral(Request $request)
    {

        $request->validate([
            'currency_symbol' => 'required',
        ]);

        DotenvEditor::setKeys([
            'CURRENCY_SYMBOL' => $request->currency_symbol,
            'PAYMENT_MAINTENANCE' => $request->maintenance ? 'true' : 'false',
            '2C2P_ENABLE' => $request->status_2c2p ? 'true' : 'false',
            'STRIPE_ENABLE' => $request->stripe_status ? 'true' : 'false',
        ])->save();

        /*config([
            'payment.currency_symbol' => $request->currency_symbol,
            'payment.maintenance_mode' => $request->maintenance_mode == 'on' ? true : false,
        ]);*/

        //dd($request);

        return redirect()->route('admin.payment.general')->with('swal-success', 'Payment Configuration has updated.');
    }

    public function index2c2p()
    {

        if (config('payment.2c2p-status') == false) {
            return redirect()->route('admin.payment.general')->with('swal-warning', 'Please enable 2C2P payment at General page first.');
        }

        if (config('payment.2c2p-sandbox.status') == true) {
            $url = config('payment.2c2p-sandbox.url') . 'Initialization';
        } else {
            $url = config('payment.2c2p.url') . 'Initialization';
        }
        
        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', $url, [
            'headers' => [
                'Accept' => 'text/plain',
                'Content-Type' => 'application/*+json',
            ]
        ]);

        $decode = json_decode($response->getBody());

        if($decode->respCode != 0000){
            Session::flash('swal-warning', 'Unable to receive Locale info from 2C2P.');
            return view('admin.payment.2c2p.index');
        }

        $locale = $decode->initialization->locale;

        return view('admin.payment.2c2p.index', compact('locale'));
    }

    public function save2c2p(Request $request)
    {
        dd($request);
    }

    public function indexStripe()
    {

        if (config('payment.stripe-status') == false) {
            return redirect()->route('admin.payment.general')->with('swal-warning', 'Please enable Stripe payment at General page first.');
        }

        return view('admin.payment.stripe.index');
    }
}
