<?php

namespace App\Enum;

enum ServiceOrderStatus: string
{
    case IN_SERVICE = 'in_service';
    case COMPLETED = 'completed';
    case PENDING = 'pending';
    case CANCELLED = 'cancelled';
}
