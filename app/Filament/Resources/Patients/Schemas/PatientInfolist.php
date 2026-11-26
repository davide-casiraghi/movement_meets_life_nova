<?php

namespace App\Filament\Resources\Patients\Schemas;

use App\Filament\Support\FormHelpers;
use App\Models\Patient;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

/** Patient page: the same sections as the form, read only. */
class PatientInfolist
{
    public static function configure(Schema $schema): Schema
    {
        $isCompany = fn (Patient $record): bool => $record->isCompany();

        return $schema
            ->columns(1)
            ->components([
                PatientForm::darkSection('Generali', 'Informazioni generali del paziente.', Heroicon::UserCircle)
                    ->columns(3)
                    ->schema([
                        TextEntry::make('person_type')->label('Tipologia persona'),
                        TextEntry::make('first_name')->label('Nome')->hidden($isCompany),
                        TextEntry::make('last_name')->label(fn (Patient $record) => $record->isCompany() ? 'Ragione sociale' : 'Cognome'),
                        TextEntry::make('nationality')->label('Nazionalità')->formatStateUsing(fn (?string $state) => FormHelpers::countryName($state)),
                        TextEntry::make('fiscal_code')->label('Codice fiscale')->placeholder('—')->copyable(),
                        TextEntry::make('sex')->label('Sesso')->placeholder('—')->hidden($isCompany),
                        TextEntry::make('birth_date')->label('Data nascita')->date('d-m-Y')->placeholder('—')->hidden($isCompany),
                        TextEntry::make('birth_city')->label('Comune nascita')->placeholder('—')->hidden($isCompany),
                        TextEntry::make('birth_province')->label('Provincia nascita')->placeholder('—')->hidden($isCompany),
                        TextEntry::make('vat_number')->label('Partita IVA')->placeholder('—'),
                        TextEntry::make('recipient_code')->label('Cod. Destinatario')->placeholder('—'),
                        TextEntry::make('notes')->label('Note')->placeholder('—')->columnSpanFull(),
                    ]),

                PatientForm::darkSection('Contatti', 'Contatti del paziente', Heroicon::Phone)
                    ->columns(4)
                    ->schema([
                        TextEntry::make('mobile')->label('Cellulare')->placeholder('—'),
                        TextEntry::make('phone')->label('Telefono')->placeholder('—'),
                        TextEntry::make('email')->label('Email')->placeholder('—'),
                        TextEntry::make('pec')->label('PEC')->placeholder('—'),
                    ]),

                PatientForm::darkSection('Domicilio', 'Domicilio del paziente', Heroicon::BuildingOffice2)
                    ->columns(4)
                    ->schema([
                        TextEntry::make('address')->label('Indirizzo')->placeholder('—'),
                        TextEntry::make('city')
                            ->label('Comune')
                            ->formatStateUsing(fn (Patient $record) => trim(collect([$record->postal_code, $record->city])->filter()->implode(' ').($record->province ? " ({$record->province})" : '')))
                            ->placeholder('—'),
                        TextEntry::make('address_country')->label('Nazione')->formatStateUsing(fn (?string $state) => FormHelpers::countryName($state)),
                    ]),

                PatientForm::darkSection('Dati sanitari', 'Dati sanitari del paziente', Heroicon::Identification)
                    ->columns(3)
                    ->schema([
                        TextEntry::make('id_card_number')->label('Numero Carta Identità')->placeholder('—'),
                        TextEntry::make('health_card_number')->label('N° Tessera sanitaria')->placeholder('—'),
                        TextEntry::make('ts_transmission')
                            ->label('Trasmissione Sistema TS')
                            ->badge()
                            ->formatStateUsing(fn (bool $state) => $state ? 'Sì' : 'No')
                            ->color(fn (bool $state) => $state ? 'success' : 'danger'),
                    ]),

                PatientForm::darkSection('Anamnesi e privacy', 'Anamnesi, note cliniche e informativa privacy', Heroicon::ClipboardDocumentList)
                    ->columns(2)
                    ->schema([
                        TextEntry::make('current_complaint')->label('Motivo della visita / anamnesi prossima')->placeholder('—'),
                        TextEntry::make('medical_history')->label('Anamnesi remota')->placeholder('—'),
                        TextEntry::make('medications')->label('Farmaci')->placeholder('—'),
                        TextEntry::make('allergies')->label('Allergie')->placeholder('—'),
                        TextEntry::make('clinical_notes')->label('Note cliniche')->placeholder('—'),
                        TextEntry::make('occupation')->label('Professione / attività')->placeholder('—'),
                        TextEntry::make('privacy_notice_signed_at')
                            ->label('Informativa privacy firmata il')
                            ->dateTime('d-m-Y H:i')
                            ->placeholder('Non ancora firmata'),
                    ]),

                PatientForm::darkSection('Rappresentanti legali', '', Heroicon::Users)
                    ->description(null)
                    ->schema([
                        RepeatableEntry::make('representatives')
                            ->hiddenLabel()
                            ->placeholder('Nessun rappresentante legale')
                            ->columns(4)
                            ->schema([
                                TextEntry::make('role')->label('In qualità di'),
                                TextEntry::make('full_name')->label('Nome'),
                                TextEntry::make('fiscal_code')->label('Codice fiscale / identificativo'),
                                TextEntry::make('birth_date')->label('Data di nascita')->date('d-m-Y')->placeholder('—'),
                                TextEntry::make('email')->label('Email')->placeholder('—'),
                                TextEntry::make('mobile')->label('Cellulare')->placeholder('—'),
                                TextEntry::make('address')
                                    ->label('Residenza')
                                    ->formatStateUsing(fn ($record) => collect([$record->address, trim($record->postal_code.' '.$record->city), $record->province])->filter()->implode(', '))
                                    ->placeholder('—'),
                                TextEntry::make('document_type')
                                    ->label('Documento')
                                    ->formatStateUsing(fn ($record) => collect([
                                        $record->document_type?->getLabel(),
                                        $record->document_number,
                                        $record->document_expires_at ? 'scade il '.$record->document_expires_at->format('d-m-Y') : null,
                                    ])->filter()->implode(' · '))
                                    ->placeholder('—'),
                            ]),
                    ]),
            ]);
    }
}
