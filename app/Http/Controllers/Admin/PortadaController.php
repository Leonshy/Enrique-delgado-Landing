<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortadaController extends Controller
{
    public function edit(): View
    {
        $hero  = LandingSection::where('slug', 'hero')->firstOrFail();
        $extra = json_decode($hero->extra ?? '{}', true) ?: [];

        $extra['cert_badge_enabled']  = $extra['cert_badge_enabled']  ?? true;
        $extra['cert_badge_title']    = $extra['cert_badge_title']    ?? 'Certificado';
        $extra['cert_badge_subtitle'] = $extra['cert_badge_subtitle'] ?? 'Psicólogo Clínico';

        return view('admin.portada.edit', compact('hero', 'extra'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'title'              => ['nullable', 'string', 'max:255'],
            'subtitle'           => ['nullable', 'string', 'max:255'],
            'body'               => ['nullable', 'string'],
            'cta_text'           => ['nullable', 'string', 'max:100'],
            'cta_url'            => ['nullable', 'string', 'max:255'],
            'btn2_text'          => ['nullable', 'string', 'max:100'],
            'btn2_url'           => ['nullable', 'string', 'max:255'],
            'image_path'         => ['nullable', 'string', 'max:500'],
            'image_alt'          => ['nullable', 'string', 'max:255'],
            'cert_badge_title'    => ['nullable', 'string', 'max:100'],
            'cert_badge_subtitle' => ['nullable', 'string', 'max:100'],
        ]);

        $hero = LandingSection::where('slug', 'hero')->firstOrFail();

        $data = [
            'title'     => $request->title,
            'subtitle'  => $request->subtitle,
            'body'      => $request->body,
            'cta_text'  => $request->cta_text,
            'cta_url'   => $request->cta_url,
            'image_alt' => $request->image_alt,
            'extra'     => json_encode([
                'btn2_text'            => $request->btn2_text,
                'btn2_url'             => $request->btn2_url,
                'cert_badge_enabled'   => $request->boolean('cert_badge_enabled'),
                'cert_badge_title'     => $request->cert_badge_title,
                'cert_badge_subtitle'  => $request->cert_badge_subtitle,
            ]),
        ];

        if ($request->filled('image_path')) {
            $data['image_path'] = $request->image_path;
        }

        $hero->update($data);

        return redirect()->route('admin.portada.edit')->with('success', 'Portada actualizada correctamente.');
    }
}
