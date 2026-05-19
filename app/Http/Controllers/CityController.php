<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::orderBy('name')->get();
        return view('cities.index', compact('cities'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        City::create($request->all());
        return back()->with('success', 'Ciudad creada.');
    }

    public function destroy(City $city)
    {
        $city->delete();
        return back()->with('success', 'Ciudad eliminada.');
    }
}
