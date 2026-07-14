<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\HtmlSanitizer;
use App\Http\Controllers\Controller;
use App\Models\LandingSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EnfoqueController extends Controller
{
    public function edit(): View
    {
        $enfoque = LandingSection::where('slug', 'enfoque')->firstOrFail();
        $extra   = json_decode($enfoque->extra ?? '{}', true) ?: [];

        $extra['label']   = $extra['label']   ?? 'Mi enfoque';
        $extra['pillars'] = $extra['pillars'] ?? [
            ['title' => 'Alianza terapéutica sólida',       'desc' => 'Un espacio seguro y confidencial donde puedes ser completamente honesto/a.'],
            ['title' => 'Objetivos claros desde el principio', 'desc' => 'Definimos juntos hacia dónde vamos y cómo mediremos el progreso.'],
            ['title' => 'Herramientas para la vida diaria', 'desc' => 'Técnicas concretas que puedes aplicar fuera de la sesión, desde el primer día.'],
        ];

        // Unificar subtitle + body en un solo campo para el admin
        $enfoque->unified_desc = trim(($enfoque->subtitle ?? '') . "\n\n" . ($enfoque->body ?? ''));

        return view('admin.enfoque.edit', compact('enfoque', 'extra'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'label'              => ['nullable', 'string', 'max:100'],
            'title'              => ['nullable', 'string', 'max:255'],
            'description'        => ['nullable', 'string'],
            'pillars.*.title'    => ['nullable', 'string', 'max:150'],
            'pillars.*.desc'     => ['nullable', 'string'],
            'image_path'         => ['nullable', 'string', 'max:500'],
            'image_alt'          => ['nullable', 'string', 'max:255'],
        ]);

        $enfoque = LandingSection::where('slug', 'enfoque')->firstOrFail();

        $data = [
            'title'     => $request->title,
            'subtitle'  => HtmlSanitizer::clean($request->description),
            'body'      => null,
            'image_alt' => $request->image_alt,
            'is_active' => $request->boolean('is_active'),
            'extra'     => json_encode([
                'label'   => $request->label,
                'pillars' => $request->input('pillars', []),
            ]),
        ];

        if ($request->filled('image_path')) {
            $data['image_path'] = $request->image_path;
        }

        $enfoque->update($data);

        return redirect()->route('admin.enfoque.edit')->with('success', 'Sección Enfoque actualizada.');
    }
}
