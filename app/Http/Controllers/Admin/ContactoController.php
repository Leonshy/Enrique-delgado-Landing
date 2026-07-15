<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\HtmlSanitizer;
use App\Http\Controllers\Controller;
use App\Models\LandingSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactoController extends Controller
{
    public function edit(): View
    {
        $section = LandingSection::where('slug', 'contacto')->firstOrFail();
        $extra   = json_decode($section->extra ?? '{}', true) ?: [];

        $extra['label']     = $extra['label']     ?? 'Hablemos';
        $extra['box_title'] = $extra['box_title'] ?? 'Primera sesión';
        $extra['box_body']  = $extra['box_body']  ?? 'La primera sesión es **gratuita y sin compromiso**. Es el espacio para conocernos, contarme lo que estás viviendo y evaluar si puedo ayudarte.';

        return view('admin.contacto.edit', compact('section', 'extra'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'label'     => ['nullable', 'string', 'max:100'],
            'title'     => ['nullable', 'string', 'max:255'],
            'subtitle'  => ['nullable', 'string', 'max:500'],
            'box_title' => ['nullable', 'string', 'max:100'],
            'box_body'  => ['nullable', 'string'],
        ]);

        $section = LandingSection::where('slug', 'contacto')->firstOrFail();

        $section->update([
            'title'    => $request->title,
            'subtitle' => HtmlSanitizer::clean($request->subtitle),
            'extra'    => json_encode([
                'label'     => $request->label,
                'box_title' => $request->box_title,
                'box_body'  => $request->box_body,
            ]),
        ]);

        return redirect()->route('admin.contacto.edit')->with('success', 'Sección Contacto actualizada.');
    }
}
