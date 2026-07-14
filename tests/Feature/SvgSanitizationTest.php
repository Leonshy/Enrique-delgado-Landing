<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SvgSanitizationTest extends TestCase
{
    use RefreshDatabase;

    private const MALICIOUS_SVG = <<<'SVG'
        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" onload="alert('xss')">
          <script>alert('xss-script-tag')</script>
          <circle cx="50" cy="50" r="40" fill="red" onclick="alert('xss-click')"/>
          <a xlink:href="javascript:alert('xss-link')"><rect width="20" height="20"/></a>
        </svg>
        SVG;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    private function loginAsAdmin(): User
    {
        $admin = User::factory()->create();
        $this->actingAs($admin);

        return $admin;
    }

    public function test_uploaded_svg_is_stripped_of_scripts_and_event_handlers(): void
    {
        $this->loginAsAdmin();

        $file = UploadedFile::fake()->createWithContent('malicious.svg', self::MALICIOUS_SVG);

        $response = $this->post(route('admin.media.store'), [
            'files' => [$file],
        ]);

        $response->assertSessionHas('success');

        $asset = \App\Models\MediaAsset::first();
        $this->assertNotNull($asset);

        $stored = Storage::disk('public')->get($asset->path);

        $this->assertStringNotContainsString('<script', $stored);
        $this->assertStringNotContainsString('onload', $stored);
        $this->assertStringNotContainsString('onclick', $stored);
        $this->assertStringNotContainsString('javascript:', $stored);

        // El dibujo en sí (elementos legítimos) tiene que seguir ahí.
        $this->assertStringContainsString('<circle', $stored);
        $this->assertStringContainsString('<rect', $stored);
    }

    public function test_legitimate_svg_uploads_normally(): void
    {
        $this->loginAsAdmin();

        $clean = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"><path d="M12 2L2 22h20z"/></svg>';
        $file = UploadedFile::fake()->createWithContent('logo.svg', $clean);

        $response = $this->post(route('admin.media.store'), [
            'files' => [$file],
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseCount('media_assets', 1);

        $asset = \App\Models\MediaAsset::first();
        $stored = Storage::disk('public')->get($asset->path);
        $this->assertStringContainsString('<path', $stored);
    }

    public function test_malicious_svg_uploaded_as_a_settings_logo_is_also_sanitized(): void
    {
        $this->loginAsAdmin();

        $file = UploadedFile::fake()->createWithContent('logo.svg', self::MALICIOUS_SVG);

        $response = $this->post(route('admin.settings.general.update'), [
            'logo_color' => $file,
        ]);
        $response->assertSessionHasNoErrors();

        $path = \App\Helpers\SettingsHelper::get('logo_color');
        $this->assertNotNull($path);

        $stored = Storage::disk('public')->get($path);
        $this->assertStringNotContainsString('<script', $stored);
        $this->assertStringNotContainsString('onload', $stored);
    }
}
