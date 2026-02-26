# SwiftRoute — Architecture & Technical Overview

## Project Summary

**SwiftRoute** is a delivery booking and logistics management platform built with Laravel 10. It enables businesses to offer on-demand delivery services with dynamic pricing, multi-stop routing, and real-time distance calculations via Google Maps API.

---

## Technology Stack

| Layer | Technology |
|-------|------------|
| **Backend Framework** | Laravel 10.x (PHP 8.2+) |
| **Database** | MySQL 8.0 |
| **Caching** | Redis 7 |
| **Queue System** | Laravel Queue with Redis driver |
| **Session Management** | Redis-backed sessions |
| **Web Server** | Nginx (Alpine) |
| **Containerization** | Docker & Docker Compose |
| **Frontend** | Blade Templates + Vite |
| **Code Quality** | Laravel Pint, PHPUnit |
| **External APIs** | Google Maps Distance Matrix API |

---

## Architecture Patterns

### 1. Service Layer Pattern
Business logic is encapsulated in dedicated service classes, separating concerns from controllers:

- **PricingService** — Calculates delivery costs using configurable pricing rules, vehicle multipliers, loading fees, and surge pricing
- **DistanceService** — Integrates with Google Maps Distance Matrix API to calculate real distances between multiple stops
- **DeliveryBookingService** — Orchestrates the complete booking workflow
- **GeographyService** — Handles service area validation and geographic operations

### 2. Repository Pattern
Data access is abstracted through repositories:
- **DeliveryRepository** — Handles all delivery-related database operations with contract interfaces

### 3. Domain-Driven Models
Eloquent models represent core business entities with relationships and business logic:

| Model | Purpose |
|-------|---------|
| `Delivery` | Core booking entity with status management |
| `DeliveryStop` | Polymorphic pickup/delivery locations |
| `VehicleType` | Fleet configuration with price multipliers |
| `PricingRule` | Key-value dynamic pricing configuration |
| `TimeSlot` | Schedule availability windows |
| `LoadingOption` | Service level configurations |
| `ServiceArea` | Geographic coverage boundaries |

---

## Key Features Implemented

### Dynamic Pricing Engine
- Base fee + per-kilometer pricing
- Vehicle type multipliers (van, truck, motorcycle)
- Loading service surcharges
- Surge pricing support
- Minimum charge thresholds

### Multi-Stop Delivery Support
- Multiple pickup locations
- Multiple delivery locations
- Distance matrix calculations for optimal routing
- Per-stop validation and pricing

### Google Maps Integration
- Real-time distance calculations
- Route optimization suggestions
- Address geocoding
- Service area validation

### Booking Workflow
- Multi-step wizard UI
- Real-time price updates
- Time slot selection with availability
- Email confirmations via queued jobs

---

## Infrastructure

### Docker Services
```
┌─────────────────────────────────────────────────┐
│                 Docker Network                   │
├──────────┬──────────┬──────────┬───────────────┤
│   App    │  Nginx   │  MySQL   │    Redis      │
│ PHP-FPM  │  Proxy   │   8.0    │    7.x        │
├──────────┴──────────┴──────────┴───────────────┤
│              Queue Worker (PHP)                  │
├─────────────────────────────────────────────────┤
│              Mailpit (Dev Email)                 │
└─────────────────────────────────────────────────┘
```

### Queue Processing
- Redis-backed queue for background jobs
- Email notifications processed asynchronously
- Configurable retry policies

---

## API Design

RESTful API endpoints for:
- Delivery CRUD operations
- Real-time price calculations
- Vehicle type listings
- Time slot availability
- Service area queries

---

## Development Practices

- **PSR-4 Autoloading** — Standard PHP namespace conventions
- **Database Migrations** — Version-controlled schema changes
- **Seeders** — Sample data for development
- **Code Formatting** — Laravel Pint for consistent style
- **Testing** — PHPUnit test suite
- **Environment Config** — 12-factor app principles with `.env`

---

## Skills Demonstrated

- **PHP/Laravel** — Advanced framework usage with services, repositories, and custom providers
- **API Integration** — Google Maps Distance Matrix API implementation
- **Database Design** — Normalized schema with proper relationships
- **Docker/DevOps** — Full containerization with multi-service orchestration
- **Redis** — Caching, sessions, and queue management
- **Domain Modeling** — Clean separation of business logic
- **RESTful API Design** — Resource-based endpoint architecture
