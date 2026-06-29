<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\ProcessStep;
use App\Models\ServiceArea;
use App\Models\SessionPlan;
use App\Models\SocialLink;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        // ── Service Areas ───────────────────────────────────────────
        $areas = [
            ['title' => 'Relaciones de pareja',    'order' => 1],
            ['title' => 'Conflictos familiares',   'order' => 2],
            ['title' => 'Ansiedad y emociones',    'order' => 3],
            ['title' => 'Migración y adaptación',  'order' => 4],
            ['title' => 'Autoestima y confianza',  'order' => 5],
            ['title' => 'Hábitos saludables',      'order' => 6],
            ['title' => 'Organización personal',   'order' => 7],
            ['title' => 'Comunicación efectiva',   'order' => 8],
            ['title' => 'Bienestar integral',      'order' => 9],
        ];
        foreach ($areas as $a) {
            ServiceArea::updateOrCreate(['title' => $a['title']], array_merge($a, ['is_active' => true]));
        }

        // ── Process Steps ────────────────────────────────────────────
        $steps = [
            [
                'step_number' => 1,
                'title'       => 'Completa el formulario inicial',
                'description' => 'Cuéntame brevemente tu situación y lo que deseas trabajar.',
                'order'       => 1,
            ],
            [
                'step_number' => 2,
                'title'       => 'Primer contacto por WhatsApp',
                'description' => 'Al completar el formulario te enviamos el presupuesto personalizado.',
                'order'       => 2,
            ],
            [
                'step_number' => 3,
                'title'       => 'Reserva de turno',
                'description' => 'Al seleccionar el plan adecuado procedemos a agendar nuestra primera sesión.',
                'order'       => 3,
            ],
            [
                'step_number' => 4,
                'title'       => 'Primera sesión',
                'description' => 'Se establecen objetivos claros y la firma del consentimiento informado.',
                'order'       => 4,
            ],
        ];
        foreach ($steps as $s) {
            ProcessStep::updateOrCreate(['step_number' => $s['step_number']], array_merge($s, ['is_active' => true]));
        }

        // ── FAQs ─────────────────────────────────────────────────────
        $faqs = [
            [
                'question' => '¿La terapia es online o presencial?',
                'answer'   => 'Sí. Atiendo de manera presencial a personas de Paraguay así como también online a personas de países de habla hispana.',
                'order'    => 1,
            ],
            [
                'question' => '¿Atiendes personas que viven en el extranjero?',
                'answer'   => 'Sí. Tengo especial interés y experiencia acompañando a hispanos en sus procesos migratorios y de adaptación al nuevo lugar.',
                'order'    => 2,
            ],
            [
                'question' => '¿Cuánto dura una sesión?',
                'answer'   => 'Aproximadamente 50 a 60 minutos por sesión.',
                'order'    => 3,
            ],
            [
                'question' => '¿Con qué frecuencia se realizan las sesiones?',
                'answer'   => 'Generalmente una vez por semana, aunque esto puede variar según cada caso y necesidad.',
                'order'    => 4,
            ],
            [
                'question' => '¿La información es confidencial?',
                'answer'   => 'Sí. Todo el proceso terapéutico está protegido por el deber de confidencialidad profesional.',
                'order'    => 5,
            ],
            [
                'question' => '¿Atiendes en otros idiomas?',
                'answer'   => 'Sí. También atiendo en inglés de manera presencial u online.',
                'order'    => 6,
            ],
            [
                'question' => '¿Trabajas con otros profesionales?',
                'answer'   => 'Sí, la salud mental muchas veces requiere un abordaje integral, por lo que trabajo de manera interdisciplinaria con nutricionistas, psiquiatras, médicos, personal trainers y otros profesionales de terapias alternativas.',
                'order'    => 7,
            ],
            [
                'question' => '¿Existen planes de sesiones?',
                'answer'   => 'Sí, actualmente cuento con la opción de abonar por 1 sola consulta, o un paquete de 5 o 10 sesiones. Los paquetes ofrecen descuentos importantes y flexibilidad de trabajo.',
                'order'    => 8,
            ],
        ];
        foreach ($faqs as $f) {
            Faq::updateOrCreate(['question' => $f['question']], array_merge($f, ['is_active' => true]));
        }

        // ── Session Plans ────────────────────────────────────────────
        $plans = [
            [
                'name'        => 'Consulta Individual',
                'subtitle'    => '1 sesión',
                'description' => 'Para quienes desean comenzar con una primera sesión y evaluar el proceso.',
                'is_featured' => false,
                'order'       => 1,
            ],
            [
                'name'        => 'Paquete de 5 Sesiones',
                'subtitle'    => '5 sesiones',
                'description' => 'Para quienes desean trabajar objetivos concretos con continuidad.',
                'is_featured' => true,
                'order'       => 2,
            ],
            [
                'name'        => 'Paquete de 10 Sesiones',
                'subtitle'    => '10 sesiones',
                'description' => 'Para procesos más profundos, sostenidos y con mayor flexibilidad de trabajo.',
                'is_featured' => false,
                'order'       => 3,
            ],
        ];
        foreach ($plans as $p) {
            SessionPlan::updateOrCreate(['name' => $p['name']], array_merge($p, ['is_active' => true]));
        }

        // ── Social Links ─────────────────────────────────────────────
        $socials = [
            ['platform' => 'instagram', 'label' => 'Instagram', 'url' => 'https://instagram.com/', 'order' => 1],
            ['platform' => 'facebook',  'label' => 'Facebook',  'url' => 'https://facebook.com/',  'order' => 2],
            ['platform' => 'linkedin',  'label' => 'LinkedIn',  'url' => 'https://linkedin.com/',  'order' => 3],
        ];
        foreach ($socials as $s) {
            SocialLink::updateOrCreate(['platform' => $s['platform']], array_merge($s, ['is_active' => true]));
        }
    }
}
