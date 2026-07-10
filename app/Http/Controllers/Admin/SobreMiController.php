<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SobreMiController extends Controller
{
    public function edit(): View
    {
        $section = LandingSection::where('slug', 'sobre-mi')->firstOrFail();
        $extra   = json_decode($section->extra ?? '{}', true) ?: [];

        $extra['label']          = $extra['label']          ?? 'Sobre mí';
        $extra['stats']          = $extra['stats']          ?? [
            ['value' => '10+',  'label' => 'Años de práctica'],
            ['value' => '500+', 'label' => 'Pacientes'],
            ['value' => '3',    'label' => 'Países de formación'],
        ];

        return view('admin.sobre-mi.edit', compact('section', 'extra'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'label'          => ['nullable', 'string', 'max:100'],
            'title'          => ['nullable', 'string', 'max:255'],
            'subtitle'       => ['nullable', 'string', 'max:500'],
            'body'           => ['nullable', 'string'],
            'stats.*.value'  => ['nullable', 'string', 'max:20'],
            'stats.*.label'  => ['nullable', 'string', 'max:80'],
            'image_path'     => ['nullable', 'string', 'max:500'],
            'image_alt'      => ['nullable', 'string', 'max:255'],
        ]);

        $section = LandingSection::where('slug', 'sobre-mi')->firstOrFail();

        $data = [
            'title'     => $request->title,
            'subtitle'  => $request->subtitle,
            'body'      => $request->body,
            'image_alt' => $request->image_alt,
            'is_active' => $request->boolean('is_active'),
            'extra'     => json_encode([
                'label' => $request->label,
                'stats' => $request->input('stats', []),
            ]),
        ];

        if ($request->filled('image_path')) {
            $data['image_path'] = $request->image_path;
        }

        $section->update($data);

        return redirect()->route('admin.sobre-mi.edit')->with('success', 'Sección Sobre mí actualizada.');
    }
}
