<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/* ─────────────────────────────────────────────
   FRONTEND — Landing One Page
───────────────────────────────────────────── */
Route::get('/', [LandingController::class, 'index'])->name('home');
Route::post('/contacto', [LandingController::class, 'contact'])->name('contact.send');

// Legal pages
Route::get('/politica-de-privacidad',           [LandingController::class, 'legalPage'])->defaults('slug', 'politica-de-privacidad')->name('legal.privacidad');
Route::get('/consentimiento-tratamiento-datos',  [LandingController::class, 'legalPage'])->defaults('slug', 'consentimiento-tratamiento-datos')->name('legal.consentimiento');
Route::get('/confidencialidad-profesional',      [LandingController::class, 'legalPage'])->defaults('slug', 'confidencialidad-profesional')->name('legal.confidencialidad');
Route::get('/aviso-legal',                       [LandingController::class, 'legalPage'])->defaults('slug', 'aviso-legal')->name('legal.aviso');

// SEO
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
        Route::resource('faqs', Admin\FaqController::class)->except(['show']);

        // Service Areas
        Route::resource('areas', Admin\ServiceAreaController::class)->except(['show']);

        // Process Steps
        Route::resource('proceso', Admin\ProcessStepController::class)->except(['show'])->parameters(['proceso' => 'step']);

        // Session Plans
        Route::resource('planes', Admin\SessionPlanController::class)->except(['show'])->parameters(['planes' => 'plan']);

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

        // Media
        Route::get('/media',                [Admin\MediaController::class, 'index'])->name('media.index');
        Route::post('/media',               [Admin\MediaController::class, 'store'])->name('media.store');
        Route::delete('/media/{asset}',     [Admin\MediaController::class, 'destroy'])->name('media.destroy');
    });
});
