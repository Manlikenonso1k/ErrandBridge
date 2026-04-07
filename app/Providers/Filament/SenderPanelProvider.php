<?php

namespace App\Providers\Filament;

use App\Filament\Sender\Pages\Auth\Login as SenderLogin;
use App\Filament\Sender\Pages\Dashboard as SenderDashboard;
use App\Filament\Sender\Pages\Auth\Register as SenderRegister;
use App\Filament\Sender\Pages\PostErrand;
use App\Filament\Sender\Widgets\RunnerMapWidget;
use App\Http\Middleware\EnsureCorrectPanel;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class SenderPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('sender')
            ->path('sender')
            ->login(SenderLogin::class)
            ->registration(SenderRegister::class)
            ->discoverResources(in: app_path('Filament/Sender/Resources'), for: 'App\\Filament\\Sender\\Resources')
            ->discoverPages(in: app_path('Filament/Sender/Pages'), for: 'App\\Filament\\Sender\\Pages')
            ->pages([
                SenderDashboard::class,
                PostErrand::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Sender/Widgets'), for: 'App\\Filament\\Sender\\Widgets')
            ->widgets([
                RunnerMapWidget::class,
            ])
            ->renderHook(
                'panels::head.end',
                fn () => view('custom-ui'),
            )
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
                EnsureCorrectPanel::class,
            ]);
    }
}
