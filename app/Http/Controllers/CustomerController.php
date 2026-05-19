<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Sale;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::orderBy('first_name')->paginate(15);
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'document_number' => 'nullable|unique:customers,document_number',
            'email' => 'nullable|email',
        ]);

        $data = $request->all();
        $data['has_credit'] = $request->has('has_credit') ? true : false;
        $data['is_member_active'] = $request->has('is_member_active') ? true : false;
        
        Customer::create($data);

        return redirect()->route('customers.index')->with('success', 'Cliente registrado correctamente.');
    }

    public function edit(Customer $customer)
    {
        $salesHistory = Sale::where('customer_id', $customer->id)->orderBy('created_at', 'desc')->take(10)->get();
        $totalSpent = Sale::where('customer_id', $customer->id)->sum('total');
        
        // CRM Mini Dashboard Calculations
        $numberOfPurchases = Sale::where('customer_id', $customer->id)->count();
        $ticketPromedio = $numberOfPurchases > 0 ? $totalSpent / $numberOfPurchases : 0;
        
        $totalCost = Sale::where('customer_id', $customer->id)->sum('cost_total');
        $ganancia = $totalSpent - $totalCost;
        $margen = $totalSpent > 0 ? ($ganancia / $totalSpent) * 100 : 0;
        
        // Canal favorito
        $topChannel = Sale::where('customer_id', $customer->id)
            ->select('channel', \DB::raw('count(*) as total_sales'))
            ->groupBy('channel')
            ->orderByDesc('total_sales')
            ->first();
        
        $canalFavorito = $topChannel ? ucfirst($topChannel->channel) : 'N/A';
        
        // Deuda vencida (Mock por ahora, usa credit_used)
        $saldoPendiente = $customer->credit_used;

        return view('customers.edit', compact(
            'customer', 'salesHistory', 'totalSpent', 'numberOfPurchases', 
            'ticketPromedio', 'ganancia', 'margen', 'canalFavorito', 'saldoPendiente'
        ));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'document_number' => 'nullable|unique:customers,document_number,' . $customer->id,
        ]);

        $data = $request->all();
        $data['has_credit'] = $request->has('has_credit') ? true : false;
        $data['is_member_active'] = $request->has('is_member_active') ? true : false;

        $customer->update($data);

        return redirect()->route('customers.index')->with('success', 'Cliente actualizado.');
    }

    public function makeSocio(Customer $customer)
    {
        $customer->update([
            'type' => 'socio_brunett',
            'is_member_active' => true,
            'membership_expires_at' => now()->addYear()
        ]);

        return back()->with('success', 'Membresía activada. El cliente ahora es Socio Brunett por 1 año.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Cliente eliminado.');
    }
}
