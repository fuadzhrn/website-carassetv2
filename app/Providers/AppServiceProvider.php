<?php

namespace App\Providers;

use App\View\Composers\SiteSettingsComposer;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Admin components render as <x-admin::name>, kept out of the
        // public site's resources/views/components namespace.
        Blade::anonymousComponentPath(resource_path('views/admin/components'), 'admin');

        // layouts.app @include's header/footer/seo-meta directly, so they
        // inherit this same shared data without needing their own composer.
        // contact-form is included from the child page view before @extends
        // resolves layouts.app, so it needs its own registration.
        View::composer(
            ['layouts.app', 'pages.about-contact.sections.contact-form'],
            SiteSettingsComposer::class,
        );

        // Keyed by IP only (never by message content/WhatsApp — see
        // config/contact-form.php for the tunable limit itself).
        RateLimiter::for('contact-form', function (Request $request) {
            $maxAttempts = (int) config('contact-form.rate_limit.max_attempts', 5);
            $decayMinutes = (int) config('contact-form.rate_limit.decay_minutes', 10);

            return Limit::perMinutes($decayMinutes, $maxAttempts)
                ->by($request->ip())
                ->response(function (Request $request, array $headers) {
                    return back()
                        ->withInput($request->except(['website', 'form_token', '_token']))
                        ->with('contact_error', 'Terlalu banyak permintaan konsultasi. Silakan coba kembali beberapa saat lagi.');
                });
        });
    }
}
