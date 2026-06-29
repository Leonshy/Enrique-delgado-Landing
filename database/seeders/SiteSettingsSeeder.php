<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            ['key' => 'site_name',        'value' => 'Enrique Delgado — El Psicólogo del Cambio', 'type' => 'text',    'group' => 'general', 'label' => 'Nombre del sitio'],
            ['key' => 'site_tagline',     'value' => 'El Psicólogo del Cambio',                    'type' => 'text',    'group' => 'general', 'label' => 'Eslogan'],
            ['key' => 'logo_color',       'value' => null,                                          'type' => 'image',   'group' => 'general', 'label' => 'Logo a color'],
            ['key' => 'logo_white',       'value' => null,                                          'type' => 'image',   'group' => 'general', 'label' => 'Logo blanco'],
            ['key' => 'isotipo',          'value' => null,                                          'type' => 'image',   'group' => 'general', 'label' => 'Isotipo'],
            ['key' => 'favicon',          'value' => null,                                          'type' => 'image',   'group' => 'general', 'label' => 'Favicon'],

            // Contact
            ['key' => 'contact_email',   'value' => 'contacto@enriquedelgado.com', 'type' => 'text', 'group' => 'contact', 'label' => 'Email de contacto'],
            ['key' => 'admin_email',     'value' => 'admin@enriquedelgado.com',    'type' => 'text', 'group' => 'contact', 'label' => 'Email administrador (recibe consultas)'],
            ['key' => 'whatsapp',        'value' => '+595981000000',               'type' => 'text', 'group' => 'contact', 'label' => 'WhatsApp'],
            ['key' => 'whatsapp_msg',    'value' => 'Hola Enrique, me interesa solicitar una consulta.', 'type' => 'text', 'group' => 'contact', 'label' => 'Mensaje WhatsApp'],
            ['key' => 'location',        'value' => 'Asunción, Paraguay',          'type' => 'text', 'group' => 'contact', 'label' => 'Ubicación'],
            ['key' => 'schedule',        'value' => 'Lunes a viernes: 9:00 – 20:00',  'type' => 'text', 'group' => 'contact', 'label' => 'Horario de atención'],

            // Integrations
            ['key' => 'hcaptcha_enabled',    'value' => '0',  'type' => 'boolean', 'group' => 'integrations', 'label' => 'hCaptcha activo'],
            ['key' => 'hcaptcha_site_key',   'value' => '',   'type' => 'text',    'group' => 'integrations', 'label' => 'hCaptcha Site Key'],
            ['key' => 'hcaptcha_secret_key', 'value' => '',   'type' => 'text',    'group' => 'integrations', 'label' => 'hCaptcha Secret Key'],
            ['key' => 'ga_enabled',          'value' => '0',  'type' => 'boolean', 'group' => 'integrations', 'label' => 'Google Analytics activo'],
            ['key' => 'ga_measurement_id',   'value' => '',   'type' => 'text',    'group' => 'integrations', 'label' => 'GA Measurement ID'],
            ['key' => 'pixel_enabled',       'value' => '0',  'type' => 'boolean', 'group' => 'integrations', 'label' => 'Meta Pixel activo'],
            ['key' => 'pixel_id',            'value' => '',   'type' => 'text',    'group' => 'integrations', 'label' => 'Meta Pixel ID'],
            ['key' => 'custom_head_scripts', 'value' => '',   'type' => 'textarea','group' => 'integrations', 'label' => 'Scripts personalizados <head>'],
            ['key' => 'custom_body_scripts', 'value' => '',   'type' => 'textarea','group' => 'integrations', 'label' => 'Scripts personalizados antes de </body>'],
        ];

        foreach ($settings as $s) {
            SiteSetting::updateOrCreate(['key' => $s['key']], $s);
        }
    }
}
