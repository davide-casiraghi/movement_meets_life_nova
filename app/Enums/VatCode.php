<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

/**
 * VAT rates and, for 0% operations, the "Natura" codes of the Italian e-invoice (FatturaPA).
 * Physiotherapy services are usually N4 (exempt, art. 10 n. 18 DPR 633/72),
 * or N2.2 for practitioners in the flat-rate scheme (regime forfettario).
 */
enum VatCode: string implements HasLabel
{
    case Vat22 = '22';
    case Vat10 = '10';
    case Vat5 = '5';
    case Vat4 = '4';
    case N1 = 'N1';
    case N2_1 = 'N2.1';
    case N2_2 = 'N2.2';
    case N3_1 = 'N3.1';
    case N3_2 = 'N3.2';
    case N3_3 = 'N3.3';
    case N3_4 = 'N3.4';
    case N3_5 = 'N3.5';
    case N3_6 = 'N3.6';
    case N4 = 'N4';
    case N5 = 'N5';
    case N6_1 = 'N6.1';
    case N6_2 = 'N6.2';
    case N6_3 = 'N6.3';
    case N6_4 = 'N6.4';
    case N6_5 = 'N6.5';
    case N6_6 = 'N6.6';
    case N6_7 = 'N6.7';
    case N6_8 = 'N6.8';
    case N6_9 = 'N6.9';
    case N7 = 'N7';

    /** VAT rate in percent. */
    public function rate(): int
    {
        return is_numeric($this->value) ? (int) $this->value : 0;
    }

    /** FatturaPA "Natura" code, null for taxable operations. */
    public function nature(): ?string
    {
        return is_numeric($this->value) ? null : $this->value;
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::Vat22, self::Vat10, self::Vat5, self::Vat4 => $this->value.'%',
            default => "0% - {$this->value} - ".$this->natureDescription(),
        };
    }

    private function natureDescription(): string
    {
        return match ($this) {
            self::N1 => 'Escluse ex art. 15',
            self::N2_1 => 'Non soggette ad IVA ai sensi degli artt. da 7 a 7-septies',
            self::N2_2 => 'Non soggette - altri casi (es. regime forfettario)',
            self::N3_1 => 'Non imponibili - esportazioni',
            self::N3_2 => 'Non imponibili - cessioni intracomunitarie',
            self::N3_3 => 'Non imponibili - cessioni verso San Marino',
            self::N3_4 => 'Non imponibili - operazioni assimilate alle cessioni all\'esportazione',
            self::N3_5 => 'Non imponibili - a seguito di dichiarazioni d\'intento',
            self::N3_6 => 'Non imponibili - altre operazioni che non concorrono alla formazione del plafond',
            self::N4 => 'Esenti (es. prestazioni sanitarie, art. 10 n. 18)',
            self::N5 => 'Regime del margine / IVA non esposta in fattura',
            self::N6_1 => 'Inversione contabile - cessione di rottami e altri materiali di recupero',
            self::N6_2 => 'Inversione contabile - cessione di oro e argento ai sensi della legge 7/2000',
            self::N6_3 => 'Inversione contabile - subappalto nel settore edile',
            self::N6_4 => 'Inversione contabile - cessione di fabbricati',
            self::N6_5 => 'Inversione contabile - cessione di telefoni cellulari',
            self::N6_6 => 'Inversione contabile - cessione di prodotti elettronici',
            self::N6_7 => 'Inversione contabile - prestazioni comparto edile e settori connessi',
            self::N6_8 => 'Inversione contabile - operazioni settore energetico',
            self::N6_9 => 'Inversione contabile - altri casi',
            self::N7 => 'IVA assolta in altro stato UE',
            default => '',
        };
    }
}
