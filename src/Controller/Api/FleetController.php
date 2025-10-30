<?php
namespace App\Controller\Api;

use App\Entity\FleetSet;
use App\Entity\ServiceOrder;
use App\Repository\FleetSetRepository;
use App\Repository\ServiceOrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
class FleetController extends AbstractController
{
    #[Route('/fleets', name: 'fleets', methods: ['GET'])]
    public function listFleets(FleetSetRepository $fleetSetRepository): JsonResponse
    {
        $fleets = $fleetSetRepository->findAll();

        $data = array_map(function (FleetSet $fleetSet) {
            return [
                'id' => $fleetSet->getId(),
                'truck' => [
                    'id' => $fleetSet->getTruck()?->getId(),
                    'license_plate' => $fleetSet->getTruck()?->getLicensePlate(),
                    'is_active' => $fleetSet->getTruck()?->isActive(),
                ],
                'trailer' => [
                    'id' => $fleetSet->getTrailer()?->getId(),
                    'license_plate' => $fleetSet->getTrailer()?->getLicensePlate(),
                    'is_active' => $fleetSet->getTrailer()?->isActive(),
                ],
                'drivers' => array_map(fn($driver) => [
                    'id' => $driver->getId(),
                    'email' => $driver->getEmail(),
                ], $fleetSet->getDrivers()->toArray()),
                'status' => $fleetSet->getStatus()->value,
            ];
        }, $fleets);

        return $this->json($data);
    }

    #[Route('/orders', name: 'orders', methods: ['GET'])]
    public function listOrders(ServiceOrderRepository $orderRepository): JsonResponse
    {
        $orders = $orderRepository->findAll();

        $data = array_map(function (ServiceOrder $order) {
            return [
                'id' => $order->getId(),
                'title' => $order->getTitle(),
                'status' => $order->getStatus()->value,
                'truck_id' => $order->getTruck()?->getId(),
                'trailer_id' => $order->getTrailer()?->getId(),
                'fleet_set_id' => $order->getFleetSet()?->getId(),
            ];
        }, $orders);

        return $this->json($data);
    }
}
