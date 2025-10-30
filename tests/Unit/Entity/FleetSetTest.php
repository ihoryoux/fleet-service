<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Driver;
use App\Entity\FleetSet;
use App\Entity\Truck;
use App\Entity\Trailer;
use App\Enum\FleetSetStatus;
use LogicException;
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

    public function testAddAndRemoveDrivers(): void
    {
        $fleetSet = new FleetSet();

        $driver1 = new Driver();
        $driver2 = new Driver();

        $fleetSet->addDriver($driver1);
        $fleetSet->addDriver($driver2);

        $this->assertCount(2, $fleetSet->getDrivers());
        $this->assertTrue($fleetSet->getDrivers()->contains($driver1));
        $this->assertTrue($fleetSet->getDrivers()->contains($driver2));

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('A Fleet Set can have maximum 2 Drivers.');
        $fleetSet->addDriver(new Driver());
    }

    public function testRemoveDriver(): void
    {
        $fleetSet = new FleetSet();
        $driver = new Driver();

        $fleetSet->addDriver($driver);
        $this->assertCount(1, $fleetSet->getDrivers());

        $fleetSet->removeDriver($driver);
        $this->assertCount(0, $fleetSet->getDrivers());
    }

    public function testGetStatus(): void
    {
        $fleetSet = new FleetSet();
        $truck = (new Truck())->setIsActive(true);
        $trailer = (new Trailer())->setIsActive(true);

        $fleetSet->setTruck($truck);
        $fleetSet->setTrailer($trailer);

        // No drivers = Free
        $this->assertEquals(FleetSetStatus::FREE, $fleetSet->getStatus());

        // Add driver = Works
        $fleetSet->addDriver(new Driver());
        $this->assertEquals(FleetSetStatus::WORKS, $fleetSet->getStatus());

        // Inactive truck = Downtime
        $truck->setIsActive(false);
        $this->assertEquals(FleetSetStatus::DOWNTIME, $fleetSet->getStatus());

        // Restore truck, disable trailer = Downtime
        $truck->setIsActive(true);
        $trailer->setIsActive(false);
        $this->assertEquals(FleetSetStatus::DOWNTIME, $fleetSet->getStatus());
    }
}
