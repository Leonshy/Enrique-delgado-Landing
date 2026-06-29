<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceArea;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceAreaController extends Controller
{
    public function index(): View
    {
        return view('admin.areas.index', ['areas' => ServiceArea::orderBy('order')->get()]);
    }

    public function create(): View
    {
        return view('admin.areas.form', ['area' => new ServiceArea()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active', true);
        ServiceArea::create($data);
        return redirect()->route('admin.areas.index')->with('success', 'Área creada.');
    }

    public function edit(ServiceArea $area): View
    {
        return view('admin.areas.form', compact('area'));
    }

    public function update(Request $request, ServiceArea $area): RedirectResponse
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        $area->update($data);
        return redirect()->route('admin.areas.index')->with('success', 'Área actualizada.');
    }

    public function destroy(ServiceArea $area): RedirectResponse
    {
        $area->delete();
        return redirect()->route('admin.areas.index')->with('success', 'Área eliminada.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title'       => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'order'       => ['nullable', 'integer'],
        ]);
    }
}
