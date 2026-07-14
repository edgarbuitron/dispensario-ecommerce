<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request): View
    {
        $query = Brand::withCount('products')->latest();

        if ($request->get('search')) {
            $query->where('name', 'like', '%' . $request->get('search') . '%');
        }

        $brands = $query->paginate(20);

        return view('admin.brands.index', ['brands' => $brands]);
    }

    public function create(): View
    {
        return view('admin.brands.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'website' => 'nullable|url',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['slug'] = str()->slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('logo')) {
            $filename = 'brand_' . uniqid() . '.' . $request->file('logo')->extension();
            $request->file('logo')->storeAs('brands', $filename, 'public');
            $validated['logo'] = $filename;
        }

        Brand::create($validated);

        return redirect()->route('admin.brands.index')
            ->with('success', 'Marca creada correctamente');
    }

    public function edit(Brand $brand): View
    {
        return view('admin.brands.form', ['brand' => $brand]);
    }

    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $brand->id,
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'website' => 'nullable|url',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['slug'] = str()->slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('logo')) {
            $filename = 'brand_' . uniqid() . '.' . $request->file('logo')->extension();
            $request->file('logo')->storeAs('brands', $filename, 'public');
            $validated['logo'] = $filename;
        }

        $brand->update($validated);

        return redirect()->route('admin.brands.index')
            ->with('success', 'Marca actualizada correctamente');
    }

    public function destroy(Brand $brand)
    {
        if ($brand->products()->count() > 0) {
            return back()->with('error', 'No se puede eliminar una marca que tiene productos');
        }

        $brand->delete();

        return redirect()->route('admin.brands.index')
            ->with('success', 'Marca eliminada correctamente');
    }
}
