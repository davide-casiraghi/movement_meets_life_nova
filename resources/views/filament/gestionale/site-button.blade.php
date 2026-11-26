{{-- Bottom of the sidebar: back to the website admin (/dashboard), the twin of the "Gestione studio" button there.
     Shown only to users with an editorial role, the others would get a 403 on /dashboard. --}}
@if (auth()->user()?->hasAnyRole(['Super Admin', 'Admin', 'Post editor', 'Event editor']))
    <div class="gest-site-button-wrap">
        <a href="{{ route('dashboard.index') }}" class="gest-site-button">
            <x-filament::icon icon="heroicon-o-globe-alt" class="gest-icon" />
            <span>Gestione sito</span>
        </a>
    </div>
@endif
