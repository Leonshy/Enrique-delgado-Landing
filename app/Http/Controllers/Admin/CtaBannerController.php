<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\HtmlSanitizer;
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
        $extra['btn1_action_type'] = $extra['btn1_action_type'] ?? 'url';
        $extra['btn2_action_type'] = $extra['btn2_action_type'] ?? 'whatsapp';

        return view('admin.cta-banner.edit', compact('section', 'extra'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'label'     => ['nullable', 'string', 'max:100'],
            'title'     => ['nullable', 'string', 'max:255'],
            'subtitle'  => ['nullable', 'string'],
            'btn1_text' => ['nullable', 'string', 'max:80'],
            'btn1_url'  => ['nullable', 'string', 'max:255', 'regex:/^(https?:\/\/|\/|#)/'],
            'btn1_icon'          => ['nullable', 'string', 'max:30'],
            'btn1_action_type'   => ['required', 'in:url,email,whatsapp'],
            'btn1_url_target'    => ['nullable', 'in:_self,_blank'],
            'btn1_email_to'      => ['nullable', 'email', 'max:255'],
            'btn1_email_subject' => ['nullable', 'string', 'max:255'],
            'btn1_email_body'    => ['nullable', 'string', 'max:1000'],
            'btn1_whatsapp_message' => ['nullable', 'string', 'max:500'],
            'btn2_text' => ['nullable', 'string', 'max:80'],
            'btn2_icon'          => ['nullable', 'string', 'max:30'],
            'btn2_action_type'   => ['required', 'in:url,email,whatsapp'],
            'btn2_url'           => ['nullable', 'string', 'max:255', 'regex:/^(https?:\/\/|\/|#)/'],
            'btn2_url_target'    => ['nullable', 'in:_self,_blank'],
            'btn2_email_to'      => ['nullable', 'email', 'max:255'],
            'btn2_email_subject' => ['nullable', 'string', 'max:255'],
            'btn2_email_body'    => ['nullable', 'string', 'max:1000'],
            'btn2_whatsapp_message' => ['nullable', 'string', 'max:500'],
        ]);

        $section = LandingSection::where('slug', 'primer-paso')->firstOrFail();

        $section->update([
            'title'     => $request->title,
            'subtitle'  => HtmlSanitizer::clean($request->subtitle),
            'is_active' => $request->boolean('is_active'),
            'extra'     => json_encode([
                'label'     => $request->label,
                'btn1_text' => $request->btn1_text,
                'btn1_url'  => $request->btn1_url,
                'btn1_icon'             => $request->btn1_icon,
                'btn1_action_type'      => $request->btn1_action_type,
                'btn1_url_target'       => $request->btn1_url_target,
                'btn1_email_to'         => $request->btn1_email_to,
                'btn1_email_subject'    => $request->btn1_email_subject,
                'btn1_email_body'       => $request->btn1_email_body,
                'btn1_whatsapp_message' => $request->btn1_whatsapp_message,
                'btn2_text' => $request->btn2_text,
                'btn2_icon'             => $request->btn2_icon,
                'btn2_action_type'      => $request->btn2_action_type,
                'btn2_url'              => $request->btn2_url,
                'btn2_url_target'       => $request->btn2_url_target,
                'btn2_email_to'         => $request->btn2_email_to,
                'btn2_email_subject'    => $request->btn2_email_subject,
                'btn2_email_body'       => $request->btn2_email_body,
                'btn2_whatsapp_message' => $request->btn2_whatsapp_message,
            ]),
        ]);

        return redirect()->route('admin.cta-banner.edit')->with('success', 'Sección CTA actualizada.');
    }
}
