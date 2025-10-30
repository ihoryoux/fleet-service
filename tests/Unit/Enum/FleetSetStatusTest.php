<?php

namespace App\Tests\Unit\Enum;

use App\Enum\FleetSetStatus;
use PHPUnit\Framework\TestCase;

class FleetSetStatusTest extends TestCase
{
    public function testEnumCases(): void
    {
        $this->assertSame('Works', FleetSetStatus::WORKS->value);
        $this->assertSame('Free', FleetSetStatus::FREE->value);
        $this->assertSame('Downtime', FleetSetStatus::DOWNTIME->value);
    }
}
