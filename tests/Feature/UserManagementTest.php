<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Contracts\Validation\UncompromisedVerifier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Evita depender de la red (API de Have I Been Pwned) en los tests:
        // simula que ninguna contraseña de prueba aparece en filtraciones conocidas.
        $this->app->bind(UncompromisedVerifier::class, fn () => new class implements UncompromisedVerifier {
            public function verify($data) { return true; }
        });
    }

    private function loginAsAdmin(): User
    {
        $admin = User::factory()->create();
        $this->actingAs($admin);

        return $admin;
    }

    public function test_guest_cannot_access_user_management(): void
    {
        $response = $this->get(route('admin.usuarios.index'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_short_password_is_rejected(): void
    {
        $this->loginAsAdmin();

        $response = $this->post(route('admin.usuarios.store'), [
            'name' => 'Nuevo Usuario',
            'email' => 'nuevo@example.com',
            'password' => 'Abc12345',
            'password_confirmation' => 'Abc12345',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertDatabaseMissing('users', ['email' => 'nuevo@example.com']);
    }

    public function test_password_without_symbol_is_rejected(): void
    {
        $this->loginAsAdmin();

        $response = $this->post(route('admin.usuarios.store'), [
            'name' => 'Nuevo Usuario',
            'email' => 'nuevo@example.com',
            'password' => 'SinSimboloAqui123',
            'password_confirmation' => 'SinSimboloAqui123',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_password_without_mixed_case_is_rejected(): void
    {
        $this->loginAsAdmin();

        $response = $this->post(route('admin.usuarios.store'), [
            'name' => 'Nuevo Usuario',
            'email' => 'nuevo@example.com',
            'password' => 'todominuscula#123',
            'password_confirmation' => 'todominuscula#123',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_mismatched_confirmation_is_rejected(): void
    {
        $this->loginAsAdmin();

        $response = $this->post(route('admin.usuarios.store'), [
            'name' => 'Nuevo Usuario',
            'email' => 'nuevo@example.com',
            'password' => 'ContraseñaFuerte#123',
            'password_confirmation' => 'OtraDistinta#456',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_strong_password_creates_the_user(): void
    {
        $this->loginAsAdmin();

        $response = $this->post(route('admin.usuarios.store'), [
            'name' => 'Nuevo Usuario',
            'email' => 'nuevo@example.com',
            'password' => 'Xk9#mQ2vLp7z',
            'password_confirmation' => 'Xk9#mQ2vLp7z',
        ]);

        $response->assertRedirect(route('admin.usuarios.index'));
        $this->assertDatabaseHas('users', ['email' => 'nuevo@example.com']);
    }

    public function test_user_cannot_delete_their_own_account(): void
    {
        $admin = $this->loginAsAdmin();

        $response = $this->delete(route('admin.usuarios.destroy', $admin));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_last_remaining_user_cannot_be_deleted(): void
    {
        // Con un solo usuario en toda la base, intentar borrarlo (desde otra sesión
        // ya autenticada como ese mismo usuario) tiene que fallar por ser el último,
        // no solo por la protección de "no podés borrarte a vos mismo".
        $onlyUser = User::factory()->create();

        $this->actingAs($onlyUser)
            ->delete(route('admin.usuarios.destroy', $onlyUser));

        $this->assertDatabaseCount('users', 1);
    }

    public function test_deleting_another_user_is_allowed_when_more_than_one_exists(): void
    {
        $admin = $this->loginAsAdmin();
        $other = User::factory()->create();

        $response = $this->delete(route('admin.usuarios.destroy', $other));

        $response->assertRedirect(route('admin.usuarios.index'));
        $this->assertDatabaseMissing('users', ['id' => $other->id]);
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_editing_without_password_keeps_the_old_one(): void
    {
        $original = Hash::make('OriginalPass#123');
        $user = User::factory()->create(['password' => $original]);
        $this->loginAsAdmin();

        $this->put(route('admin.usuarios.update', $user), [
            'name'  => 'Nombre Actualizado',
            'email' => $user->email,
        ]);

        $user->refresh();
        $this->assertSame($original, $user->password);
        $this->assertSame('Nombre Actualizado', $user->name);
    }
}
