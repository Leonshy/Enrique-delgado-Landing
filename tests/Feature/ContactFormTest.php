<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'name'             => 'Juana Pérez',
            'phone'            => '+595981000000',
            'email'            => 'juana@example.com',
            'message'          => 'Quisiera agendar una consulta para la próxima semana, gracias.',
            'privacy_accepted' => '1',
        ], $overrides);
    }

    public function test_valid_submission_creates_a_message_and_redirects_with_success(): void
    {
        Mail::fake();

        $response = $this->post(route('contact.send'), $this->validPayload());

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('contact_messages', ['email' => 'juana@example.com']);
    }

    public function test_name_is_required(): void
    {
        $response = $this->post(route('contact.send'), $this->validPayload(['name' => '']));

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_message_must_be_at_least_ten_characters(): void
    {
        $response = $this->post(route('contact.send'), $this->validPayload(['message' => 'corto']));

        $response->assertSessionHasErrors('message');
    }

    public function test_privacy_policy_must_be_accepted(): void
    {
        $response = $this->post(route('contact.send'), $this->validPayload(['privacy_accepted' => false]));

        $response->assertSessionHasErrors('privacy_accepted');
    }

    public function test_invalid_email_is_rejected(): void
    {
        $response = $this->post(route('contact.send'), $this->validPayload(['email' => 'no-es-un-email']));

        $response->assertSessionHasErrors('email');
    }

    public function test_rate_limit_blocks_after_three_submissions_from_same_ip(): void
    {
        Mail::fake();

        for ($i = 0; $i < 3; $i++) {
            $this->post(route('contact.send'), $this->validPayload(['email' => "test{$i}@example.com"]))
                ->assertSessionDoesntHaveErrors('rate_limit');
        }

        $response = $this->post(route('contact.send'), $this->validPayload(['email' => 'test4@example.com']));

        $response->assertSessionHasErrors('rate_limit');
        $this->assertDatabaseCount('contact_messages', 3);
    }
}
