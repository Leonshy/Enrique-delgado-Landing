<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrustProxiesTest extends TestCase
{
    use RefreshDatabase;

    public function test_real_client_ip_is_resolved_from_x_forwarded_for_when_request_comes_from_a_trusted_proxy(): void
    {
        // El TestCase de Laravel simula la conexión como si viniera de 127.0.0.1,
        // que está en la lista de proxies de confianza — como el nginx interno de Plesk.
        $response = $this->withHeaders([
            'X-Forwarded-For'   => '203.0.113.42',
            'X-Forwarded-Proto' => 'https',
        ])->get('/up');

        $response->assertOk();
        $this->assertSame('203.0.113.42', request()->ip());
        $this->assertTrue(request()->isSecure());
    }

    public function test_login_rate_limit_is_scoped_per_real_visitor_ip_not_the_proxy(): void
    {
        \App\Models\User::factory()->create(['email' => 'admin@enriquedelgado.com']);

        // Visitante 1 (detrás del mismo proxy interno) agota sus intentos.
        for ($i = 0; $i < 5; $i++) {
            $this->withHeaders(['X-Forwarded-For' => '203.0.113.10'])
                ->post(route('admin.login.post'), ['email' => 'admin@enriquedelgado.com', 'password' => 'mal']);
        }
        $blocked = $this->withHeaders(['X-Forwarded-For' => '203.0.113.10'])
            ->post(route('admin.login.post'), ['email' => 'admin@enriquedelgado.com', 'password' => 'mal']);
        $blocked->assertSessionHasErrors('email');
        $this->assertStringContainsString('Demasiados intentos', session('errors')->get('email')[0]);

        // Visitante 2, mismo proxy pero otra IP real, no debería estar afectado.
        $otherVisitor = $this->withHeaders(['X-Forwarded-For' => '203.0.113.99'])
            ->post(route('admin.login.post'), ['email' => 'admin@enriquedelgado.com', 'password' => 'mal']);
        $otherVisitor->assertSessionHasErrors('email');
        $this->assertStringNotContainsString('Demasiados intentos', session('errors')->get('email')[0] ?? '');
    }
}
