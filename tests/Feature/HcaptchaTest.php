<?php

namespace Tests\Feature;

use App\Helpers\SettingsHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class HcaptchaTest extends TestCase
{
    use RefreshDatabase;

    private function enableForContact(): void
    {
        SettingsHelper::set('hcaptcha_enabled', '1', 'integrations');
        SettingsHelper::set('hcaptcha_site_key', 'fake-site-key', 'integrations');
        SettingsHelper::set('hcaptcha_secret_key', 'fake-secret-key', 'integrations');
        SettingsHelper::set('hcaptcha_forms', json_encode(['contacto']), 'integrations');
    }

    private function contactPayload(array $overrides = []): array
    {
        return array_merge([
            'name'             => 'Juana Pérez',
            'phone'            => '+595981000000',
            'email'            => 'juana@example.com',
            'message'          => 'Quisiera agendar una consulta, gracias.',
            'privacy_accepted' => '1',
        ], $overrides);
    }

    public function test_contact_form_does_not_require_captcha_when_disabled(): void
    {
        Mail::fake();

        $response = $this->post(route('contact.send'), $this->contactPayload());

        $response->assertSessionDoesntHaveErrors('h-captcha-response');
    }

    public function test_contact_form_requires_captcha_token_when_enabled(): void
    {
        $this->enableForContact();

        $response = $this->post(route('contact.send'), $this->contactPayload());

        $response->assertSessionHasErrors('h-captcha-response');
    }

    public function test_contact_form_rejects_an_invalid_captcha_token(): void
    {
        $this->enableForContact();
        Http::fake([
            'hcaptcha.com/*' => Http::response(['success' => false, 'error-codes' => ['invalid-input-response']]),
        ]);

        $response = $this->post(route('contact.send'), $this->contactPayload([
            'h-captcha-response' => 'un-token-cualquiera',
        ]));

        $response->assertSessionHasErrors('h-captcha-response');
    }

    public function test_contact_form_accepts_a_valid_captcha_token(): void
    {
        $this->enableForContact();
        Mail::fake();
        Http::fake([
            'hcaptcha.com/*' => Http::response(['success' => true]),
        ]);

        $response = $this->post(route('contact.send'), $this->contactPayload([
            'h-captcha-response' => 'un-token-valido',
        ]));

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('contact_messages', ['email' => 'juana@example.com']);
    }

    public function test_login_is_not_gated_by_captcha_by_default(): void
    {
        $response = $this->get(route('admin.login'));

        $response->assertDontSee('h-captcha', false);
    }

    public function test_login_requires_captcha_when_enabled_for_login(): void
    {
        SettingsHelper::set('hcaptcha_enabled', '1', 'integrations');
        SettingsHelper::set('hcaptcha_site_key', 'fake-site-key', 'integrations');
        SettingsHelper::set('hcaptcha_secret_key', 'fake-secret-key', 'integrations');
        SettingsHelper::set('hcaptcha_forms', json_encode(['login']), 'integrations');

        \App\Models\User::factory()->create([
            'email'    => 'admin@enriquedelgado.com',
            'password' => bcrypt('CorrectHorse#2026'),
        ]);

        $response = $this->post(route('admin.login.post'), [
            'email'    => 'admin@enriquedelgado.com',
            'password' => 'CorrectHorse#2026',
        ]);

        $response->assertSessionHasErrors('h-captcha-response');
        $this->assertGuest();
    }
}
