<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CtaBannerController extends Controller
{
    public function edit(): View
    {
        $section = LandingSection::where('slug', 'primer-paso')->firstOrFail();
        $extra   = json_decode($section->extra ?? '{}', true) ?: [];

        $extra['label']   = $extra['label']   ?? 'El primer paso';
        $extra['btn1_text'] = $extra['btn1_text'] ?? 'Solicitar sesión gratuita';
        $extra['btn1_url']  = $extra['btn1_url']  ?? '#contacto';
        $extra['btn2_text'] = $extra['btn2_text'] ?? 'Escribir por WhatsApp';

        return view('admin.cta-banner.edit', compact('section', 'extra'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'label'     => ['nullable', 'string', 'max:100'],
            'title'     => ['nullable', 'string', 'max:255'],
            'subtitle'  => ['nullable', 'string', 'max:500'],
            'btn1_text' => ['nullable', 'string', 'max:80'],
            'btn1_url'  => ['nullable', 'string', 'max:255'],
            'btn2_text' => ['nullable', 'string', 'max:80'],
        ]);

        $section = LandingSection::where('slug', 'primer-paso')->firstOrFail();

        $section->update([
            'title'     => $request->title,
            'subtitle'  => $request->subtitle,
            'is_active' => $request->boolean('is_active'),
            'extra'     => json_encode([
                'label'     => $request->label,
                'btn1_text' => $request->btn1_text,
                'btn1_url'  => $request->btn1_url,
                'btn2_text' => $request->btn2_text,
            ]),
        ]);

        return redirect()->route('admin.cta-banner.edit')->with('success', 'Sección CTA actualizada.');
    }
}
