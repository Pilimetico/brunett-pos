<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::orderBy('name')->get();
        return view('warehouses.index', compact('warehouses'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required', 'code' => 'required|unique:warehouses']);
        Warehouse::create($request->all());
        return back()->with('success', 'Bodega creada.');
    }

    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();
        return back()->with('success', 'Bodega eliminada.');
    }
}
