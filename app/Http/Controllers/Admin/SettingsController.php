<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\SettingsHelper;
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
        return view('admin.settings.general', compact('settings'));
    }

    public function updateGeneral(Request $request): RedirectResponse
    {
        $textKeys = ['site_name', 'site_tagline', 'contact_email', 'admin_email', 'whatsapp', 'whatsapp_msg', 'location', 'schedule'];
        $imageKeys = ['logo_color', 'logo_white', 'isotipo', 'favicon'];

        foreach ($textKeys as $key) {
            if ($request->has($key)) {
                SettingsHelper::set($key, $request->input($key));
            }
        }

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
            'custom_head_scripts', 'custom_body_scripts',
        ];

        foreach ($keys as $key) {
            if ($request->has($key)) {
                SettingsHelper::set($key, $request->input($key, ''));
            }
        }

        // Checkboxes
        foreach (['hcaptcha_enabled', 'ga_enabled', 'pixel_enabled'] as $key) {
            SettingsHelper::set($key, $request->boolean($key) ? '1' : '0');
        }

        Cache::flush();
        return back()->with('success', 'Integraciones actualizadas.');
    }
}
