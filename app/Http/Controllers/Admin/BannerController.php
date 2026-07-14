<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BannerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request): View
    {
        $query = Banner::latest();

        if ($request->get('position')) {
            $query->where('position', $request->get('position'));
        }

        $banners = $query->paginate(20);

        return view('admin.banners.index', ['banners' => $banners]);
    }

    public function create(): View
    {
        return view('admin.banners.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'link' => 'nullable|url',
            'position' => 'required|in:hero,secondary,bottom',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $filename = 'banner_' . uniqid() . '.' . $request->file('image')->extension();
            $request->file('image')->storeAs('banners', $filename, 'public');
            $validated['image'] = $filename;
        }

        Banner::create($validated);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner creado correctamente');
    }

    public function edit(Banner $banner): View
    {
        return view('admin.banners.form', ['banner' => $banner]);
    }

    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'link' => 'nullable|url',
            'position' => 'required|in:hero,secondary,bottom',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $filename = 'banner_' . uniqid() . '.' . $request->file('image')->extension();
            $request->file('image')->storeAs('banners', $filename, 'public');
            $validated['image'] = $filename;
        }

        $banner->update($validated);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner actualizado correctamente');
    }

    public function destroy(Banner $banner)
    {
        $banner->delete();

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner eliminado correctamente');
    }
}
