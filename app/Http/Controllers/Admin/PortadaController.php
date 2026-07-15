<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\HtmlSanitizer;
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

        $extra['btn1_action_type'] = $extra['btn1_action_type'] ?? 'url';
        $extra['btn2_action_type'] = $extra['btn2_action_type'] ?? ($extra['btn2_url'] ? 'url' : 'whatsapp');

        return view('admin.portada.edit', compact('hero', 'extra'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'title'              => ['nullable', 'string', 'max:255'],
            'subtitle'           => ['nullable', 'string', 'max:255'],
            'body'               => ['nullable', 'string'],
            'cta_text'           => ['nullable', 'string', 'max:100'],
            'cta_url'            => ['nullable', 'string', 'max:255', 'regex:/^(https?:\/\/|\/|#)/'],
            'btn1_icon'          => ['nullable', 'string', 'max:30'],
            'btn1_action_type'   => ['required', 'in:url,email,whatsapp'],
            'btn1_url_target'    => ['nullable', 'in:_self,_blank'],
            'btn1_email_to'      => ['nullable', 'email', 'max:255'],
            'btn1_email_subject' => ['nullable', 'string', 'max:255'],
            'btn1_email_body'    => ['nullable', 'string', 'max:1000'],
            'btn1_whatsapp_message' => ['nullable', 'string', 'max:500'],
            'btn2_text'          => ['nullable', 'string', 'max:100'],
            'btn2_url'           => ['nullable', 'string', 'max:255', 'regex:/^(https?:\/\/|\/|#)/'],
            'btn2_icon'          => ['nullable', 'string', 'max:30'],
            'btn2_action_type'   => ['required', 'in:url,email,whatsapp'],
            'btn2_url_target'    => ['nullable', 'in:_self,_blank'],
            'btn2_email_to'      => ['nullable', 'email', 'max:255'],
            'btn2_email_subject' => ['nullable', 'string', 'max:255'],
            'btn2_email_body'    => ['nullable', 'string', 'max:1000'],
            'btn2_whatsapp_message' => ['nullable', 'string', 'max:500'],
            'image_path'         => ['nullable', 'string', 'max:500'],
            'image_alt'          => ['nullable', 'string', 'max:255'],
            'cert_badge_title'    => ['nullable', 'string', 'max:100'],
            'cert_badge_subtitle' => ['nullable', 'string', 'max:100'],
        ]);

        $hero = LandingSection::where('slug', 'hero')->firstOrFail();

        $data = [
            'title'     => $request->title,
            'subtitle'  => $request->subtitle,
            'body'      => HtmlSanitizer::clean($request->body),
            'cta_text'  => $request->cta_text,
            'cta_url'   => $request->cta_url,
            'image_alt' => $request->image_alt,
            'extra'     => json_encode([
                'btn1_icon'              => $request->btn1_icon,
                'btn1_action_type'       => $request->btn1_action_type,
                'btn1_url_target'        => $request->btn1_url_target,
                'btn1_email_to'          => $request->btn1_email_to,
                'btn1_email_subject'     => $request->btn1_email_subject,
                'btn1_email_body'        => $request->btn1_email_body,
                'btn1_whatsapp_message'  => $request->btn1_whatsapp_message,
                'btn2_text'            => $request->btn2_text,
                'btn2_url'             => $request->btn2_url,
                'btn2_icon'              => $request->btn2_icon,
                'btn2_action_type'       => $request->btn2_action_type,
                'btn2_url_target'        => $request->btn2_url_target,
                'btn2_email_to'          => $request->btn2_email_to,
                'btn2_email_subject'     => $request->btn2_email_subject,
                'btn2_email_body'        => $request->btn2_email_body,
                'btn2_whatsapp_message'  => $request->btn2_whatsapp_message,
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
