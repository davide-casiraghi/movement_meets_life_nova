<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

/** "CausalePagamento" of the withholding tax (codes of the 770 / Certificazione Unica). */
enum WithholdingReason: string implements HasLabel
{
    case A = 'A';
    case B = 'B';
    case C = 'C';
    case D = 'D';
    case E = 'E';
    case G = 'G';
    case H = 'H';
    case I = 'I';
    case L = 'L';
    case M = 'M';
    case N = 'N';
    case O = 'O';
    case P = 'P';
    case Q = 'Q';
    case R = 'R';
    case S = 'S';
    case T = 'T';
    case U = 'U';
    case V = 'V';
    case W = 'W';
    case X = 'X';
    case Y = 'Y';
    case Z = 'Z';

    public function getLabel(): string
    {
        return $this->value.' - '.match ($this) {
            self::A => "Prestazioni di lavoro autonomo rientranti nell'esercizio di arte o professione abituale.",
            self::B => "Utilizzazione economica, da parte dell'autore o dell'inventore, di opere dell'ingegno, di brevetti industriali e di processi, formule o informazioni relativi ad esperienze acquisite in campo industriale, commerciale o scientifico.",
            self::C => "Utili derivanti da contratti di associazione in partecipazione e da contratti di cointeressenza, quando l'apporto è costituito esclusivamente dalla prestazione di lavoro.",
            self::D => 'Utili spettanti ai soci promotori e ai soci fondatori delle società di capitali.',
            self::E => 'Levata di protesti cambiari da parte dei segretari comunali.',
            self::G => 'Indennità corrisposte per la cessazione di attività sportiva professionale.',
            self::H => "Indennità corrisposte per la cessazione dei rapporti di agenzia delle persone fisiche e delle società di persone, con esclusione delle somme maturate entro il 31 dicembre 2003, già imputate per competenza e tassate come reddito d'impresa.",
            self::I => 'Indennità corrisposte per la cessazione da funzioni notarili.',
            self::L => "Utilizzazione economica, da parte di soggetto diverso dall'autore o dall'inventore, di opere dell'ingegno, di brevetti industriali e di processi, formule e informazioni relativi ad esperienze acquisite in campo industriale, commerciale o scientifico.",
            self::M => 'Prestazioni di lavoro autonomo non esercitate abitualmente, obblighi di fare, di non fare o permettere.',
            self::N => "Indennità di trasferta, rimborso forfetario di spese, premi e compensi erogati: .. nell'esercizio diretto di attività sportive dilettantistiche",
            self::O => "Prestazioni di lavoro autonomo non esercitate abitualmente, obblighi di fare, di non fare o permettere, per le quali non sussiste l'obbligo di iscrizione alla gestione separata (Circ. INPS n. 104/2001).",
            self::P => "Compensi corrisposti a soggetti non residenti privi di stabile organizzazione per l'uso o la concessione in uso di attrezzature industriali, commerciali o scientifiche che si trovano nel territorio dello Stato.",
            self::Q => 'Provvigioni corrisposte ad agente o rappresentante di commercio monomandatario.',
            self::R => 'Provvigioni corrisposte ad agente o rappresentante di commercio plurimandatario.',
            self::S => 'Provvigioni corrisposte a commissionario.',
            self::T => 'Provvigioni corrisposte a mediatore.',
            self::U => 'Provvigioni corrisposte a procacciatore di affari.',
            self::V => 'Provvigioni corrisposte a incaricato per le vendite a domicilio e provvigioni corrisposte a incaricato per la vendita porta a porta e per la vendita ambulante di giornali quotidiani e periodici (L. 25 febbraio 1987, n. 67).',
            self::W => "Corrispettivi erogati nel 2013 per prestazioni relative a contratti d'appalto cui si sono resi applicabili le disposizioni contenute nell'art. 25-ter D.P.R. 600/1973.",
            self::X => "Canoni corrisposti nel 2004 da società o enti residenti, ovvero da stabili organizzazioni di società estere di cui all'art. 26-quater, c. 1, lett. a) e b) D.P.R. 600/1973.",
            self::Y => 'Canoni corrisposti dal 1.01.2005 al 26.07.2005 da soggetti di cui al punto precedente.',
            self::Z => 'Titolo diverso dai precedenti.',
        };
    }
}
