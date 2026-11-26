<?php

namespace App\Filament\Resources\Patients\Schemas;

use App\Enums\PersonType;
use App\Enums\Sex;
use App\Filament\Support\FormHelpers;
use App\Models\PatientRepresentative;
use App\Support\CodiceFiscale;
use Closure;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\EmptyState;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

/**
 * Patient form ("Nuovo paziente" / edit), in dark collapsible sections:
 * Generali, Contatti, Domicilio, Dati sanitari, Anamnesi e privacy, Rappresentanti legali.
 */
class PatientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                self::general(),
                self::contacts(),
                self::home(),
                self::health(),
                self::clinical(),
                self::representatives(),
            ]);
    }

    /** Dark header band with icon, title and a short description. */
    public static function darkSection(string $heading, string $description, Heroicon $icon): Section
    {
        return Section::make($heading)
            ->description($description)
            ->icon($icon)
            ->collapsible()
            ->extraAttributes(['class' => 'gest-dark-section']);
    }

    private static function general(): Section
    {
        $isCompany = fn (Get $get): bool => self::isCompany($get);

        return self::darkSection('Generali', 'Informazioni generali del paziente.', Heroicon::UserCircle)
            ->schema([
                Grid::make(3)->schema([
                    Select::make('person_type')
                        ->label('Tipologia persona')
                        ->options(PersonType::class)
                        ->default(PersonType::Individual->value)
                        ->selectablePlaceholder(false)
                        ->required()
                        ->live(),
                    TextInput::make('first_name')
                        ->label('Nome')
                        ->placeholder('Es. Mario')
                        ->required()
                        ->maxLength(255)
                        ->hidden($isCompany),
                    TextInput::make('last_name')
                        ->label(fn (Get $get) => $isCompany($get) ? 'Ragione sociale' : 'Cognome')
                        ->placeholder(fn (Get $get) => $isCompany($get) ? 'Es. Polisportiva Rossi ASD' : 'Es. Rossi')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(fn (Get $get) => $isCompany($get) ? 2 : 1),
                    Select::make('nationality')
                        ->label('Nazionalità')
                        ->options(FormHelpers::countryOptions())
                        ->default('IT')
                        ->searchable()
                        ->required()
                        ->live(),
                    TextInput::make('fiscal_code')
                        ->label('Codice fiscale')
                        ->placeholder('Es. RSSMRA80A01H501U')
                        ->hintIcon(Heroicon::QuestionMarkCircle, tooltip: 'Per le persone fisiche il codice fiscale ha 16 caratteri. Per società ed enti ne ha 11 (come la partita IVA).')
                        ->required()
                        ->maxLength(16)
                        ->rule(fn (Get $get): Closure => function (string $attribute, mixed $value, Closure $fail) use ($get): void {
                            $code = CodiceFiscale::normalize($value) ?? '';

                            if (self::isCompany($get)) {
                                if (! CodiceFiscale::isValidCompany($code)) {
                                    $fail('Il codice fiscale di una società ha 11 cifre (o 16 caratteri).');
                                }
                            } elseif ($get('nationality') === 'IT' && ! CodiceFiscale::isValidIndividual($code)) {
                                $fail('Codice fiscale non valido: controlla i 16 caratteri.');
                            }
                        })
                        ->dehydrateStateUsing(fn (?string $state) => CodiceFiscale::normalize($state)),
                    Select::make('sex')
                        ->label('Sesso')
                        ->options(Sex::class)
                        ->placeholder('Seleziona')
                        ->required(fn (Get $get) => ! $isCompany($get))
                        ->hidden($isCompany),
                ]),

                Grid::make(3)
                    ->extraAttributes(['class' => 'gest-divided'])
                    ->schema([
                        DatePicker::make('birth_date')
                            ->label(FormHelpers::optional('Data nascita'))
                            ->native(false)
                            ->displayFormat('d-m-Y')
                            ->placeholder('GG-MM-AAAA')
                            ->maxDate(today())
                            ->hidden($isCompany),
                        TextInput::make('birth_city')
                            ->label(FormHelpers::optional('Comune nascita'))
                            ->placeholder('Es. Roma')
                            ->maxLength(255)
                            ->hidden($isCompany),
                        self::provinceInput('birth_province', 'Provincia nascita')
                            ->hidden($isCompany),
                        TextInput::make('vat_number')
                            ->label(FormHelpers::optional('Partita IVA'))
                            ->prefix(fn (Get $get) => $get('nationality') ?: 'IT')
                            ->placeholder('Es. 12345678901')
                            ->maxLength(20)
                            ->rule(fn (Get $get): Closure => function (string $attribute, mixed $value, Closure $fail) use ($get): void {
                                $pattern = $get('nationality') === 'IT' ? '/^\d{11}$/' : '/^[A-Za-z0-9]{2,20}$/';

                                if (filled($value) && ! preg_match($pattern, preg_replace('/\s+/', '', $value))) {
                                    $fail($get('nationality') === 'IT' ? 'La partita IVA italiana ha 11 cifre.' : 'Partita IVA non valida.');
                                }
                            })
                            ->dehydrateStateUsing(fn (?string $state) => filled($state) ? strtoupper(preg_replace('/\s+/', '', $state)) : null),
                        TextInput::make('recipient_code')
                            ->label(FormHelpers::optional('Cod. Destinatario'))
                            ->placeholder('Es. 0000000')
                            ->hintIcon(Heroicon::QuestionMarkCircle, tooltip: 'Codice SDI per la fattura elettronica: 7 caratteri per le persone fisiche, 6 o 7 per società ed enti. Se il cliente non ne ha uno, usa 0000000.')
                            ->regex('/^[A-Za-z0-9]{6,7}$/')
                            ->validationMessages(['regex' => 'Il codice destinatario ha 6 o 7 caratteri.'])
                            ->dehydrateStateUsing(fn (?string $state) => filled($state) ? strtoupper($state) : null),
                    ]),

                Textarea::make('notes')
                    ->label(FormHelpers::optional('Note'))
                    ->placeholder('Inserisci informazioni aggiuntive...')
                    ->rows(4),
            ]);
    }

    /** The select state is a PersonType once cast, a string while being typed. */
    private static function isCompany(Get $get): bool
    {
        $type = $get('person_type');

        return ($type instanceof PersonType ? $type : PersonType::tryFrom((string) $type)) === PersonType::Company;
    }

    private static function contacts(): Section
    {
        return self::darkSection('Contatti', 'Contatti del paziente', Heroicon::Phone)
            ->columns(4)
            ->schema([
                TextInput::make('mobile')->label(FormHelpers::optional('Cellulare'))->placeholder('(+39) 330 1234411')->tel()->maxLength(50),
                TextInput::make('phone')->label(FormHelpers::optional('Telefono'))->placeholder('(+39) 051 7575750')->tel()->maxLength(50),
                TextInput::make('email')->label(FormHelpers::optional('Email'))->placeholder('esempio@mail.com')->email()->maxLength(255),
                TextInput::make('pec')->label(FormHelpers::optional('PEC'))->placeholder('esempio@pec.it')->email()->maxLength(255),
            ]);
    }

    private static function home(): Section
    {
        $isItaly = fn (Get $get): bool => $get('address_country') === 'IT';

        return self::darkSection('Domicilio', 'Domicilio del paziente', Heroicon::BuildingOffice2)
            ->columns(8)
            ->schema([
                Select::make('address_country')
                    ->label('Nazione')
                    ->options(FormHelpers::countryOptions())
                    ->default('IT')
                    ->searchable()
                    ->required()
                    ->live()
                    ->columnSpan(2),
                TextInput::make('address')->label('Indirizzo')->placeholder('Es. Via Roma 10')->required()->maxLength(255)->columnSpan(2),
                TextInput::make('city')->label('Comune')->placeholder('Es. Roma')->required()->maxLength(255)->columnSpan(2),
                self::provinceInput('province', 'Provincia')
                    ->label('Provincia')
                    ->required($isItaly),
                TextInput::make('postal_code')
                    ->label('CAP')
                    ->placeholder('Es. 00100')
                    ->required($isItaly)
                    ->maxLength(10)
                    ->rule(fn (Get $get): Closure => function (string $attribute, mixed $value, Closure $fail) use ($get): void {
                        if ($get('address_country') === 'IT' && filled($value) && ! preg_match('/^\d{5}$/', $value)) {
                            $fail('Il CAP ha 5 cifre.');
                        }
                    }),
            ]);
    }

    private static function health(): Section
    {
        return self::darkSection('Dati sanitari', 'Inserire i dati sanitari del paziente', Heroicon::Identification)
            ->columns(3)
            ->schema([
                TextInput::make('id_card_number')
                    ->label(FormHelpers::optional('Numero Carta Identità'))
                    ->placeholder('Es. CA1234567')
                    ->maxLength(30)
                    ->dehydrateStateUsing(fn (?string $state) => filled($state) ? strtoupper(trim($state)) : null),
                TextInput::make('health_card_number')
                    ->label(FormHelpers::optional('N° Tessera sanitaria'))
                    ->placeholder('Es. 80380000000000000000')
                    ->regex('/^\d{20}$/')
                    ->validationMessages(['regex' => 'Il numero della tessera sanitaria ha 20 cifre.']),
                Radio::make('ts_transmission')
                    ->label('Trasmissione Sistema TS')
                    ->hintIcon(Heroicon::QuestionMarkCircle, tooltip: "Sì: le spese del paziente vengono inviate al Sistema Tessera Sanitaria per la dichiarazione precompilata. No: il paziente si è opposto all'invio.")
                    ->boolean('Sì', 'No')
                    ->default(true)
                    ->inline()
                    ->required(),
            ]);
    }

    /** Clinical history from the first version of the panel: kept, but folded away. */
    private static function clinical(): Section
    {
        return self::darkSection('Anamnesi e privacy', 'Anamnesi, note cliniche e informativa privacy', Heroicon::ClipboardDocumentList)
            ->collapsed(fn (string $operation, Get $get) => $operation === 'create' || blank($get('current_complaint').$get('medical_history').$get('clinical_notes')))
            ->columns(2)
            ->schema([
                Textarea::make('current_complaint')->label(FormHelpers::optional('Motivo della visita / anamnesi prossima'))->rows(4),
                Textarea::make('medical_history')->label(FormHelpers::optional('Anamnesi remota (patologie, interventi, traumi)'))->rows(4),
                Textarea::make('medications')->label(FormHelpers::optional('Farmaci'))->rows(2),
                Textarea::make('allergies')->label(FormHelpers::optional('Allergie'))->rows(2),
                Textarea::make('clinical_notes')->label(FormHelpers::optional('Note cliniche'))->rows(4),
                TextInput::make('occupation')->label(FormHelpers::optional('Professione / attività'))->maxLength(255),
                DateTimePicker::make('privacy_notice_signed_at')
                    ->label(FormHelpers::optional('Informativa privacy firmata il'))
                    ->native(false)
                    ->displayFormat('d-m-Y H:i')
                    ->seconds(false),
            ]);
    }

    private static function representatives(): Section
    {
        $isEmpty = fn (Get $get): bool => blank($get('representatives'));

        return self::darkSection('Rappresentanti legali', '', Heroicon::Users)
            ->key('representatives-section')
            ->description(null)
            ->afterHeader([
                self::addRepresentativeAction('addRepresentative')
                    ->label('Aggiungi')
                    ->icon(Heroicon::Plus)
                    ->link()
                    ->extraAttributes(['class' => 'gest-section-header-link']),
            ])
            ->schema([
                Text::make('I rappresentanti verranno salvati insieme al paziente.')
                    ->color('gray'),

                EmptyState::make('Nessun rappresentante legale')
                    ->description('Aggiungi chi rappresenta il paziente per gestire le richieste di firma.')
                    ->icon(Heroicon::Users)
                    ->footer([
                        self::addRepresentativeAction('addFirstRepresentative')
                            ->label('Aggiungi rappresentante')
                            ->icon(Heroicon::Plus),
                    ])
                    ->contained(false)
                    ->visible($isEmpty),

                Repeater::make('representatives')
                    ->hiddenLabel()
                    ->relationship()
                    ->schema([
                        ...array_map(fn (string $field) => Hidden::make($field), RepresentativeForm::FIELDS),
                        Text::make(fn (Get $get) => RepresentativeForm::summary($get)),
                    ])
                    ->mutateRelationshipDataBeforeFillUsing(function (array $data): array {
                        // attributesToArray() leaves out the encrypted fields: read them from the model.
                        $representative = PatientRepresentative::find($data['id'] ?? null);

                        return $representative ? RepresentativeForm::stateFromRecord($representative) : $data;
                    })
                    ->itemLabel(fn (array $state) => RepresentativeForm::label($state))
                    ->defaultItems(0)
                    // Re-render the whole form after removing an item, so the empty state comes back.
                    ->partiallyRenderAfterActionsCalled(false)
                    ->addable(false)
                    ->reorderable(false)
                    ->deleteAction(fn (Action $action) => $action
                        ->requiresConfirmation()
                        ->modalHeading('Rimuovere il rappresentante?')
                        ->modalDescription('Verrà rimosso quando salvi il paziente.')
                        ->modalSubmitActionLabel('Rimuovi'))
                    ->extraItemActions([
                        RepresentativeForm::configureModal(Action::make('editRepresentative'))
                            ->label('Modifica')
                            ->icon(Heroicon::PencilSquare)
                            ->iconButton()
                            ->color('gray')
                            ->modalHeading('Modifica rappresentante')
                            ->modalSubmitActionLabel('Salva')
                            ->fillForm(fn (array $arguments, Repeater $component) => $component->getRawItemState($arguments['item']))
                            ->action(function (array $data, array $arguments, Repeater $component): void {
                                $items = $component->getRawState();
                                $items[$arguments['item']] = [...$items[$arguments['item']], ...RepresentativeForm::normalize($data)];
                                $component->rawState($items);
                            }),
                    ])
                    // Not hidden when empty: a hidden repeater would not save the removal of the last item.
                    ->extraAttributes(['class' => 'gest-representatives']),
            ]);
    }

    private static function addRepresentativeAction(string $name): Action
    {
        return RepresentativeForm::configureModal(Action::make($name))
            ->modalHeading('Aggiungi rappresentante')
            ->modalSubmitActionLabel('Aggiungi')
            ->action(function (array $data, Get $get, Set $set): void {
                $items = $get('representatives') ?? [];
                $items[(string) Str::uuid()] = RepresentativeForm::normalize($data);
                $set('representatives', $items);
            });
    }

    /** Two-letter province code, e.g. "RM". */
    public static function provinceInput(string $name, string $label): TextInput
    {
        return TextInput::make($name)
            ->label(FormHelpers::optional($label))
            ->placeholder('Es. RM')
            ->maxLength(2)
            ->regex('/^[A-Za-z]{2}$/')
            ->validationMessages(['regex' => 'Usa la sigla di 2 lettere, es. RM.'])
            ->dehydrateStateUsing(fn (?string $state) => filled($state) ? strtoupper($state) : null);
    }
}
