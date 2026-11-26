<?php

namespace App\Filament\Resources\Invoices\Pages;

use App\Filament\Pages\Contabilita;
use App\Filament\Resources\Invoices\InvoiceResource;
use App\Models\Patient;
use App\Services\Gestionale\InvoiceCalculator;
use Carbon\CarbonImmutable;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Icons\Heroicon;

/**
 * "Nuovo documento contabile". The buttons ("Indietro", "Crea documento") sit in the
 * sticky totals bar at the bottom (filament.gestionale.invoice-summary).
 */
class CreateInvoice extends CreateRecord
{
    protected static string $resource = InvoiceResource::class;

    protected static ?string $title = 'Nuovo documento contabile';

    public function getBreadcrumbs(): array
    {
        return [];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Indietro')
                ->icon(Heroicon::ArrowLeft)
                ->link()
                ->color('gray')
                ->url(Contabilita::getUrl()),
        ];
    }

    protected function getFormActions(): array
    {
        return [];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $patient = Patient::withTrashed()->findOrFail($data['patient_id']);

        foreach (['stamp_amount', 'contribution_rate', 'withholding_rate'] as $field) {
            $data[$field] = InvoiceCalculator::number($data[$field] ?? 0);
        }

        if (empty($data['withholding_enabled'])) {
            $data['withholding_type'] = $data['withholding_reason'] = $data['withholding_base'] = null;
        } else {
            $data['withholding_base'] = InvoiceCalculator::number($data['withholding_base'] ?? 0);
        }

        return [
            ...$data,
            'year' => CarbonImmutable::parse($data['issued_on'])->year,
            'paid_on' => ! empty($data['paid']) ? $data['paid_on'] : null,
            'causals' => array_values(array_filter($data['causals'] ?? [], 'filled')),
            // The customer as they are today: later changes to the patient do not alter the invoice.
            'customer' => [
                'person_type' => $patient->person_type?->value,
                'name' => $patient->full_name,
                'fiscal_code' => $patient->fiscal_code,
                'vat_number' => $patient->vat_number,
                'recipient_code' => $patient->recipient_code,
                'pec' => $patient->pec,
                'email' => $patient->email,
                'address' => $patient->address,
                'postal_code' => $patient->postal_code,
                'city' => $patient->city,
                'province' => $patient->province,
                'country' => $patient->address_country,
            ],
        ];
    }

    protected function afterCreate(): void
    {
        $this->getRecord()->recalculate();
    }

    protected function getCreatedNotificationTitle(): string
    {
        return 'Documento '.$this->getRecord()->display_number.' creato';
    }

    protected function getRedirectUrl(): string
    {
        return Contabilita::getUrl();
    }
}
