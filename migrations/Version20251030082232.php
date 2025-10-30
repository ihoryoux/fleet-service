<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251030082232 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Trucks
        $this->addSql("INSERT INTO truck (id, license_plate, is_active) VALUES
            (1, 'Truck-111', true),
            (2, 'Truck-222', false),
            (3, 'Truck-333', true),
            (4, 'Truck-444', true)");

        // Trailers
        $this->addSql("INSERT INTO trailer (id, license_plate, is_active) VALUES
            (1, 'Trailer-111', true),
            (2, 'Trailer-222', true),
            (3, 'Trailer-333', false),
            (4, 'Trailer-444', true)");

        // Fleet Sets
        $this->addSql("INSERT INTO fleet_set (id, truck_id, trailer_id) VALUES
            (1, 1, 1),  -- WORKS (2 drivers, both truck and trailer active)
            (2, 2, 2),  -- DOWNTIME (truck inactive)
            (3, 3, 3),  -- DOWNTIME (trailer inactive)
            (4, 4, 4);  -- FREE (no drivers, both active)
        ");

        // Drivers
        $this->addSql("INSERT INTO driver (id, name, email) VALUES
            (1, 'Ihor Az1', 'driver1@example.com'),
            (2, 'Ihor Az2', 'driver2@example.com'),
            (3, 'Ihor Az3', 'driver3@example.com')");

        // Assign drivers to fleet sets
        $this->addSql("INSERT INTO fleet_set_driver (fleet_set_id, driver_id) VALUES
            (1, 1), -- WORKS
            (1, 2),
            (2, 3)  -- DOWNTIME
        ");

        // Service Orders
        $this->addSql("INSERT INTO service_order (id, title, status, truck_id, trailer_id, fleet_set_id) VALUES
            (1, 'Replace tires', 'in_service', 1, 1, 1),
            (2, 'Engine repair', 'pending', 2, null, null),
            (3, 'Brake inspection', 'completed', null, 3, null),
            (4, 'Full service', 'cancelled', null, null, 1)
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM service_order WHERE id IN (1, 2, 3, 4)");
        $this->addSql("DELETE FROM fleet_set_driver WHERE fleet_set_id IN (1, 2)");
        $this->addSql("DELETE FROM driver WHERE id IN (1, 2, 3)");
        $this->addSql("DELETE FROM fleet_set WHERE id IN (1, 2, 3, 4)");
        $this->addSql("DELETE FROM truck WHERE id IN (1, 2, 3)");
        $this->addSql("DELETE FROM trailer WHERE id IN (1, 2, 3)");
    }
}
