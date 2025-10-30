<?php

namespace App\Tests\Unit\Enum;

use App\Enum\ServiceOrderStatus;
use PHPUnit\Framework\TestCase;

class ServiceOrderStatusTest extends TestCase
{
    public function testEnumCases(): void
    {
        $this->assertSame('in_service', ServiceOrderStatus::IN_SERVICE->value);
        $this->assertSame('completed', ServiceOrderStatus::COMPLETED->value);
        $this->assertSame('pending', ServiceOrderStatus::PENDING->value);
        $this->assertSame('cancelled', ServiceOrderStatus::CANCELLED->value);
    }
}
