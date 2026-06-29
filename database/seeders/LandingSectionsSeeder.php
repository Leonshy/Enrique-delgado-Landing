<?php

namespace Database\Seeders;

use App\Models\LandingSection;
use Illuminate\Database\Seeder;

class LandingSectionsSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            [
                'slug'      => 'hero',
                'title'     => 'El Psicólogo del Cambio',
                'subtitle'  => null,
                'body'      => "Los cambios que transforman nuestra calidad de vida comienzan con una meta clara y se construyen mediante acciones concretas.\n\nAyudo a personas, parejas y familias a generar los cambios necesarios para superar obstáculos, fortalecer sus relaciones, desarrollar mejores hábitos y construir una vida más saludable, satisfactoria y alineada con sus objetivos.",
                'extra'     => null,
                'cta_text'  => 'Quiero solicitar una consulta',
                'cta_url'   => '#contacto',
                'image_path'=> null,
                'image_alt' => 'Enrique Delgado, Psicólogo Clínico',
                'is_active' => true,
                'order'     => 1,
            ],
            [
                'slug'      => 'cambio',
                'title'     => 'El cambio sí es posible',
                'subtitle'  => null,
                'body'      => "Los resultados que buscas rara vez aparecen por casualidad.\n\nSurgen cuando existe una meta clara y la disposición para actuar en dirección a ella.\n\nMuchas personas saben qué les gustaría mejorar en sus vidas. Lo difícil es transformar ese deseo en acciones concretas y sostenidas.\n\nAhí es donde puedo ayudarte.",
                'extra'     => 'No se trata de tener todas las respuestas. Se trata de dar el primer paso en la dirección correcta, con el acompañamiento adecuado.',
                'cta_text'  => null,
                'cta_url'   => null,
                'image_path'=> null,
                'image_alt' => null,
                'is_active' => true,
                'order'     => 2,
            ],
            [
                'slug'      => 'enfoque',
                'title'     => 'Mi Enfoque',
                'subtitle'  => 'Las acciones por sobre las palabras.',
                'body'      => "Trabajo desde una perspectiva sistémica e integradora. Esto significa que no observo únicamente el problema que te trae a consulta, sino también el contexto en el que ocurre.\n\nEl bienestar emocional no depende solamente de cómo pensamos. También depende de cómo actuamos, cómo nos relacionamos y qué hábitos construimos día a día.\n\nPor eso la terapia no se limita a comprender los problemas. También busca generar cambios concretos y observables en tu vida cotidiana.",
                'extra'     => null,
                'cta_text'  => null,
                'cta_url'   => null,
                'image_path'=> null,
                'image_alt' => null,
                'is_active' => true,
                'order'     => 3,
            ],
            [
                'slug'      => 'areas',
                'title'     => '¿En qué puedo ayudarte?',
                'subtitle'  => null,
                'body'      => 'A lo largo de nuestra vida enfrentamos situaciones que requieren adaptación, aprendizaje y nuevas formas de actuar. Mi trabajo consiste en ayudarte a identificar objetivos claros y desarrollar estrategias prácticas para alcanzarlos.',
                'extra'     => null,
                'cta_text'  => null,
                'cta_url'   => null,
                'image_path'=> null,
                'image_alt' => null,
                'is_active' => true,
                'order'     => 4,
            ],
            [
                'slug'      => 'sobre-mi',
                'title'     => 'Sobre mí',
                'subtitle'  => 'Psicólogo clínico con formación en terapia sistémica.',
                'body'      => "A lo largo de mi vida he experimentado procesos importantes de adaptación y cambio relacionados con pérdidas familiares, relaciones personales, transformación de hábitos, migración internacional y crecimiento profesional.\n\nViví durante varios años fuera de Paraguay, experiencia que amplió profundamente mi visión sobre las personas, las relaciones humanas y los desafíos que enfrentamos cuando debemos adaptarnos a nuevas circunstancias.\n\nEstas experiencias personales, sumadas a mi formación profesional, me permiten acompañar a personas que desean realizar cambios significativos desde una mirada humana, práctica y orientada a objetivos.",
                'extra'     => null,
                'cta_text'  => null,
                'cta_url'   => null,
                'image_path'=> null,
                'image_alt' => 'Enrique Delgado, Psicólogo Clínico',
                'is_active' => true,
                'order'     => 5,
            ],
            [
                'slug'      => 'proceso',
                'title'     => '¿Cómo funciona el proceso?',
                'subtitle'  => 'Un camino claro y estructurado para comenzar tu proceso de cambio.',
                'body'      => null,
                'extra'     => null,
                'cta_text'  => null,
                'cta_url'   => null,
                'image_path'=> null,
                'image_alt' => null,
                'is_active' => true,
                'order'     => 6,
            ],
            [
                'slug'      => 'planes',
                'title'     => 'Planes de Sesiones',
                'subtitle'  => 'Elige el plan que mejor se adapte a tus necesidades.',
                'body'      => null,
                'extra'     => null,
                'cta_text'  => null,
                'cta_url'   => null,
                'image_path'=> null,
                'image_alt' => null,
                'is_active' => true,
                'order'     => 7,
            ],
            [
                'slug'      => 'faq',
                'title'     => 'Preguntas Frecuentes',
                'subtitle'  => 'Respuestas a las dudas más comunes antes de comenzar.',
                'body'      => null,
                'extra'     => null,
                'cta_text'  => null,
                'cta_url'   => null,
                'image_path'=> null,
                'image_alt' => null,
                'is_active' => true,
                'order'     => 8,
            ],
            [
                'slug'      => 'primer-paso',
                'title'     => 'Dar el Primer Paso',
                'subtitle'  => null,
                'body'      => "No necesitas tener todas las respuestas para comenzar. Muchas veces basta con reconocer que hay algo que no puede seguir así y estar dispuesto a actuar en dirección a ello.\n\nSi existe algún aspecto de tu vida, tus relaciones, tus hábitos o tu bienestar emocional que deseas trabajar, estaré encantado de acompañarte en ese proceso.",
                'extra'     => null,
                'cta_text'  => 'Quiero solicitar una consulta',
                'cta_url'   => '#contacto',
                'image_path'=> null,
                'image_alt' => null,
                'is_active' => true,
                'order'     => 9,
            ],
            [
                'slug'      => 'contacto',
                'title'     => 'Formulario de Contacto',
                'subtitle'  => 'Completa el siguiente formulario y me pondré en contacto contigo a la brevedad para conocer mejor tu situación.',
                'body'      => null,
                'extra'     => null,
                'cta_text'  => null,
                'cta_url'   => null,
                'image_path'=> null,
                'image_alt' => null,
                'is_active' => true,
                'order'     => 10,
            ],
        ];

        foreach ($sections as $s) {
            LandingSection::updateOrCreate(['slug' => $s['slug']], $s);
        }
    }
}
