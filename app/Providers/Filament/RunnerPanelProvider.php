<?php

namespace App\Providers\Filament;

use App\Filament\Runner\Pages\Auth\Login as RunnerLogin;
use App\Filament\Runner\Pages\Dashboard as RunnerDashboard;
use App\Filament\Runner\Pages\Auth\Register as RunnerRegister;
use App\Filament\Runner\Pages\RunnerMap;
use App\Filament\Runner\Widgets\AvailableErrandsMapWidget;
use Filament\Navigation\NavigationGroup;
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

class RunnerPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('runner')
            ->path('runner')
            ->login(RunnerLogin::class)
            ->registration(RunnerRegister::class)
            ->navigationGroups([
                NavigationGroup::make()->label('ERRANDS'),
                NavigationGroup::make()->label('EARNINGS'),
                NavigationGroup::make()->label('ACCOUNT'),
                NavigationGroup::make()->label('SUPPORT'),
            ])
            ->discoverResources(in: app_path('Filament/Runner/Resources'), for: 'App\\Filament\\Runner\\Resources')
            ->discoverPages(in: app_path('Filament/Runner/Pages'), for: 'App\\Filament\\Runner\\Pages')
            ->pages([
                RunnerDashboard::class,
                RunnerMap::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Runner/Widgets'), for: 'App\\Filament\\Runner\\Widgets')
            ->widgets([
                AvailableErrandsMapWidget::class,
            ])
            ->renderHook(
                'panels::head.end',
                fn () => view('custom-ui'),
            )
            ->renderHook(
                'panels::content.start',
                fn () => view('filament.runner.partials.active-errand-banner'),
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
