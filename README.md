<p align="center">
  <img src="public/assets/icons/logo.svg" alt="SwiftRoute Logo" width="200">
</p>

<h1 align="center">SwiftRoute</h1>

<p align="center">
  <strong>A modern delivery booking and logistics management system</strong>
</p>

<p align="center">
  <a href="#features">Features</a> •
  <a href="#tech-stack">Tech Stack</a> •
  <a href="#getting-started">Getting Started</a> •
  <a href="#api-documentation">API</a> •
  <a href="#contributing">Contributing</a>
</p>

---

## Overview

SwiftRoute is a full-featured delivery booking platform built with Laravel. It enables businesses to offer delivery services with real-time pricing, multi-stop routing, and comprehensive admin management.

## Features

- **Multi-Step Booking Wizard** — Intuitive step-by-step booking flow
- **Real-Time Pricing** — Dynamic pricing based on distance, vehicle type, and service options
- **Multi-Stop Deliveries** — Support for multiple pickup and delivery locations
- **Google Maps Integration** — Distance calculation and route optimization
- **Vehicle Fleet Management** — Configure different vehicle types with custom pricing
- **Time Slot Management** — Flexible scheduling with availability controls
- **Admin Dashboard** — Complete booking management and analytics
- **Email Notifications** — Automated booking confirmations
- **Queue Processing** — Background job handling with Redis
- **REST API** — Full API for integrations

## Tech Stack

- **Framework:** Laravel 10.x
- **PHP:** 8.2+
- **Database:** MySQL 8.0
- **Cache/Queue:** Redis 7
- **Web Server:** Nginx
- **Containerization:** Docker & Docker Compose
- **Frontend:** Blade Templates + Vite

## Getting Started

### Prerequisites

- Docker Desktop (or Docker Engine + Docker Compose)
- Git

### Quick Start

```bash
# Clone the repository
git clone https://github.com/afrcoders/swiftroute.git
cd swiftroute

# Start with Make (recommended)
make install

# Or manually
cp .env.example .env
docker compose up -d --build
docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
```

The application will be available at:
- **App:** http://localhost:8080
- **Mailpit (email testing):** http://localhost:8025

### Available Commands

```bash
make dev          # Start development environment
make down         # Stop containers
make logs         # View logs
make shell        # Open shell in app container
make fresh        # Fresh migration with seeders
make test         # Run test suite
make lint         # Check code style
make format       # Fix code formatting
make cache        # Optimize for production
make clear        # Clear all caches
```

### Environment Configuration

Key environment variables in `.env`:

```env
# Application
APP_NAME=SwiftRoute
APP_URL=http://localhost

# Database
DB_HOST=mysql
DB_DATABASE=swiftroute
DB_USERNAME=swiftroute
DB_PASSWORD=secret

# Redis (for cache, sessions, queues)
REDIS_HOST=redis

# Google Maps API (required for distance calculations)
GOOGLE_MAPS_API_KEY=your_api_key_here
```

## Architecture

```
swiftroute/
├── app/
│   ├── Http/Controllers/    # Request handlers
│   ├── Models/              # Eloquent models
│   ├── Services/            # Business logic
│   │   ├── DeliveryBookingService.php
│   │   ├── DistanceService.php
│   │   ├── PricingService.php
│   │   └── GeographyService.php
│   ├── Repositories/        # Data access layer
│   └── Mail/                # Email templates
├── config/                  # Configuration files
├── database/
│   ├── migrations/          # Database schema
│   └── seeders/             # Sample data
├── docker/                  # Docker configuration
├── routes/
│   ├── api.php              # API routes
│   ├── web.php              # Web routes
│   ├── deliveries.php       # Delivery booking routes
│   └── admin.php            # Admin panel routes
└── tests/                   # Test suite
```

### Key Models

| Model | Description |
|-------|-------------|
| `Delivery` | Core booking entity |
| `DeliveryStop` | Pickup/delivery locations |
| `VehicleType` | Fleet configuration |
| `PricingRule` | Dynamic pricing rules |
| `TimeSlot` | Scheduling availability |
| `LoadingOption` | Service levels |
| `ServiceArea` | Geographic coverage |

## API Documentation

### Endpoints

#### Deliveries

```
GET    /api/deliveries              # List all deliveries
POST   /api/deliveries              # Create delivery booking
GET    /api/deliveries/{id}         # Get delivery details
PATCH  /api/deliveries/{id}/status  # Update status
```

#### Pricing

```
POST   /api/pricing/calculate       # Calculate delivery price
GET    /api/vehicle-types           # List vehicle types
GET    /api/time-slots              # Available time slots
GET    /api/loading-options         # Loading service options
```

### Example Request

```bash
curl -X POST http://localhost:8080/api/pricing/calculate \
  -H "Content-Type: application/json" \
  -d '{
    "pickup_locations": [{"address": "123 Main St", "postal_code": "R3C 0A1"}],
    "delivery_locations": [{"address": "456 Oak Ave", "postal_code": "R3M 0Y1"}],
    "vehicle_type_id": 1,
    "pickup_date": "2026-03-01"
  }'
```

## Testing

```bash
# Run all tests
make test

# Run with coverage
make test-coverage

# Run specific test file
docker compose exec app php artisan test tests/Feature/DeliveryBookingTest.php
```

## Production Deployment

### Using Docker

```bash
# Build production image
docker build -t swiftroute:latest .

# Run with production compose
docker compose -f docker-compose.yml -f docker-compose.prod.yml up -d
```

### Environment Checklist

- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Configure production database credentials
- [ ] Set up Redis for sessions/cache/queue
- [ ] Configure Google Maps API key
- [ ] Set up mail provider
- [ ] Enable HTTPS
- [ ] Configure trusted proxies

### Performance Optimization

```bash
# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Or use Make
make cache
```

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Code Style

This project uses [Laravel Pint](https://laravel.com/docs/pint) for code formatting:

```bash
# Check code style
make lint

# Fix code style
make format
```

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## Acknowledgments

- [Laravel](https://laravel.com) — The PHP framework
- [Google Maps Platform](https://developers.google.com/maps) — Distance Matrix API
- [Redis](https://redis.io) — In-memory data store
