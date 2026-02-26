.PHONY: help install dev build up down restart logs shell mysql redis fresh migrate seed test lint format cache clear queue schedule

# Default target
help: ## Display this help message
	@echo "SwiftRoute - Delivery Booking System"
	@echo ""
	@echo "Usage: make [target]"
	@echo ""
	@echo "Targets:"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2}'

# Installation
install: ## Install dependencies and setup application
	cp -n .env.example .env || true
	docker compose build
	docker compose up -d
	docker compose exec app composer install
	docker compose exec app php artisan key:generate
	docker compose exec app php artisan migrate --seed
	@echo "\n✅ SwiftRoute installed! Access at http://localhost:8080"

# Development
dev: ## Start development environment
	docker compose up -d
	@echo "\n🚀 Development server running at http://localhost:8080"
	@echo "📧 Mailpit UI at http://localhost:8025"

# Build
build: ## Build Docker images
	docker compose build --no-cache

# Docker Management
up: ## Start containers
	docker compose up -d

down: ## Stop containers
	docker compose down

restart: ## Restart containers
	docker compose restart

logs: ## View container logs
	docker compose logs -f

# Shell Access
shell: ## Open shell in app container
	docker compose exec app sh

mysql: ## Open MySQL CLI
	docker compose exec mysql mysql -u swiftroute -psecret swiftroute

redis: ## Open Redis CLI
	docker compose exec redis redis-cli

# Database
fresh: ## Fresh migrate with seeders
	docker compose exec app php artisan migrate:fresh --seed

migrate: ## Run migrations
	docker compose exec app php artisan migrate

seed: ## Run database seeders
	docker compose exec app php artisan db:seed

# Testing
test: ## Run test suite
	docker compose exec app php artisan test

test-coverage: ## Run tests with coverage
	docker compose exec app php artisan test --coverage

# Code Quality
lint: ## Run PHP linter (Pint)
	docker compose exec app ./vendor/bin/pint --test

format: ## Fix code formatting
	docker compose exec app ./vendor/bin/pint

# Cache Management
cache: ## Optimize application for production
	docker compose exec app php artisan config:cache
	docker compose exec app php artisan route:cache
	docker compose exec app php artisan view:cache
	docker compose exec app php artisan event:cache

clear: ## Clear all caches
	docker compose exec app php artisan cache:clear
	docker compose exec app php artisan config:clear
	docker compose exec app php artisan route:clear
	docker compose exec app php artisan view:clear
	docker compose exec app php artisan event:clear

# Queue & Scheduler
queue: ## Start queue worker
	docker compose exec app php artisan queue:work redis --verbose

schedule: ## Run scheduler once
	docker compose exec app php artisan schedule:run

# Production
deploy: ## Deploy to production
	docker compose -f docker-compose.yml -f docker-compose.prod.yml up -d --build
	docker compose exec app php artisan migrate --force
	docker compose exec app php artisan config:cache
	docker compose exec app php artisan route:cache
	docker compose exec app php artisan view:cache
