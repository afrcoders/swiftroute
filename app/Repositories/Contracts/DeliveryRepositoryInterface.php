<?php

namespace App\Repositories\Contracts;

use App\Models\Delivery;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface DeliveryRepositoryInterface
{
    public function create(array $data): Delivery;

    public function find(int $id): ?Delivery;

    public function findByReference(string $reference): ?Delivery;

    public function updateStatus(int $id, string $status): bool;

    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator;

    public function getByDateRange(string $from, string $to): Collection;

    public function countByStatus(): array;
}
