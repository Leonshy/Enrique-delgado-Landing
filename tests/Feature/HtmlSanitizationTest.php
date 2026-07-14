<?php

namespace Tests\Feature;

use App\Models\Faq;
use App\Models\LandingSection;
use App\Models\LegalPage;
use App\Models\SessionPlan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HtmlSanitizationTest extends TestCase
{
    use RefreshDatabase;

    private const MALICIOUS_HTML = '<p>Hola</p><script>alert("xss")</script><img src=x onerror="alert(1)"><a href="javascript:alert(2)">click</a>';

    private function loginAsAdmin(): User
    {
        $admin = User::factory()->create();
        $this->actingAs($admin);

        return $admin;
    }

    public function test_enfoque_description_is_sanitized_on_save(): void
    {
        $this->loginAsAdmin();
        LandingSection::create(['slug' => 'enfoque']);

        $this->put(route('admin.enfoque.update'), [
            'title'       => 'Mi Enfoque',
            'description' => self::MALICIOUS_HTML,
        ]);

        $stored = LandingSection::where('slug', 'enfoque')->first()->subtitle;
        $this->assertStringNotContainsString('<script', $stored);
        $this->assertStringNotContainsString('onerror', $stored);
        $this->assertStringNotContainsString('javascript:', $stored);
        $this->assertStringContainsString('<p>Hola</p>', $stored);
    }

    public function test_sobre_mi_body_is_sanitized_on_save(): void
    {
        $this->loginAsAdmin();
        LandingSection::create(['slug' => 'sobre-mi']);

        $this->put(route('admin.sobre-mi.update'), [
            'title' => 'Sobre mí',
            'body'  => self::MALICIOUS_HTML,
        ]);

        $stored = LandingSection::where('slug', 'sobre-mi')->first()->body;
        $this->assertStringNotContainsString('<script', $stored);
        $this->assertStringNotContainsString('onerror', $stored);
        $this->assertStringContainsString('<p>Hola</p>', $stored);
    }

    public function test_faq_answer_is_sanitized_on_save(): void
    {
        $this->loginAsAdmin();

        $this->post(route('admin.faqs.store'), [
            'question' => '¿Pregunta de prueba?',
            'answer'   => self::MALICIOUS_HTML,
        ]);

        $stored = Faq::first()->answer;
        $this->assertStringNotContainsString('<script', $stored);
        $this->assertStringNotContainsString('onerror', $stored);
        $this->assertStringNotContainsString('javascript:', $stored);
        $this->assertStringContainsString('<p>Hola</p>', $stored);
    }

    public function test_plan_description_is_sanitized_on_save(): void
    {
        $this->loginAsAdmin();

        $this->post(route('admin.planes.store'), [
            'name'        => 'Plan de prueba',
            'description' => self::MALICIOUS_HTML,
        ]);

        $stored = SessionPlan::first()->description;
        $this->assertStringNotContainsString('<script', $stored);
        $this->assertStringNotContainsString('onerror', $stored);
        $this->assertStringContainsString('<p>Hola</p>', $stored);
    }

    public function test_legal_page_content_is_sanitized_on_save(): void
    {
        $this->loginAsAdmin();
        $page = LegalPage::create([
            'slug'    => 'pagina-de-prueba',
            'title'   => 'Página de prueba',
            'content' => 'contenido inicial',
        ]);

        $this->put(route('admin.legales.update', $page), [
            'title'   => 'Página de prueba',
            'content' => self::MALICIOUS_HTML,
        ]);

        $stored = $page->fresh()->content;
        $this->assertStringNotContainsString('<script', $stored);
        $this->assertStringNotContainsString('onerror', $stored);
        $this->assertStringNotContainsString('javascript:', $stored);
        $this->assertStringContainsString('<p>Hola</p>', $stored);
    }

    public function test_sanitizer_keeps_allowed_formatting_intact(): void
    {
        $clean = \App\Helpers\HtmlSanitizer::clean(
            '<p>Texto <strong>fuerte</strong> y <em>cursiva</em>, con un <a href="https://example.com">link</a>.</p><ul><li>Uno</li><li>Dos</li></ul>'
        );

        $this->assertStringContainsString('<strong>fuerte</strong>', $clean);
        $this->assertStringContainsString('<em>cursiva</em>', $clean);
        $this->assertStringContainsString('href="https://example.com"', $clean);
        $this->assertStringContainsString('<li>Uno</li>', $clean);
    }
}
