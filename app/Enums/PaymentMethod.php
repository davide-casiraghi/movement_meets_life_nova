<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PaymentMethod: string implements HasLabel
{
    case Cash = 'cash';
    case CreditCard = 'credit_card';
    case DebitCard = 'debit_card';
    case BankTransfer = 'bank_transfer';
    case Cheque = 'cheque';
    case PayPal = 'paypal';
    case Satispay = 'satispay';
    case Other = 'other';

    public function getLabel(): string
    {
        return match ($this) {
            self::Cash => 'Contanti',
            self::CreditCard => 'Carta di credito',
            self::DebitCard => 'Carta di debito',
            self::BankTransfer => 'Bonifico bancario',
            self::Cheque => 'Assegno',
            self::PayPal => 'PayPal',
            self::Satispay => 'Satispay',
            self::Other => 'Altro',
        };
    }
}
