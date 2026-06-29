<?php

namespace Database\Seeders;

use App\Models\SeoSetting;
use Illuminate\Database\Seeder;

class SeoSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'page'             => 'home',
                'meta_title'       => 'Enrique Delgado — El Psicólogo del Cambio | Terapia Online y Presencial',
                'meta_description' => 'Psicólogo clínico con formación sistémica. Ayudo a personas, parejas y familias a generar cambios reales. Atención online y presencial en Paraguay.',
                'og_title'         => 'Enrique Delgado — El Psicólogo del Cambio',
                'og_description'   => 'Psicólogo clínico con formación sistémica. Terapia individual, de pareja y familiar. Atención online para toda la comunidad hispanohablante.',
                'noindex'          => false,
                'nofollow'         => false,
            ],
            [
                'page'             => 'privacidad',
                'meta_title'       => 'Política de Privacidad — Enrique Delgado',
                'meta_description' => 'Información sobre el tratamiento de tus datos personales.',
                'noindex'          => false,
                'nofollow'         => false,
            ],
            [
                'page'             => 'consentimiento',
                'meta_title'       => 'Consentimiento de Tratamiento de Datos — Enrique Delgado',
                'meta_description' => 'Consentimiento informado para el tratamiento de datos personales.',
                'noindex'          => false,
                'nofollow'         => false,
            ],
            [
                'page'             => 'confidencialidad',
                'meta_title'       => 'Confidencialidad Profesional — Enrique Delgado',
                'meta_description' => 'Política de confidencialidad profesional del psicólogo Enrique Delgado.',
                'noindex'          => false,
                'nofollow'         => false,
            ],
            [
                'page'             => 'aviso-legal',
                'meta_title'       => 'Aviso Legal — Enrique Delgado',
                'meta_description' => 'Aviso legal y condiciones de uso del sitio web.',
                'noindex'          => false,
                'nofollow'         => false,
            ],
        ];

        foreach ($pages as $p) {
            SeoSetting::updateOrCreate(['page' => $p['page']], $p);
        }
    }
}
