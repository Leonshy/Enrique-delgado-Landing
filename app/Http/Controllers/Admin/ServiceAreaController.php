<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingSection;
use App\Models\ServiceArea;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceAreaController extends Controller
{
    public function index(): View
    {
        $section = LandingSection::where('slug', 'areas')->first();
        return view('admin.areas.index', [
            'areas'   => ServiceArea::orderBy('order')->get(),
            'section' => $section,
        ]);
    }

    public function updateSection(Request $request): RedirectResponse
    {
        $request->validate([
            'label'    => ['nullable', 'string', 'max:100'],
            'title'    => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string'],
        ]);

        LandingSection::where('slug', 'areas')->update([
            'extra'     => json_encode(['label' => $request->label]),
            'title'     => $request->title,
            'subtitle'  => $request->subtitle,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.areas.index')->with('success', 'Encabezado actualizado.');
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
            'icon'        => ['nullable', 'string', 'max:30'],
            'order'       => ['nullable', 'integer'],
        ]);
    }
}
