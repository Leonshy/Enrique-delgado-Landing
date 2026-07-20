<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ButtonHelper;
use App\Helpers\FontHelper;
use App\Helpers\HcaptchaHelper;
use App\Helpers\ImageOptimizer;
use App\Helpers\MailSettingsHelper;
use App\Helpers\SentryHelper;
use App\Helpers\SettingsHelper;
use App\Helpers\ThemeHelper;
use App\Helpers\UptimeRobotHelper;
use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function general(): View
    {
        $settings = SiteSetting::whereIn('group', ['general', 'contact'])->get()->keyBy('key');

        $socials = [
            'facebook'  => SettingsHelper::get('social_facebook', ''),
            'x'         => SettingsHelper::get('social_x', ''),
            'instagram' => SettingsHelper::get('social_instagram', ''),
            'linkedin'  => SettingsHelper::get('social_linkedin', ''),
            'youtube'   => SettingsHelper::get('social_youtube', ''),
            'tiktok'    => SettingsHelper::get('social_tiktok', ''),
        ];
        $maintenance = SettingsHelper::get('maintenance_mode', '0');
        $footerText  = SettingsHelper::get('footer_text', '');

        return view('admin.settings.general', compact('settings', 'socials', 'maintenance', 'footerText'));
    }

    public function updateGeneral(Request $request): RedirectResponse
    {
        $textKeys = [
            'site_name', 'site_tagline', 'contact_email', 'admin_email',
            'whatsapp', 'whatsapp_msg', 'location', 'schedule',
            'social_facebook', 'social_x', 'social_instagram',
            'social_linkedin', 'social_youtube', 'social_tiktok',
            'footer_text',
        ];
        $imageKeys = ['logo_color', 'logo_white', 'isotipo', 'favicon'];

        $request->validate([
            'logo_color' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,webp,svg', 'max:5120'],
            'logo_white' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,webp,svg', 'max:5120'],
            'isotipo'    => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,webp,svg', 'max:5120'],
            'favicon'    => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,webp,svg', 'max:5120'],
        ]);

        foreach ($textKeys as $key) {
            if ($request->has($key)) {
                SettingsHelper::set($key, $request->input($key));
            }
        }

        SettingsHelper::set('maintenance_mode', $request->boolean('maintenance_mode') ? '1' : '0');

        foreach ($imageKeys as $key) {
            if ($request->hasFile($key)) {
                try {
                    $path = ImageOptimizer::store($request->file($key), "settings/{$key}", 'public');
                } catch (\RuntimeException $e) {
                    return back()->with('error', $e->getMessage());
                }

                SettingsHelper::set($key, $path);
            }
        }

        Cache::flush();
        return back()->with('success', 'Configuración actualizada.');
    }

    public function integrations(): View
    {
        $settings          = SiteSetting::where('group', 'integrations')->get()->keyBy('key');
        $hcaptchaForms     = HcaptchaHelper::availableForms();
        $enabledForms      = HcaptchaHelper::enabledForms();
        $sentrySettings    = SentryHelper::settings();
        $uptimeSettings    = UptimeRobotHelper::settings();

        return view('admin.settings.integrations', compact(
            'settings', 'hcaptchaForms', 'enabledForms', 'sentrySettings', 'uptimeSettings'
        ));
    }

    public function updateIntegrations(Request $request): RedirectResponse
    {
        $keys = [
            'hcaptcha_enabled', 'hcaptcha_site_key', 'hcaptcha_secret_key',
            'ga_enabled', 'ga_measurement_id',
            'pixel_enabled', 'pixel_id',
            'tinymce_api_key',
            'sentry_dsn',
            'uptimerobot_api_key',
            'custom_head_scripts', 'custom_body_scripts',
        ];

        foreach ($keys as $key) {
            if ($request->has($key)) {
                SettingsHelper::set($key, $request->input($key, ''), 'integrations');
            }
        }

        // Checkboxes
        foreach (['hcaptcha_enabled', 'ga_enabled', 'pixel_enabled', 'sentry_enabled', 'uptimerobot_enabled'] as $key) {
            SettingsHelper::set($key, $request->boolean($key) ? '1' : '0', 'integrations');
        }

        $selectedForms = array_values(array_intersect(
            $request->input('hcaptcha_forms', []),
            array_keys(HcaptchaHelper::availableForms())
        ));
        SettingsHelper::set('hcaptcha_forms', json_encode($selectedForms), 'integrations');

        Cache::flush();
        return back()->with('success', 'Integraciones actualizadas.');
    }

    public function testSentry(Request $request): JsonResponse
    {
        $request->validate(['dsn' => ['required', 'string']]);

        return response()->json(SentryHelper::sendTestEvent($request->dsn));
    }

    public function testUptimeRobot(Request $request): JsonResponse
    {
        $request->validate(['api_key' => ['required', 'string']]);

        return response()->json(UptimeRobotHelper::verifyApiKey($request->api_key));
    }

    public function createUptimeRobotMonitor(Request $request): JsonResponse
    {
        $request->validate(['api_key' => ['required', 'string']]);

        $result = UptimeRobotHelper::createMonitor(
            $request->api_key,
            config('app.url'),
            config('app.name') . ' — sitio web'
        );

        if ($result['ok']) {
            SettingsHelper::set('uptimerobot_monitor_id', $result['monitor_id'], 'integrations');
            SettingsHelper::set('uptimerobot_api_key', $request->api_key, 'integrations');
            SettingsHelper::set('uptimerobot_enabled', '1', 'integrations');
            Cache::flush();
        }

        return response()->json($result);
    }

    public function checkUptimeRobotStatus(): JsonResponse
    {
        $s = UptimeRobotHelper::settings();

        if (!filled($s['api_key']) || !filled($s['monitor_id'])) {
            return response()->json(['ok' => false, 'message' => 'Todavía no hay un monitor creado.']);
        }

        return response()->json(UptimeRobotHelper::getMonitorStatus($s['api_key'], $s['monitor_id']));
    }

    public function testHcaptcha(Request $request): JsonResponse
    {
        $request->validate([
            'secret_key' => ['required', 'string'],
            'token'      => ['required', 'string'],
        ]);

        $result = HcaptchaHelper::verify($request->secret_key, $request->token, $request->ip());

        return response()->json([
            'ok'      => $result['ok'],
            'message' => $result['ok']
                ? '✓ Conexión e integración correctas — el desafío se resolvió y se verificó bien.'
                : HcaptchaHelper::errorMessages($result['errors']),
        ]);
    }

    public function mail(): View
    {
        $settings          = MailSettingsHelper::settings();
        $encryptionOptions = MailSettingsHelper::encryptionOptions();
        $isConfigured      = MailSettingsHelper::isConfigured();

        return view('admin.settings.mail', compact('settings', 'encryptionOptions', 'isConfigured'));
    }

    public function updateMail(Request $request): RedirectResponse
    {
        $request->validate([
            'mail_host'         => ['required', 'string', 'max:255'],
            'mail_port'         => ['required', 'integer', 'min:1', 'max:65535'],
            'mail_encryption'   => ['required', 'in:' . implode(',', array_keys(MailSettingsHelper::encryptionOptions()))],
            'mail_username'     => ['required', 'string', 'max:255'],
            'mail_password'     => ['nullable', 'string', 'max:255'],
            'mail_from_address' => ['required', 'email', 'max:255'],
            'mail_from_name'    => ['nullable', 'string', 'max:255'],
        ]);

        SettingsHelper::set('mail_host', $request->mail_host, 'mail');
        SettingsHelper::set('mail_port', $request->mail_port, 'mail');
        SettingsHelper::set('mail_encryption', $request->mail_encryption, 'mail');
        SettingsHelper::set('mail_username', $request->mail_username, 'mail');
        // Solo se pisa la contraseña si se escribió una nueva — así no hace falta
        // volver a tipearla cada vez que se cambia otro campo.
        if ($request->filled('mail_password')) {
            SettingsHelper::set('mail_password', $request->mail_password, 'mail');
        }
        SettingsHelper::set('mail_from_address', $request->mail_from_address, 'mail');
        SettingsHelper::set('mail_from_name', $request->mail_from_name, 'mail');

        Cache::flush();
        return back()->with('success', 'Configuración de email actualizada.');
    }

    public function testMail(Request $request): JsonResponse
    {
        $request->validate([
            'mail_host'         => ['required', 'string', 'max:255'],
            'mail_port'         => ['required', 'integer', 'min:1', 'max:65535'],
            'mail_encryption'   => ['required', 'in:' . implode(',', array_keys(MailSettingsHelper::encryptionOptions()))],
            'mail_username'     => ['required', 'string', 'max:255'],
            'mail_password'     => ['nullable', 'string', 'max:255'],
            'mail_from_address' => ['required', 'email', 'max:255'],
            'to'                => ['required', 'email', 'max:255'],
        ]);

        // Si no mandaron una contraseña nueva en el form de prueba, usar la ya guardada.
        $password = $request->filled('mail_password')
            ? $request->mail_password
            : SettingsHelper::get('mail_password', '');

        $result = MailSettingsHelper::sendTestEmail([
            'host'         => $request->mail_host,
            'port'         => $request->mail_port,
            'encryption'   => $request->mail_encryption,
            'username'     => $request->mail_username,
            'password'     => $password,
            'from_address' => $request->mail_from_address,
        ], $request->to);

        return response()->json($result);
    }

    public function colors(): View
    {
        $roles  = ThemeHelper::roles();
        $values = [];
        foreach ($roles as $key => $role) {
            $values[$key] = SettingsHelper::get($key, $role['default']);
        }

        return view('admin.settings.colors', compact('roles', 'values'));
    }

    public function updateColors(Request $request): RedirectResponse
    {
        $roles = ThemeHelper::roles();

        $request->validate(
            array_fill_keys(array_keys($roles), ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'])
        );

        foreach ($roles as $key => $role) {
            $value = $request->input($key) ?: $role['default'];
            SettingsHelper::set($key, $value, 'appearance');
        }

        Cache::flush();
        return back()->with('success', 'Colores actualizados.');
    }

    public function resetColors(): RedirectResponse
    {
        foreach (ThemeHelper::roles() as $key => $role) {
            SettingsHelper::set($key, $role['default'], 'appearance');
        }

        Cache::flush();
        return back()->with('success', 'Paleta restaurada a los valores por defecto.');
    }

    public function typography(): View
    {
        $headingFonts  = FontHelper::headingFonts();
        $bodyFonts     = FontHelper::bodyFonts();
        $sizeScales    = FontHelper::sizeScales();
        $selected      = FontHelper::selected();
        $customHeading = FontHelper::customFont('heading');
        $customBody    = FontHelper::customFont('body');

        return view('admin.settings.typography', compact(
            'headingFonts', 'bodyFonts', 'sizeScales', 'selected', 'customHeading', 'customBody'
        ));
    }

    public function updateTypography(Request $request): RedirectResponse
    {
        $headingKeys = array_merge(array_keys(FontHelper::headingFonts()), [FontHelper::CUSTOM_HEADING_KEY]);
        $bodyKeys    = array_merge(array_keys(FontHelper::bodyFonts()), [FontHelper::CUSTOM_BODY_KEY]);

        $request->validate([
            'font_heading' => ['required', 'in:' . implode(',', $headingKeys)],
            'font_body'    => ['required', 'in:' . implode(',', $bodyKeys)],
            'font_scale'   => ['required', 'in:' . implode(',', array_keys(FontHelper::sizeScales()))],
        ]);

        if ($request->font_heading === FontHelper::CUSTOM_HEADING_KEY && !FontHelper::customFont('heading')) {
            return back()->withErrors(['font_heading' => 'Todavía no subiste una tipografía personalizada para títulos.']);
        }
        if ($request->font_body === FontHelper::CUSTOM_BODY_KEY && !FontHelper::customFont('body')) {
            return back()->withErrors(['font_body' => 'Todavía no subiste una tipografía personalizada para texto.']);
        }

        SettingsHelper::set('font_heading', $request->font_heading, 'appearance');
        SettingsHelper::set('font_body', $request->font_body, 'appearance');
        SettingsHelper::set('font_scale', $request->font_scale, 'appearance');

        Cache::flush();
        return back()->with('success', 'Tipografía actualizada.');
    }

    public function resetTypography(): RedirectResponse
    {
        SettingsHelper::set('font_heading', 'playfair', 'appearance');
        SettingsHelper::set('font_body', 'inter', 'appearance');
        SettingsHelper::set('font_scale', '100', 'appearance');

        Cache::flush();
        return back()->with('success', 'Tipografía restaurada a los valores por defecto.');
    }

    public function uploadCustomFont(Request $request, string $slot): RedirectResponse
    {
        abort_unless(in_array($slot, ['heading', 'body'], true), 404);

        $request->validate([
            'font_file'  => ['required', 'file', 'max:5120', 'extensions:ttf,otf,woff,woff2'],
            'font_label' => ['nullable', 'string', 'max:60'],
        ]);

        $file  = $request->file('font_file');
        $label = $request->input('font_label') ?: pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        $oldPath = SettingsHelper::get("font_{$slot}_custom_path");
        if ($oldPath) {
            Storage::disk('public')->delete($oldPath);
        }

        $path = $file->store("fonts/{$slot}", 'public');

        SettingsHelper::set("font_{$slot}_custom_path", $path, 'appearance');
        SettingsHelper::set("font_{$slot}_custom_label", $label, 'appearance');
        SettingsHelper::set('font_' . $slot, $slot === 'heading' ? FontHelper::CUSTOM_HEADING_KEY : FontHelper::CUSTOM_BODY_KEY, 'appearance');

        Cache::flush();
        return back()->with('success', 'Tipografía personalizada subida y activada.');
    }

    public function removeCustomFont(string $slot): RedirectResponse
    {
        abort_unless(in_array($slot, ['heading', 'body'], true), 404);

        $path = SettingsHelper::get("font_{$slot}_custom_path");
        if ($path) {
            Storage::disk('public')->delete($path);
        }

        SettingsHelper::set("font_{$slot}_custom_path", '', 'appearance');
        SettingsHelper::set("font_{$slot}_custom_label", '', 'appearance');

        $customKey = $slot === 'heading' ? FontHelper::CUSTOM_HEADING_KEY : FontHelper::CUSTOM_BODY_KEY;
        if (SettingsHelper::get('font_' . $slot) === $customKey) {
            SettingsHelper::set('font_' . $slot, $slot === 'heading' ? 'playfair' : 'inter', 'appearance');
        }

        Cache::flush();
        return back()->with('success', 'Tipografía personalizada eliminada.');
    }

    public function buttons(): View
    {
        $slots = [
            'navbar_cta'     => 'Navbar — botón "Agendar sesión"',
            'footer_cta'     => 'Footer — botón "Solicitar consulta"',
            'whatsapp_float' => 'WhatsApp flotante',
        ];
        $values = [];
        foreach (array_keys($slots) as $key) {
            $values[$key] = ButtonHelper::get($key);
        }

        return view('admin.settings.buttons', compact('slots', 'values'));
    }

    public function updateButtons(Request $request): RedirectResponse
    {
        $slots = array_keys(ButtonHelper::globalDefaults());

        $rules = [];
        foreach ($slots as $slot) {
            $rules["{$slot}_label"]          = ['nullable', 'string', 'max:100'];
            $rules["{$slot}_icon"]           = ['nullable', 'string', 'max:30'];
            $rules["{$slot}_action_type"]    = ['required', 'in:url,email,whatsapp'];
            $rules["{$slot}_url"]            = ['nullable', 'string', 'max:255', 'regex:/^(https?:\/\/|\/|#)/'];
            $rules["{$slot}_url_target"]     = ['nullable', 'in:_self,_blank'];
            $rules["{$slot}_email_to"]       = ['nullable', 'email', 'max:255'];
            $rules["{$slot}_email_subject"]  = ['nullable', 'string', 'max:255'];
            $rules["{$slot}_email_body"]     = ['nullable', 'string', 'max:1000'];
            $rules["{$slot}_whatsapp_message"] = ['nullable', 'string', 'max:500'];
        }
        $request->validate($rules);

        foreach ($slots as $slot) {
            ButtonHelper::set($slot, [
                'label'            => $request->input("{$slot}_label"),
                'icon'             => $request->input("{$slot}_icon"),
                'action_type'      => $request->input("{$slot}_action_type"),
                'url'              => $request->input("{$slot}_url"),
                'url_target'       => $request->input("{$slot}_url_target"),
                'email_to'         => $request->input("{$slot}_email_to"),
                'email_subject'    => $request->input("{$slot}_email_subject"),
                'email_body'       => $request->input("{$slot}_email_body"),
                'whatsapp_message' => $request->input("{$slot}_whatsapp_message"),
            ]);
        }

        Cache::flush();
        return back()->with('success', 'Botones actualizados.');
    }
}
