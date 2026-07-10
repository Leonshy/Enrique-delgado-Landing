<?php

namespace App\Http\Controllers;

use App\Helpers\SettingsHelper;
use App\Helpers\SeoHelper;
use App\Http\Requests\ContactRequest;
use App\Mail\ContactMessageMail;
use App\Models\ContactMessage;
use App\Models\Faq;
use App\Models\LandingSection;
use App\Models\LegalPage;
use App\Models\ProcessStep;
use App\Models\ServiceArea;
use App\Models\SessionPlan;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(): View
    {
        return view('landing.index', array_merge($this->sharedData(), [
            'seo'      => SeoHelper::for('home'),
            'sections' => LandingSection::orderBy('order')->get()->keyBy('slug'),
            'areas'    => ServiceArea::active()->get(),
            'steps'        => ProcessStep::active()->get(),
            'faqs'         => Faq::active()->get(),
            'plans'        => SessionPlan::active()->get(),
            'testimonials' => Testimonial::active()->get(),
        ]));
    }

    public function contact(ContactRequest $request): RedirectResponse
    {
        $msg = ContactMessage::create([
            'name'             => $request->validated()['name'],
            'phone'            => $request->validated()['phone'],
            'email'            => $request->validated()['email'],
            'message'          => $request->validated()['message'],
            'privacy_accepted' => true,
            'ip_address'       => $request->ip(),
            'user_agent'       => $request->userAgent(),
        ]);

        try {
            $adminEmail = SettingsHelper::get('admin_email', config('mail.from.address'));
            Mail::to($adminEmail)->send(new ContactMessageMail($msg));
        } catch (\Exception $e) {
            logger()->error('Error enviando email de contacto: ' . $e->getMessage());
        }

        return redirect()->route('home', ['#contacto'])->with('success', '¡Gracias! Recibimos tu consulta. Nos pondremos en contacto a la brevedad.');
    }

    public function legalPage(string $slug): View
    {
        $page = LegalPage::bySlug($slug) ?? abort(404);
        $seo  = SeoHelper::for($slug);
        return view('landing.legal', array_merge($this->sharedData(), compact('page', 'seo')));
    }

    private function sharedData(): array
    {
        return [
            'settings' => [
                'email'       => SettingsHelper::get('contact_email'),
                'whatsapp'    => SettingsHelper::get('whatsapp'),
                'whatsappUrl' => SettingsHelper::whatsappUrl(),
                'location'    => SettingsHelper::get('location'),
                'schedule'    => SettingsHelper::get('schedule'),
                'footer_text' => SettingsHelper::get('footer_text', ''),
            ],
            'integrations' => [
                'hcaptcha_enabled'  => SettingsHelper::get('hcaptcha_enabled', '0') === '1',
                'hcaptcha_site_key' => SettingsHelper::get('hcaptcha_site_key', ''),
                'ga_enabled'        => SettingsHelper::get('ga_enabled', '0') === '1',
                'ga_id'             => SettingsHelper::get('ga_measurement_id', ''),
                'pixel_enabled'     => SettingsHelper::get('pixel_enabled', '0') === '1',
                'pixel_id'          => SettingsHelper::get('pixel_id', ''),
                'head_scripts'      => SettingsHelper::get('custom_head_scripts', ''),
                'body_scripts'      => SettingsHelper::get('custom_body_scripts', ''),
            ],
            'socials' => collect([
                'facebook'  => SettingsHelper::get('social_facebook'),
                'x'         => SettingsHelper::get('social_x'),
                'instagram' => SettingsHelper::get('social_instagram'),
                'linkedin'  => SettingsHelper::get('social_linkedin'),
                'youtube'   => SettingsHelper::get('social_youtube'),
                'tiktok'    => SettingsHelper::get('social_tiktok'),
            ])->filter()->map(fn ($url, $platform) => (object)[
                'platform' => $platform,
                'url'      => $url,
                'label'    => ucfirst($platform),
            ])->values(),
            'legals'  => LegalPage::where('show_in_footer', true)->where('is_active', true)->get(),
        ];
    }

    public function sitemap(): Response
    {
        $legals = LegalPage::where('is_active', true)->get();

        $urls  = '<url><loc>' . url('/') . '</loc><lastmod>' . now()->toAtomString() . '</lastmod><changefreq>weekly</changefreq><priority>1.0</priority></url>';
        foreach ($legals as $page) {
            $urls .= '<url><loc>' . url($page->slug) . '</loc><lastmod>' . $page->updated_at->toAtomString() . '</lastmod><changefreq>monthly</changefreq><priority>0.4</priority></url>';
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . $urls . '</urlset>';

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    public function robots(): Response
    {
        $content = "User-agent: *\nAllow: /\nDisallow: /admin\n\nSitemap: " . url('/sitemap.xml');
        return response($content, 200)->header('Content-Type', 'text/plain');
    }
}
