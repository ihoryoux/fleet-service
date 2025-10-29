<?php

namespace App\Enum;

enum FleetSetStatus: string
{
    case WORKS = 'Works';
    case FREE = 'Free';
    case DOWNTIME = 'Downtime';
}
