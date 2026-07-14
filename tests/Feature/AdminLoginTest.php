<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase;

    private function makeAdmin(string $password = 'CorrectHorse#2026'): User
    {
        return User::factory()->create([
            'email'    => 'admin@enriquedelgado.com',
            'password' => Hash::make($password),
        ]);
    }

    public function test_guest_is_redirected_to_login_when_accessing_protected_admin_route(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect(route('admin.login'));
    }

    public function test_login_page_loads(): void
    {
        $response = $this->get(route('admin.login'));

        $response->assertOk();
        $response->assertSee('Email', false);
    }

    public function test_user_can_login_with_correct_credentials(): void
    {
        $this->makeAdmin('CorrectHorse#2026');

        $response = $this->post(route('admin.login.post'), [
            'email'    => 'admin@enriquedelgado.com',
            'password' => 'CorrectHorse#2026',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();
    }

    public function test_login_fails_with_wrong_password(): void
    {
        $this->makeAdmin('CorrectHorse#2026');

        $response = $this->post(route('admin.login.post'), [
            'email'    => 'admin@enriquedelgado.com',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_login_locks_out_after_five_failed_attempts(): void
    {
        $this->makeAdmin('CorrectHorse#2026');

        for ($i = 0; $i < 5; $i++) {
            $this->post(route('admin.login.post'), [
                'email'    => 'admin@enriquedelgado.com',
                'password' => 'wrong-password',
            ])->assertSessionHasErrors('email');
        }

        // 6th attempt, even with the CORRECT password, must stay blocked.
        $response = $this->post(route('admin.login.post'), [
            'email'    => 'admin@enriquedelgado.com',
            'password' => 'CorrectHorse#2026',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();

        $errors = session('errors')->get('email');
        $this->assertStringContainsString('Demasiados intentos', $errors[0]);
    }

    public function test_logout_clears_the_session(): void
    {
        $admin = $this->makeAdmin();
        $this->actingAs($admin);

        $response = $this->post(route('admin.logout'));

        $response->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }
}
