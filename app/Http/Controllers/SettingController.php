<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->groupBy('group');
        $paymentMethods = PaymentMethod::all();
        return view('settings.index', compact('settings', 'paymentMethods'));
    }

    public function update(Request $request)
    {
        foreach ($request->settings as $key => $value) {
            Setting::where('key', $key)->update(['value' => $value]);
        }
        return back()->with('success', 'Configuración actualizada.');
    }

    public function updatePaymentMethod(Request $request, PaymentMethod $method)
    {
        $method->update($request->only(['commission_percentage', 'charge_percentage', 'is_active']));
        return back()->with('success', 'Método de pago actualizado.');
    }
}
