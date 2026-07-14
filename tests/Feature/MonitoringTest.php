<?php

namespace Tests\Feature;

use App\Helpers\SentryHelper;
use App\Helpers\SettingsHelper;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Sentry\SentrySdk;
use Sentry\State\Hub;
use Tests\TestCase;

class MonitoringTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // El cache "array" de test vive durante todo el proceso de PHPUnit, no se resetea
        // solo porque RefreshDatabase vació la base — si no se limpia acá, un test puede
        // "ver" settings que guardó un test anterior aunque la fila ya no exista en la BD.
        \Illuminate\Support\Facades\Cache::flush();
    }

    protected function tearDown(): void
    {
        // Los tests de Sentry cambian el hub global del SDK — hay que resetearlo
        // para no filtrar estado entre tests.
        SentrySdk::setCurrentHub(new Hub());
        parent::tearDown();
    }

    private function loginAsAdmin(): User
    {
        $admin = User::factory()->create();
        $this->actingAs($admin);

        return $admin;
    }

    // --- Sentry ---

    public function test_sentry_is_not_configured_by_default(): void
    {
        $this->assertFalse(SentryHelper::isConfigured());
    }

    public function test_sentry_is_configured_once_enabled_with_a_dsn(): void
    {
        SettingsHelper::set('sentry_enabled', '1', 'integrations');
        SettingsHelper::set('sentry_dsn', 'https://key@o0.ingest.sentry.io/1', 'integrations');

        $this->assertTrue(SentryHelper::isConfigured());
    }

    public function test_applying_runtime_config_initializes_the_sentry_sdk_when_configured(): void
    {
        SettingsHelper::set('sentry_enabled', '1', 'integrations');
        SettingsHelper::set('sentry_dsn', 'https://key@o0.ingest.sentry.io/1', 'integrations');

        SentryHelper::applyToRuntimeConfig();

        $this->assertNotNull(SentrySdk::getCurrentHub()->getClient());
    }

    public function test_applying_runtime_config_does_nothing_when_not_configured(): void
    {
        SentrySdk::setCurrentHub(new Hub());
        SettingsHelper::set('sentry_enabled', '0', 'integrations');

        SentryHelper::applyToRuntimeConfig();

        $this->assertNull(SentrySdk::getCurrentHub()->getClient());
    }

    public function test_guest_cannot_test_sentry(): void
    {
        $response = $this->postJson(route('admin.settings.integrations.sentry.test'), [
            'dsn' => 'https://key@o0.ingest.sentry.io/1',
        ]);

        $response->assertRedirect(route('admin.login'));
    }

    public function test_malformed_dsn_is_rejected_gracefully(): void
    {
        $this->loginAsAdmin();

        $response = $this->postJson(route('admin.settings.integrations.sentry.test'), [
            'dsn' => 'esto-no-es-un-dsn-valido',
        ]);

        $response->assertOk();
        $response->assertJson(['ok' => false]);
    }

    // --- UptimeRobot ---

    public function test_guest_cannot_test_uptimerobot(): void
    {
        $response = $this->postJson(route('admin.settings.integrations.uptimerobot.test'), [
            'api_key' => 'fake-key',
        ]);

        $response->assertRedirect(route('admin.login'));
    }

    public function test_invalid_uptimerobot_api_key_is_rejected_by_the_real_api(): void
    {
        $this->loginAsAdmin();

        $response = $this->postJson(route('admin.settings.integrations.uptimerobot.test'), [
            'api_key' => 'u1234567-fakefakefakefakefakefake',
        ]);

        $response->assertOk();
        $response->assertJson(['ok' => false]);
        $this->assertStringContainsString('inválida', $response->json('message'));
    }

    public function test_status_check_reports_no_monitor_when_none_created_yet(): void
    {
        $this->loginAsAdmin();

        $response = $this->getJson(route('admin.settings.integrations.uptimerobot.status'));

        $response->assertOk();
        $response->assertJson(['ok' => false]);
    }
}
