<?php

namespace App\Entity;

use App\Enum\ServiceOrderStatus;
use App\Repository\ServiceOrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceOrderRepository::class)]
class ServiceOrder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: false, enumType: ServiceOrderStatus::class)]
    private ?ServiceOrderStatus $status = null;

    #[ORM\Column(length: 255, nullable: false)]
    private ?string $title = null;

    #[ORM\ManyToOne]
    private ?Truck $truck = null;

    #[ORM\ManyToOne]
    private ?Trailer $trailer = null;

    #[ORM\ManyToOne]
    private ?FleetSet $fleetSet = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?ServiceOrderStatus
    {
        return $this->status;
    }

    public function setStatus(ServiceOrderStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getTruck(): ?Truck
    {
        return $this->truck;
    }

    public function setTruck(?Truck $truck): static
    {
        $this->truck = $truck;

        return $this;
    }

    public function getTrailer(): ?Trailer
    {
        return $this->trailer;
    }

    public function setTrailer(?Trailer $trailer): static
    {
        $this->trailer = $trailer;

        return $this;
    }

    public function getFleetSet(): ?FleetSet
    {
        return $this->fleetSet;
    }

    public function setFleetSet(?FleetSet $fleetSet): static
    {
        $this->fleetSet = $fleetSet;

        return $this;
    }
}
