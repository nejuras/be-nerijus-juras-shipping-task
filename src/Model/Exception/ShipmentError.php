<?php

declare(strict_types=1);

namespace App\Model\Exception;

class ShipmentError
{
    public const STATUS_CHANGE_MESSAGE = 'Shipment is not registered!';

    public static function createError(
        string $message
    )
    {
        return [
            "message" => self::STATUS_CHANGE_MESSAGE,
            "content" => $message,
        ];
    }

    public static function register($message)
    {
        return self::createError($message);
    }
}