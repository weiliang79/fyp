<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::all();
        return view('admin.settings.index', compact('settings'));
    }

    public function save(Request $request){

        $request->validate([
            'app_name' => 'required',
            'currency_symbol' => 'required',
        ]);

        $data = $request->except('_token');

        foreach($data as $key => $value){
            $setting = Setting::firstOrCreate(['key' => $key]);
            $setting->value = $value;
            $setting->save();
        }

        return redirect()->route('admin.settings')->with('swal-success', 'Settings save successful.');

    }

}
