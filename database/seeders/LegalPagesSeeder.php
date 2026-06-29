<?php

namespace Database\Seeders;

use App\Models\LegalPage;
use Illuminate\Database\Seeder;

class LegalPagesSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'slug'           => 'politica-de-privacidad',
                'title'          => 'Política de Privacidad',
                'show_in_footer' => true,
                'is_active'      => true,
                'content'        => '<h2>1. Responsable del tratamiento</h2>
<p>Enrique Delgado, psicólogo clínico. Email: contacto@enriquedelgado.com</p>

<h2>2. Datos que recopilamos</h2>
<p>Recopilamos únicamente los datos que usted nos proporciona voluntariamente a través del formulario de contacto: nombre, teléfono, email y mensaje.</p>

<h2>3. Finalidad del tratamiento</h2>
<p>Los datos recopilados se utilizan exclusivamente para responder a su consulta y establecer contacto profesional. No se utilizarán para fines comerciales ni serán cedidos a terceros.</p>

<h2>4. Base legal</h2>
<p>El tratamiento de sus datos se basa en el consentimiento explícito que usted otorga al completar el formulario de contacto.</p>

<h2>5. Conservación de datos</h2>
<p>Sus datos serán conservados durante el tiempo necesario para gestionar su consulta y, en caso de establecer una relación terapéutica, durante el período exigido por la normativa profesional aplicable.</p>

<h2>6. Derechos</h2>
<p>Usted tiene derecho a acceder, rectificar, cancelar y oponerse al tratamiento de sus datos personales, enviando una solicitud a: contacto@enriquedelgado.com</p>

<h2>7. Seguridad</h2>
<p>Adoptamos las medidas técnicas y organizativas necesarias para garantizar la seguridad de sus datos personales.</p>',
            ],
            [
                'slug'           => 'consentimiento-tratamiento-datos',
                'title'          => 'Consentimiento de Tratamiento de Datos',
                'show_in_footer' => true,
                'is_active'      => true,
                'content'        => '<h2>Consentimiento informado para el tratamiento de datos</h2>
<p>Al completar el formulario de contacto y marcar la casilla correspondiente, usted otorga su consentimiento expreso para que Enrique Delgado trate sus datos personales (nombre, teléfono, email y mensaje) con la exclusiva finalidad de responder a su consulta profesional.</p>

<p>Sus datos no serán cedidos a terceros ni utilizados con fines comerciales. Podrá revocar este consentimiento en cualquier momento contactando a: contacto@enriquedelgado.com</p>

<p>Para más información consulte nuestra <a href="/politica-de-privacidad">Política de Privacidad</a>.</p>',
            ],
            [
                'slug'           => 'confidencialidad-profesional',
                'title'          => 'Confidencialidad Profesional',
                'show_in_footer' => true,
                'is_active'      => true,
                'content'        => '<h2>Compromiso de Confidencialidad</h2>
<p>Todo el proceso terapéutico, incluyendo el contenido de las sesiones, la identidad del consultante y cualquier información relacionada, está protegido por el deber de confidencialidad profesional del psicólogo.</p>

<h2>Excepciones legales</h2>
<p>La confidencialidad podrá levantarse únicamente en los casos contemplados por la ley: riesgo cierto e inminente para la vida del consultante u otras personas, o cuando así lo exija una orden judicial.</p>

<h2>Alcance</h2>
<p>Este compromiso se extiende a los registros escritos, grabaciones (solo con consentimiento explícito), correos electrónicos y cualquier otra comunicación relacionada con el proceso terapéutico.</p>',
            ],
            [
                'slug'           => 'aviso-legal',
                'title'          => 'Aviso Legal',
                'show_in_footer' => true,
                'is_active'      => true,
                'content'        => '<h2>Titular del sitio</h2>
<p>Enrique Delgado, psicólogo clínico matriculado.</p>

<h2>Objeto</h2>
<p>Este sitio web tiene carácter informativo y su finalidad es facilitar el contacto entre el profesional y personas interesadas en servicios de consulta psicológica. El contenido publicado no constituye diagnóstico ni tratamiento.</p>

<h2>Propiedad intelectual</h2>
<p>Todos los textos, imágenes y elementos de diseño publicados en este sitio son propiedad de Enrique Delgado o han sido utilizados con la debida autorización. Queda prohibida su reproducción sin consentimiento expreso.</p>

<h2>Responsabilidad</h2>
<p>El titular no se responsabiliza por el uso que terceros puedan hacer de la información publicada en este sitio ni por decisiones tomadas en base a su contenido.</p>

<h2>Legislación aplicable</h2>
<p>El presente aviso legal se rige por la legislación vigente en la República del Paraguay.</p>',
            ],
        ];

        foreach ($pages as $p) {
            LegalPage::updateOrCreate(['slug' => $p['slug']], $p);
        }
    }
}
