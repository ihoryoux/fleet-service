<?php

namespace App\Entity;

use App\Enum\FleetSetStatus;
use App\Repository\FleetSetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use LogicException;

#[ORM\Entity(repositoryClass: FleetSetRepository::class)]
class FleetSet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'fleetSet', cascade: ['persist'], orphanRemoval: false)]
    #[ORM\JoinColumn(unique: true, nullable: false)]
    private ?Truck $truck = null;

    #[ORM\OneToOne(inversedBy: 'fleetSet', cascade: ['persist'])]
    #[ORM\JoinColumn(unique: true, nullable: false)]
    private ?Trailer $trailer = null;

    /**
     * @var Collection<int, Driver>
     */
    #[ORM\ManyToMany(targetEntity: Driver::class)]
    private Collection $drivers;

    public function __construct()
    {
        $this->drivers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTruck(): ?Truck
    {
        return $this->truck;
    }

    public function setTruck(Truck $truck): static
    {
        $this->truck = $truck;

        return $this;
    }

    public function getTrailer(): ?Trailer
    {
        return $this->trailer;
    }

    public function setTrailer(Trailer $trailer): static
    {
        $this->trailer = $trailer;

        return $this;
    }

    /**
     * @return Collection<int, Driver>
     */
    public function getDrivers(): Collection
    {
        return $this->drivers;
    }

    /**
     * @param Driver $driver
     * @return $this
     *
     * @throws LogicException
     */
    public function addDriver(Driver $driver): static
    {
        if ($this->drivers->count() >= 2) {
            throw new LogicException('A Fleet Set can have maximum 2 Drivers.');
        }

        if (!$this->drivers->contains($driver)) {
            $this->drivers->add($driver);
        }

        return $this;
    }

    public function removeDriver(Driver $driver): static
    {
        $this->drivers->removeElement($driver);

        return $this;
    }

    /**
     * Determines the current status of the FleetSet based on truck/trailer activity and assigned drivers.
     *
     * @return FleetSetStatus
     */
    public function getStatus(): FleetSetStatus
    {
        if (!$this->truck->isActive() || !$this->trailer->isActive()) {
            return FleetSetStatus::DOWNTIME;
        }

        if ($this->drivers->isEmpty()) {
            return FleetSetStatus::FREE;
        }

        return FleetSetStatus::WORKS;
    }
}
