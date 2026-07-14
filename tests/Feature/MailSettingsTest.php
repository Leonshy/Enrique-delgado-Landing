<?php

namespace Tests\Feature;

use App\Helpers\SettingsHelper;
use App\Mail\ContactMessageMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class MailSettingsTest extends TestCase
{
    use RefreshDatabase;

    private function loginAsAdmin(): User
    {
        $admin = User::factory()->create();
        $this->actingAs($admin);

        return $admin;
    }

    public function test_contact_message_mail_is_queued_not_sent_synchronously(): void
    {
        $this->assertInstanceOf(ShouldQueue::class, new ContactMessageMail(new \App\Models\ContactMessage()));
    }

    public function test_contact_form_submission_queues_the_email_instead_of_sending_it_immediately(): void
    {
        Mail::fake();

        $this->post(route('contact.send'), [
            'name'             => 'Juana Pérez',
            'phone'            => '+595981000000',
            'email'            => 'juana@example.com',
            'message'          => 'Quisiera agendar una consulta, gracias.',
            'privacy_accepted' => '1',
        ]);

        Mail::assertQueued(ContactMessageMail::class);
    }

    public function test_guest_cannot_access_mail_settings(): void
    {
        $response = $this->get(route('admin.settings.mail'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_mail_settings_default_to_port_465_and_ssl_tls(): void
    {
        $this->loginAsAdmin();

        $settings = \App\Helpers\MailSettingsHelper::settings();

        $this->assertSame('465', $settings['port']);
        $this->assertSame('ssl_tls', $settings['encryption']);
    }

    public function test_saving_mail_settings_persists_them(): void
    {
        $this->loginAsAdmin();

        $response = $this->post(route('admin.settings.mail.update'), [
            'mail_host'         => 'smtp.example.com',
            'mail_port'         => '465',
            'mail_encryption'   => 'ssl_tls',
            'mail_username'     => 'contacto@example.com',
            'mail_password'     => 'super-secreta',
            'mail_from_address' => 'contacto@example.com',
            'mail_from_name'    => 'Enrique Delgado',
        ]);

        $response->assertRedirect();
        $this->assertSame('smtp.example.com', SettingsHelper::get('mail_host'));
        $this->assertTrue(\App\Helpers\MailSettingsHelper::isConfigured());
    }

    public function test_saving_without_a_new_password_keeps_the_old_one(): void
    {
        $this->loginAsAdmin();

        $this->post(route('admin.settings.mail.update'), [
            'mail_host'         => 'smtp.example.com',
            'mail_port'         => '465',
            'mail_encryption'   => 'ssl_tls',
            'mail_username'     => 'contacto@example.com',
            'mail_password'     => 'primera-clave',
            'mail_from_address' => 'contacto@example.com',
        ]);

        $this->post(route('admin.settings.mail.update'), [
            'mail_host'         => 'smtp.example.com',
            'mail_port'         => '465',
            'mail_encryption'   => 'ssl_tls',
            'mail_username'     => 'contacto@example.com',
            'mail_password'     => '', // vacío = no cambiarla
            'mail_from_address' => 'contacto@example.com',
        ]);

        $this->assertSame('primera-clave', SettingsHelper::get('mail_password'));
    }

    public function test_applying_runtime_config_overrides_mail_config_when_configured(): void
    {
        SettingsHelper::set('mail_host', 'smtp.miproveedor.com', 'mail');
        SettingsHelper::set('mail_port', '465', 'mail');
        SettingsHelper::set('mail_encryption', 'ssl_tls', 'mail');
        SettingsHelper::set('mail_username', 'usuario@miproveedor.com', 'mail');
        SettingsHelper::set('mail_password', 'clave', 'mail');
        SettingsHelper::set('mail_from_address', 'usuario@miproveedor.com', 'mail');

        \App\Helpers\MailSettingsHelper::applyToRuntimeConfig();

        $this->assertSame('smtp.miproveedor.com', config('mail.mailers.smtp.host'));
        $this->assertSame(465, config('mail.mailers.smtp.port'));
        $this->assertSame('smtps', config('mail.mailers.smtp.scheme'));
        $this->assertSame('usuario@miproveedor.com', config('mail.from.address'));
    }

    public function test_runtime_config_is_untouched_when_not_configured_from_admin(): void
    {
        $originalHost = config('mail.mailers.smtp.host');

        \App\Helpers\MailSettingsHelper::applyToRuntimeConfig();

        $this->assertSame($originalHost, config('mail.mailers.smtp.host'));
    }

    public function test_test_email_endpoint_reports_a_connection_failure_gracefully(): void
    {
        $this->loginAsAdmin();

        $response = $this->postJson(route('admin.settings.mail.test'), [
            'mail_host'         => 'smtp.host-que-no-existe-para-test.invalid',
            'mail_port'         => '465',
            'mail_encryption'   => 'ssl_tls',
            'mail_username'     => 'user',
            'mail_password'     => 'pass',
            'mail_from_address' => 'contacto@example.com',
            'to'                => 'destino@example.com',
        ]);

        $response->assertOk();
        $response->assertJson(['ok' => false]);
        $this->assertStringContainsString('No se pudo enviar', $response->json('message'));
    }
}
