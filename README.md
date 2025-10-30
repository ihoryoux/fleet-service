# Fleet Service

REST service responsible for managing a transport fleet.

---

## Requirements

- Docker

---

## Setup Instructions

1. **Clone the repository**
```bash
git clone https://github.com/ihoryoux/fleet-service.git
cd fleet-service
```

2. **Start the Docker environment**
```bash
docker compose up -d
```

3. **Create .env from .env.example**
4. **Install dependencies inside the PHP container**
```bash
docker exec -it fleet-service-php composer install
```

5. **Run database migrations**
```bash
docker exec -it fleet-service-php php bin/console doctrine:migrations:migrate --no-interaction
```

---

## API Endpoints

All endpoints are public and return JSON.

### `/api/fleets`

Returns list of fleet sets including:
- Truck + Trailer (license plate, is_active)
- Assigned drivers (up to 2, email)
- Status:
    - `Works` (both truck and trailer are active)
    - `Downtime` (any of truck or trailer is inactive)
    - `Free` (no drivers assigned, both truck and trailer are active)

#### Schema:
```ts
FleetResponse = {
  id: number;
  truck: {
    id: number;
    license_plate: string;
    is_active: boolean;
  };
  trailer: {
    id: number;
    license_plate: string;
    is_active: boolean;
  };
  drivers: Array<{
    id: number;
    email: string;
  }>;
  status: "Works" | "Downtime" | "Free";
};
```

#### Example:
```json
[
  {
    "id": 1,
    "truck": {
      "id": 1,
      "license_plate": "Truck-111",
      "is_active": true
    },
    "trailer": {
      "id": 1,
      "license_plate": "Trailer-111",
      "is_active": true
    },
    "drivers": [
      { "id": 1, "email": "driver1@example.com" },
      { "id": 2, "email": "driver2@example.com" }
    ],
    "status": "Works"
  },
  {
    "id": 4,
    "truck": {
      "id": 4,
      "license_plate": "Truck-444",
      "is_active": true
    },
    "trailer": {
      "id": 4,
      "license_plate": "Trailer-444",
      "is_active": true
    },
    "drivers": [],
    "status": "Free"
  }
]
```

---

### `/api/orders`

Returns list of service orders

#### Schema:
```ts
OrderResponse = {
  id: number;
  title: string;
  status: "in_service" | "pending" | "completed" | "cancelled";
  truck_id: number | null;
  trailer_id: number | null;
  fleet_set_id: number | null;
};
```

#### Example:
```json
[
  {
    "id": 1,
    "title": "Replace tires",
    "status": "in_service",
    "truck_id": 1,
    "trailer_id": 1,
    "fleet_set_id": 1
  },
  {
    "id": 4,
    "title": "Full service",
    "status": "cancelled",
    "truck_id": null,
    "trailer_id": null,
    "fleet_set_id": 1
  }
]
```

---

## Running Tests

**IMPORTANT! For running tests, copy** *.env.example.test* **to** *.env.test*

### 1. Create the test database
```bash
docker exec -it fleet-service-php php bin/console doctrine:database:create --env=test
```

### 2. Run migrations for test DB
```bash
docker exec -it fleet-service-php php bin/console doctrine:migrations:migrate --env=test --no-interaction
```

### 3. Run PHPUnit tests
```bash
docker exec -e APP_ENV=test -it fleet-service-php php bin/phpunit
```

You can also run tests separately:

#### Run only unit tests
```bash
docker exec -e APP_ENV=test -it fleet-service-php php bin/phpunit --testsuite Unit
```

#### Run only functional tests
```bash
docker exec -e APP_ENV=test -it fleet-service-php php bin/phpunit --testsuite Functional
```

---

## Tech Stack

- PHP 8.3
- Symfony 7
- PostgreSQL 16
- Doctrine ORM
- PHPUnit 10+
- Docker
