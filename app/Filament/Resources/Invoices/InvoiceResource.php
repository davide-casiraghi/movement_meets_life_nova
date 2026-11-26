<?php

namespace App\Filament\Resources\Invoices;

use App\Filament\Resources\Invoices\Pages\CreateInvoice;
use App\Filament\Resources\Invoices\Schemas\InvoiceForm;
use App\Models\Invoice;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;

/**
 * Invoices. Reached from the "Contabilità" page (App\Filament\Pages\Contabilita),
 * so it has no menu entry of its own. For now only "Nuova fattura" exists.
 */
class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $slug = 'contabilita/documenti';

    protected static ?string $modelLabel = 'documento contabile';

    protected static ?string $pluralModelLabel = 'documenti contabili';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Schema $schema): Schema
    {
        return InvoiceForm::configure($schema);
    }

    public static function getPages(): array
    {
        return [
            'create' => CreateInvoice::route('/create'),
        ];
    }
}
