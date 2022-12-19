<?php

namespace App\Model\ShippingProvider;

enum ShippingProviderEnum: string
{
    case OMNIVA = 'omniva';
    case UPS = 'ups';
    case DHL = 'dhl';

    public static function list(): array
    {
        return
            [
                self::OMNIVA->value,
                self::UPS->value,
                self::DHL->value,
            ];
    }
}
