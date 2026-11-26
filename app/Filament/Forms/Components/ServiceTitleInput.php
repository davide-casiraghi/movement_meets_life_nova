<?php

namespace App\Filament\Forms\Components;

use App\Models\Service;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Concerns\CanBeLengthConstrained;
use Filament\Forms\Components\Concerns\HasPlaceholder;

/**
 * Free text input that, on click, opens a menu with the active services of the
 * price list ("Terapia manuale 50,00 € (30min)"). Choosing one writes its name
 * in the field and fires afterStateUpdated, so the form can copy price,
 * colour and duration. Anything else can still be typed by hand.
 */
class ServiceTitleInput extends Field
{
    use CanBeLengthConstrained;
    use HasPlaceholder;

    protected string $view = 'filament.forms.service-title-input';

    /**
     * @return array<int, array{id: int, name: string, price: string, duration: ?string}>
     */
    public function getServices(): array
    {
        return Service::query()
            ->active()
            ->orderBy('name')
            ->get()
            ->map(fn (Service $s) => [
                'id' => $s->id,
                'name' => $s->name,
                'price' => number_format((float) $s->price, 2, ',', '.').' €',
                'duration' => $s->duration_minutes ? "({$s->duration_minutes}min)" : null,
            ])
            ->all();
    }
}
