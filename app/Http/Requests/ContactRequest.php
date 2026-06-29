<?php

namespace App\Http\Requests;

use App\Helpers\SettingsHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Http;

class ContactRequest extends FormRequest
{
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
        $enabled = SettingsHelper::get('hcaptcha_enabled', '0') === '1';
        return $enabled ? ['required'] : [];
    }

    protected function withValidator($validator): void
    {
        $enabled = SettingsHelper::get('hcaptcha_enabled', '0') === '1';
        if (!$enabled) return;

        $validator->after(function ($validator) {
            $token      = $this->input('h-captcha-response');
            $secretKey  = SettingsHelper::get('hcaptcha_secret_key', '');

            if (!$token || !$secretKey) {
                $validator->errors()->add('h-captcha-response', 'Por favor completa el captcha.');
                return;
            }

            try {
                $response = Http::asForm()->post('https://hcaptcha.com/siteverify', [
                    'secret'   => $secretKey,
                    'response' => $token,
                    'remoteip' => $this->ip(),
                ]);

                if (!($response->json('success') ?? false)) {
                    $validator->errors()->add('h-captcha-response', 'Captcha inválido. Inténtalo nuevamente.');
                }
            } catch (\Exception) {
                $validator->errors()->add('h-captcha-response', 'Error al verificar el captcha. Inténtalo nuevamente.');
            }
        });
    }
}
