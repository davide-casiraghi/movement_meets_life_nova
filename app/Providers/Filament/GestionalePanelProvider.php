<?php

namespace App\Providers\Filament;

use App\Filament\Resources\Patients\Pages\ListPatients;
use App\Http\Middleware\SetPanelLocale;
use Filament\Auth\MultiFactor\App\AppAuthentication;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Tables\View\TablesRenderHook;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

/**
 * Personal physiotherapy management panel, reachable at /gestionale.
 *
 * Only users with the "Fisioterapista" role can enter (User::canAccessPanel),
 * and they must set up app-based two-factor authentication before using it.
 */
class GestionalePanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('gestionale')
            ->path('gestionale')
            ->brandName('Gestionale fisioterapia')
            ->login()
            ->passwordReset()
            ->profile(isSimple: false)
            ->multiFactorAuthentication(
                AppAuthentication::make()->recoverable(),
                isRequired: true,
            )
            // Light content with a dark full-height sidebar (no top bar): see resources/views/filament/gestionale/theme.blade.php
            ->topbar(false)
            ->darkMode(false)
            ->renderHook(PanelsRenderHook::HEAD_END, fn () => view('filament.gestionale.theme'))
            ->renderHook(PanelsRenderHook::SIDEBAR_FOOTER, fn () => view('filament.gestionale.site-button'))
            ->renderHook(TablesRenderHook::TOOLBAR_SEARCH_AFTER, fn () => view('filament.gestionale.patients-status-filter'), scopes: ListPatients::class)
            ->colors([
                'primary' => Color::Indigo,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            // Also applied to the Livewire requests of the panel pages.
            ->middleware([SetPanelLocale::class], isPersistent: true)
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
