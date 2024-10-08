<?php

namespace App\Enums;

enum AuctionStatus: string
{
    case ACTIVE = 'active';
    case ENDED = 'ended';
    case FROZEN = 'frozen';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function isStatus(string $status, AuctionStatus $auctionStatus): bool
    {
        return $status === $auctionStatus->value;
    }

    public static function validStatus(AuctionStatus $status): bool
    {
        return match ($status) {
            self::ACTIVE => true,
            self::ENDED => true,
            self::FROZEN => true,
            default => false,
        };
    }
}