<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        return view('brands.index', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        Brand::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
        return back()->with('success', 'Marca creada.');
    }

    public function edit(Brand $brand)
    {
        return view('brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate(['name' => 'required']);
        $brand->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
        return redirect()->route('brands.index')->with('success', 'Marca actualizada.');
    }

    public function destroy(Brand $brand)
    {
        // Add check if products use this brand, but for now just delete
        $brand->delete();
        return back()->with('success', 'Marca eliminada.');
    }
}
