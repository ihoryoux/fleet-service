<?php

namespace App\Tests\Unit\Entity;

use App\Entity\FleetSet;
use App\Entity\Truck;
use App\Entity\Trailer;
use PHPUnit\Framework\TestCase;

class FleetSetTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $fleetSet = new FleetSet();
        $truck = new Truck();
        $trailer = new Trailer();

        $fleetSet->setTruck($truck);
        $fleetSet->setTrailer($trailer);

        $this->assertSame($truck, $fleetSet->getTruck());
        $this->assertSame($trailer, $fleetSet->getTrailer());
    }
}
