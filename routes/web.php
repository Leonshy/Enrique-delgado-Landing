<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/* ─────────────────────────────────────────────
   FRONTEND — Landing One Page
───────────────────────────────────────────── */
Route::middleware('maintenance.mode')->group(function () {
    Route::get('/', [LandingController::class, 'index'])->name('home');
    Route::post('/contacto', [LandingController::class, 'contact'])->name('contact.send');

    // Legal pages
    Route::get('/politica-de-privacidad',           [LandingController::class, 'legalPage'])->defaults('slug', 'politica-de-privacidad')->name('legal.privacidad');
    Route::get('/consentimiento-tratamiento-datos',  [LandingController::class, 'legalPage'])->defaults('slug', 'consentimiento-tratamiento-datos')->name('legal.consentimiento');
    Route::get('/confidencialidad-profesional',      [LandingController::class, 'legalPage'])->defaults('slug', 'confidencialidad-profesional')->name('legal.confidencialidad');
    Route::get('/aviso-legal',                       [LandingController::class, 'legalPage'])->defaults('slug', 'aviso-legal')->name('legal.aviso');
});

// SEO — accessible even in maintenance mode
Route::get('/sitemap.xml', [LandingController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt',  [LandingController::class, 'robots'])->name('robots');

/* ─────────────────────────────────────────────
   ADMIN — Authentication
───────────────────────────────────────────── */
Route::prefix('admin')->name('admin.')->group(function () {

    // Public admin routes (login)
    Route::get('/login',   [Admin\AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',  [Admin\AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [Admin\AuthController::class, 'logout'])->name('logout');

    // Protected admin routes
    Route::middleware('admin')->group(function () {

        Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

        // Portada (Hero)
        Route::get('/portada',  [Admin\PortadaController::class, 'edit'])->name('portada.edit');
        Route::put('/portada',  [Admin\PortadaController::class, 'update'])->name('portada.update');

        // Enfoque
        Route::get('/enfoque',  [Admin\EnfoqueController::class, 'edit'])->name('enfoque.edit');
        Route::put('/enfoque',  [Admin\EnfoqueController::class, 'update'])->name('enfoque.update');

        // Sobre mí
        Route::get('/sobre-mi', [Admin\SobreMiController::class, 'edit'])->name('sobre-mi.edit');
        Route::put('/sobre-mi', [Admin\SobreMiController::class, 'update'])->name('sobre-mi.update');

        // Landing sections
        Route::get('/landing',                        [Admin\LandingController::class, 'index'])->name('landing.index');
        Route::get('/landing/{section}/edit',         [Admin\LandingController::class, 'edit'])->name('landing.edit');
        Route::put('/landing/{section}',              [Admin\LandingController::class, 'update'])->name('landing.update');

        // Messages
        Route::get('/consultas',                              [Admin\MessagesController::class, 'index'])->name('messages.index');
        Route::get('/consultas/{message}',                    [Admin\MessagesController::class, 'show'])->name('messages.show');
        Route::patch('/consultas/{message}/read',             [Admin\MessagesController::class, 'markRead'])->name('messages.read');
        Route::patch('/consultas/{message}/respondida',       [Admin\MessagesController::class, 'markResponded'])->name('messages.responded');
        Route::delete('/consultas/{message}',                 [Admin\MessagesController::class, 'destroy'])->name('messages.destroy');
        Route::get('/consultas/exportar/csv',                 [Admin\MessagesController::class, 'export'])->name('messages.export');

        // FAQs
        Route::put('/faqs/seccion', [Admin\FaqController::class, 'updateSection'])->name('faqs.section.update');
        Route::resource('faqs', Admin\FaqController::class)->except(['show']);

        // Service Areas
        Route::put('/areas/seccion', [Admin\ServiceAreaController::class, 'updateSection'])->name('areas.section.update');
        Route::resource('areas', Admin\ServiceAreaController::class)->except(['show']);

        // Process Steps
        Route::put('/proceso/seccion', [Admin\ProcessStepController::class, 'updateSection'])->name('proceso.section.update');
        Route::resource('proceso', Admin\ProcessStepController::class)->except(['show'])->parameters(['proceso' => 'step']);

        // Video
        Route::get('/video', [Admin\VideoController::class, 'edit'])->name('video.edit');
        Route::put('/video', [Admin\VideoController::class, 'update'])->name('video.update');

        // Session Plans
        Route::put('/planes/seccion', [Admin\SessionPlanController::class, 'updateSection'])->name('planes.section.update');
        Route::resource('planes', Admin\SessionPlanController::class)->except(['show'])->parameters(['planes' => 'plan']);

        // Testimonials
        Route::put('/testimonios/seccion', [Admin\TestimonialController::class, 'updateSection'])->name('testimonios.section.update');
        Route::resource('testimonios', Admin\TestimonialController::class)->except(['show'])->parameters(['testimonios' => 'testimonio']);

        // CTA Banner
        Route::get('/cta-banner',  [Admin\CtaBannerController::class, 'edit'])->name('cta-banner.edit');
        Route::put('/cta-banner',  [Admin\CtaBannerController::class, 'update'])->name('cta-banner.update');

        // Contacto
        Route::get('/contacto',  [Admin\ContactoController::class, 'edit'])->name('contacto.edit');
        Route::put('/contacto',  [Admin\ContactoController::class, 'update'])->name('contacto.update');

        // SEO
        Route::get('/seo',             [Admin\SeoController::class, 'index'])->name('seo.index');
        Route::get('/seo/{seo}/edit',  [Admin\SeoController::class, 'edit'])->name('seo.edit');
        Route::put('/seo/{seo}',       [Admin\SeoController::class, 'update'])->name('seo.update');

        // Legal pages
        Route::get('/legales',               [Admin\LegalPageController::class, 'index'])->name('legales.index');
        Route::get('/legales/{page}/edit',   [Admin\LegalPageController::class, 'edit'])->name('legales.edit');
        Route::put('/legales/{page}',        [Admin\LegalPageController::class, 'update'])->name('legales.update');

        // Settings
        Route::get('/configuracion',         [Admin\SettingsController::class, 'general'])->name('settings.general');
        Route::post('/configuracion',        [Admin\SettingsController::class, 'updateGeneral'])->name('settings.general.update');
        Route::get('/integraciones',         [Admin\SettingsController::class, 'integrations'])->name('settings.integrations');
        Route::post('/integraciones',        [Admin\SettingsController::class, 'updateIntegrations'])->name('settings.integrations.update');
        Route::get('/colores',               [Admin\SettingsController::class, 'colors'])->name('settings.colors');
        Route::post('/colores',              [Admin\SettingsController::class, 'updateColors'])->name('settings.colors.update');
        Route::post('/colores/reset',        [Admin\SettingsController::class, 'resetColors'])->name('settings.colors.reset');

        // Media
        Route::get('/media',                [Admin\MediaController::class, 'index'])->name('media.index');
        Route::post('/media',               [Admin\MediaController::class, 'store'])->name('media.store');
        Route::get('/media/list',           [Admin\MediaController::class, 'listJson'])->name('media.list');
        Route::post('/media/upload',        [Admin\MediaController::class, 'uploadJson'])->name('media.upload');
        Route::delete('/media/{asset}',     [Admin\MediaController::class, 'destroy'])->name('media.destroy');
    });
});
