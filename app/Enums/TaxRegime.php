<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

/** "RegimeFiscale" codes of the Italian e-invoice (FatturaPA). */
enum TaxRegime: string implements HasLabel
{
    case Ordinary = 'RF01';
    case Minimum = 'RF02';
    case Agriculture = 'RF04';
    case SaltAndTobacco = 'RF05';
    case Matches = 'RF06';
    case Publishing = 'RF07';
    case PublicTelephony = 'RF08';
    case TransportDocuments = 'RF09';
    case Entertainment = 'RF10';
    case TravelAgencies = 'RF11';
    case FarmHolidays = 'RF12';
    case DoorToDoorSales = 'RF13';
    case UsedGoods = 'RF14';
    case ArtAuctions = 'RF15';
    case CashVatPublicAdministration = 'RF16';
    case CashVat = 'RF17';
    case Other = 'RF18';
    case FlatRate = 'RF19';

    public function getLabel(): string
    {
        return match ($this) {
            self::Ordinary => 'Regime ordinario',
            self::Minimum => 'Regime dei contribuenti minimi (art. 1, c.96-117, L. 244/2007)',
            self::Agriculture => 'Agricoltura e attività connesse e pesca (artt. 34 e 34-bis, D.P.R. 633/1972)',
            self::SaltAndTobacco => 'Vendita sali e tabacchi (art. 74, c.1, D.P.R. 633/1972)',
            self::Matches => 'Commercio dei fiammiferi (art. 74, c.1, D.P.R. 633/1972)',
            self::Publishing => 'Editoria (art. 74, c.1, D.P.R. 633/1972)',
            self::PublicTelephony => 'Gestione di servizi di telefonia pubblica (art. 74, c.1, D.P.R. 633/1972)',
            self::TransportDocuments => 'Rivendita di documenti di trasporto pubblico e di sosta (art. 74, c.1, D.P.R. 633/1972)',
            self::Entertainment => 'Intrattenimenti, giochi e altre attività di cui alla tariffa allegata al D.P.R. 640/72 (art. 74, c.6, D.P.R. 633/1972)',
            self::TravelAgencies => 'Agenzie di viaggi e turismo (art. 74-ter, D.P.R. 633/1972)',
            self::FarmHolidays => 'Agriturismo (art. 5, c.2, L. 413/1991)',
            self::DoorToDoorSales => 'Vendite a domicilio (art. 25-bis, c.6, D.P.R. 600/1973)',
            self::UsedGoods => "Rivendita di beni usati, di oggetti d'arte, d'antiquariato o da collezione (art. 36, D.L. 41/1995)",
            self::ArtAuctions => "Agenzie di vendite all'asta di oggetti d'arte, antiquariato o da collezione (art. 40-bis, D.L. 41/1995)",
            self::CashVatPublicAdministration => 'IVA per cassa P.A. (art. 6, c.5, D.P.R. 633/1972)',
            self::CashVat => 'IVA per cassa (art. 32-bis, D.L. 83/2012)',
            self::Other => 'Altro',
            self::FlatRate => 'Regime forfettario',
        };
    }
}
