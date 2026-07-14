<?php

namespace App\Http\Requests;

use App\Helpers\HcaptchaHelper;
use App\Helpers\SettingsHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;

class ContactRequest extends FormRequest
{
    private const MAX_ATTEMPTS = 3;
    private const DECAY_SECONDS = 600; // 10 minutos

    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name'            => ['required', 'string', 'max:100'],
            'phone'           => ['required', 'string', 'max:30'],
            'email'           => ['required', 'email', 'max:150'],
            'message'         => ['required', 'string', 'min:10', 'max:2000'],
            'privacy_accepted'=> ['required', 'accepted'],
            'h-captcha-response' => $this->hcaptchaRule(),
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'             => 'El nombre es obligatorio.',
            'phone.required'            => 'El teléfono es obligatorio.',
            'email.required'            => 'El email es obligatorio.',
            'email.email'               => 'Ingresa un email válido.',
            'message.required'          => 'El mensaje es obligatorio.',
            'message.min'               => 'El mensaje debe tener al menos 10 caracteres.',
            'privacy_accepted.accepted' => 'Debes aceptar la política de privacidad.',
            'h-captcha-response.required' => 'Por favor completa el captcha.',
        ];
    }

    private function hcaptchaRule(): array
    {
        return HcaptchaHelper::isEnabledFor('contacto') ? ['required'] : [];
    }

    private function throttleKey(): string
    {
        return 'contact-form:' . $this->ip();
    }

    protected function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if (RateLimiter::tooManyAttempts($this->throttleKey(), self::MAX_ATTEMPTS)) {
                $seconds = RateLimiter::availableIn($this->throttleKey());
                $validator->errors()->add(
                    'rate_limit',
                    'Enviaste demasiadas consultas seguidas. Probá de nuevo en ' . ceil($seconds / 60) . ' minuto(s).'
                );
                return;
            }

            RateLimiter::hit($this->throttleKey(), self::DECAY_SECONDS);

            if (!HcaptchaHelper::isEnabledFor('contacto')) return;

            $result = HcaptchaHelper::verify(
                SettingsHelper::get('hcaptcha_secret_key', ''),
                (string) $this->input('h-captcha-response', ''),
                $this->ip()
            );

            if (!$result['ok']) {
                $validator->errors()->add('h-captcha-response', HcaptchaHelper::errorMessages($result['errors']));
            }
        });
    }
}
