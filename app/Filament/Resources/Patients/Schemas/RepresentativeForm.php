<?php

namespace App\Filament\Resources\Patients\Schemas;

use App\Enums\IdentityDocumentType;
use App\Enums\RepresentativeRole;
use App\Filament\Support\FormHelpers;
use App\Models\PatientRepresentative;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Support\Enums\Width;
use Illuminate\Support\HtmlString;

/**
 * "Aggiungi rappresentante" modal: a legal representative (parent, guardian, ...)
 * kept in the patient form until the patient is saved.
 */
class RepresentativeForm
{
    /** Fields of a representative, as stored in each item of the "representatives" repeater. */
    public const FIELDS = [
        'role', 'first_name', 'last_name', 'fiscal_code', 'birth_date', 'email', 'mobile',
        'country', 'address', 'city', 'province', 'postal_code',
        'document_type', 'document_number', 'document_issued_by', 'document_issued_at', 'document_expires_at',
    ];

    private const DATE_FIELDS = ['birth_date', 'document_issued_at', 'document_expires_at'];

    public static function schema(): array
    {
        return [
            Section::make('Dati generali')
                ->columns(6)
                ->schema([
                    Select::make('role')
                        ->label('In qualità di')
                        ->options(RepresentativeRole::class)
                        ->default(RepresentativeRole::Parent->value)
                        ->selectablePlaceholder(false)
                        ->required()
                        ->columnSpan(2),
                    TextInput::make('first_name')->label('Nome')->placeholder('Es. Mario')->required()->maxLength(255)->columnSpan(2),
                    TextInput::make('last_name')->label('Cognome')->placeholder('Es. Rossi')->required()->maxLength(255)->columnSpan(2),
                    TextInput::make('fiscal_code')
                        ->label('Codice fiscale / identificativo estero')
                        ->placeholder('Inserisci il codice fiscale')
                        ->required()
                        ->maxLength(30)
                        ->regex('/^[A-Za-z0-9 -]+$/')
                        ->validationMessages(['regex' => 'Usa solo lettere, numeri, spazi e trattini.'])
                        ->dehydrateStateUsing(fn (?string $state) => $state ? strtoupper(trim($state)) : null)
                        ->columnSpan(3),
                    self::date('birth_date', 'Data di nascita')->maxDate(today())->columnSpan(3),
                    TextInput::make('email')->label(FormHelpers::optional('Email'))->placeholder('Es. nome@esempio.it')->email()->maxLength(255)->columnSpan(3),
                    TextInput::make('mobile')->label(FormHelpers::optional('Cellulare'))->placeholder('Es. +39 333 1234567')->tel()->maxLength(50)->columnSpan(3),
                ]),

            Section::make(self::heading('Residenza', 'facoltativa'))
                ->columns(2)
                ->schema([
                    Select::make('country')
                        ->label(FormHelpers::optional('Nazione'))
                        ->options(FormHelpers::countryOptions())
                        ->default('IT')
                        ->searchable(),
                    TextInput::make('address')->label(FormHelpers::optional('Indirizzo'))->placeholder('Es. Via Roma 10')->maxLength(255),
                    TextInput::make('city')->label(FormHelpers::optional('Comune'))->placeholder('Es. Roma')->maxLength(255),
                    PatientForm::provinceInput('province', 'Provincia')->label(FormHelpers::optional('Provincia')),
                    TextInput::make('postal_code')->label(FormHelpers::optional('CAP'))->placeholder('Es. 00100')->maxLength(10),
                ]),

            Section::make(self::heading("Documento d'identità", 'facoltativo'))
                ->columns(2)
                ->schema([
                    Select::make('document_type')
                        ->label(FormHelpers::optional('Tipo di documento'))
                        ->options(IdentityDocumentType::class)
                        ->placeholder('Non specificato'),
                    TextInput::make('document_number')->label(FormHelpers::optional('Numero'))->placeholder('Es. CA12345AB')->maxLength(50),
                    TextInput::make('document_issued_by')->label(FormHelpers::optional('Rilasciato da'))->placeholder('Es. Comune di Roma')->maxLength(255),
                    self::date('document_issued_at', 'Data di rilascio')->maxDate(today()),
                    self::date('document_expires_at', 'Data di scadenza')->afterOrEqual('document_issued_at'),
                ]),
        ];
    }

    /** Settings shared by the "add" and "edit" modals. */
    public static function configureModal(Action $action): Action
    {
        return $action
            ->schema(self::schema())
            ->modalWidth(Width::ThreeExtraLarge)
            ->modalCancelActionLabel('Annulla')
            ->extraModalWindowAttributes(['class' => 'gest-dark-modal']);
    }

    /** Item of the repeater for a saved representative (the encrypted fields included). */
    public static function stateFromRecord(PatientRepresentative $representative): array
    {
        $state = [];

        foreach (self::FIELDS as $field) {
            $value = $representative->{$field};

            $state[$field] = match (true) {
                $value instanceof \BackedEnum => $value->value,
                in_array($field, self::DATE_FIELDS, true) => $value?->format('Y-m-d'),
                default => $value,
            };
        }

        return $state;
    }

    /**
     * Modal data ready to be kept in the repeater: enum selects give enum objects,
     * which cannot live in the Livewire state.
     */
    public static function normalize(array $data): array
    {
        return array_map(fn (mixed $value) => $value instanceof \BackedEnum ? $value->value : $value, $data);
    }

    /** "Genitore · Mario Rossi" */
    public static function label(array $state): string
    {
        $role = $state['role'] ?? null;
        $role = ($role instanceof RepresentativeRole ? $role : RepresentativeRole::tryFrom((string) $role))?->getLabel();
        $name = trim(($state['first_name'] ?? '').' '.($state['last_name'] ?? ''));

        return collect([$role, $name])->filter()->implode(' · ');
    }

    /** Line under the name: fiscal code and contacts. */
    public static function summary(Get $get): HtmlString
    {
        $parts = collect([
            $get('fiscal_code') ? 'CF '.$get('fiscal_code') : null,
            $get('mobile'),
            $get('email'),
        ])->filter()->map(fn (string $part) => e($part));

        return new HtmlString('<span class="gest-representative-summary">'.$parts->implode(' · ').'</span>');
    }

    private static function date(string $name, string $label): DatePicker
    {
        return DatePicker::make($name)
            ->label(FormHelpers::optional($label))
            ->native(false)
            ->displayFormat('d-m-Y')
            ->placeholder('GG-MM-AAAA');
    }

    private static function heading(string $text, string $note): HtmlString
    {
        return new HtmlString(e($text).' <span class="gest-optional">('.e($note).')</span>');
    }
}
