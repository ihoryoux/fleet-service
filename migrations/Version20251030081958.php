<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251030081958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE driver (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_11667CD9E7927C74 ON driver (email)');
        $this->addSql('CREATE TABLE fleet_set (id SERIAL NOT NULL, truck_id INT NOT NULL, trailer_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_49EA01EAC6957CCE ON fleet_set (truck_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_49EA01EAB6C04CFD ON fleet_set (trailer_id)');
        $this->addSql('CREATE TABLE fleet_set_driver (fleet_set_id INT NOT NULL, driver_id INT NOT NULL, PRIMARY KEY(fleet_set_id, driver_id))');
        $this->addSql('CREATE INDEX IDX_A1796F9BF0AA28 ON fleet_set_driver (fleet_set_id)');
        $this->addSql('CREATE INDEX IDX_A1796FC3423909 ON fleet_set_driver (driver_id)');
        $this->addSql('CREATE TABLE service_order (id SERIAL NOT NULL, truck_id INT DEFAULT NULL, trailer_id INT DEFAULT NULL, fleet_set_id INT DEFAULT NULL, status VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5C5B7E7FC6957CCE ON service_order (truck_id)');
        $this->addSql('CREATE INDEX IDX_5C5B7E7FB6C04CFD ON service_order (trailer_id)');
        $this->addSql('CREATE INDEX IDX_5C5B7E7F9BF0AA28 ON service_order (fleet_set_id)');
        $this->addSql('CREATE TABLE trailer (id SERIAL NOT NULL, license_plate VARCHAR(64) NOT NULL, is_active BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C691DC4EF5AA79D0 ON trailer (license_plate)');
        $this->addSql('CREATE TABLE truck (id SERIAL NOT NULL, license_plate VARCHAR(64) NOT NULL, is_active BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CDCCF30AF5AA79D0 ON truck (license_plate)');
        $this->addSql('ALTER TABLE fleet_set ADD CONSTRAINT FK_49EA01EAC6957CCE FOREIGN KEY (truck_id) REFERENCES truck (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fleet_set ADD CONSTRAINT FK_49EA01EAB6C04CFD FOREIGN KEY (trailer_id) REFERENCES trailer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fleet_set_driver ADD CONSTRAINT FK_A1796F9BF0AA28 FOREIGN KEY (fleet_set_id) REFERENCES fleet_set (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fleet_set_driver ADD CONSTRAINT FK_A1796FC3423909 FOREIGN KEY (driver_id) REFERENCES driver (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE service_order ADD CONSTRAINT FK_5C5B7E7FC6957CCE FOREIGN KEY (truck_id) REFERENCES truck (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE service_order ADD CONSTRAINT FK_5C5B7E7FB6C04CFD FOREIGN KEY (trailer_id) REFERENCES trailer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE service_order ADD CONSTRAINT FK_5C5B7E7F9BF0AA28 FOREIGN KEY (fleet_set_id) REFERENCES fleet_set (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fleet_set DROP CONSTRAINT FK_49EA01EAC6957CCE');
        $this->addSql('ALTER TABLE fleet_set DROP CONSTRAINT FK_49EA01EAB6C04CFD');
        $this->addSql('ALTER TABLE fleet_set_driver DROP CONSTRAINT FK_A1796F9BF0AA28');
        $this->addSql('ALTER TABLE fleet_set_driver DROP CONSTRAINT FK_A1796FC3423909');
        $this->addSql('ALTER TABLE service_order DROP CONSTRAINT FK_5C5B7E7FC6957CCE');
        $this->addSql('ALTER TABLE service_order DROP CONSTRAINT FK_5C5B7E7FB6C04CFD');
        $this->addSql('ALTER TABLE service_order DROP CONSTRAINT FK_5C5B7E7F9BF0AA28');
        $this->addSql('DROP TABLE driver');
        $this->addSql('DROP TABLE fleet_set');
        $this->addSql('DROP TABLE fleet_set_driver');
        $this->addSql('DROP TABLE service_order');
        $this->addSql('DROP TABLE trailer');
        $this->addSql('DROP TABLE truck');
    }
}
