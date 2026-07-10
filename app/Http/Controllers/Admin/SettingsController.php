<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\SettingsHelper;
use App\Helpers\ThemeHelper;
use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
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

        foreach ($textKeys as $key) {
            if ($request->has($key)) {
                SettingsHelper::set($key, $request->input($key));
            }
        }

        SettingsHelper::set('maintenance_mode', $request->boolean('maintenance_mode') ? '1' : '0');

        foreach ($imageKeys as $key) {
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                $file->validate(['mimes' => 'jpg,jpeg,png,gif,webp,svg', 'max' => 2048]);
                $path = $file->store("settings/{$key}", 'public');
                SettingsHelper::set($key, $path);
            }
        }

        Cache::flush();
        return back()->with('success', 'Configuración actualizada.');
    }

    public function integrations(): View
    {
        $settings = SiteSetting::where('group', 'integrations')->get()->keyBy('key');
        return view('admin.settings.integrations', compact('settings'));
    }

    public function updateIntegrations(Request $request): RedirectResponse
    {
        $keys = [
            'hcaptcha_enabled', 'hcaptcha_site_key', 'hcaptcha_secret_key',
            'ga_enabled', 'ga_measurement_id',
            'pixel_enabled', 'pixel_id',
            'tinymce_api_key',
            'custom_head_scripts', 'custom_body_scripts',
        ];

        foreach ($keys as $key) {
            if ($request->has($key)) {
                SettingsHelper::set($key, $request->input($key, ''), 'integrations');
            }
        }

        // Checkboxes
        foreach (['hcaptcha_enabled', 'ga_enabled', 'pixel_enabled'] as $key) {
            SettingsHelper::set($key, $request->boolean($key) ? '1' : '0', 'integrations');
        }

        Cache::flush();
        return back()->with('success', 'Integraciones actualizadas.');
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
}
