<?php

namespace App\Repositories;

use App\Models\Delivery;
use App\Models\DeliveryStop;
use App\Repositories\Contracts\DeliveryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class DeliveryRepository implements DeliveryRepositoryInterface
{
    public function create(array $data): Delivery
    {
        return DB::transaction(function () use ($data) {
            $stops = $data['stops'] ?? [];
            unset($data['stops']);

            $delivery = Delivery::create($data);

            foreach ($stops as $stop) {
                $stop['delivery_id'] = $delivery->id;
                DeliveryStop::create($stop);
            }

            return $delivery->load(['stops', 'vehicleType', 'timeSlot', 'loadingOption']);
        });
    }

    public function find(int $id): ?Delivery
    {
        return Delivery::with(['stops', 'vehicleType', 'timeSlot', 'loadingOption'])->find($id);
    }

    public function findByReference(string $reference): ?Delivery
    {
        return Delivery::with(['stops', 'vehicleType', 'timeSlot', 'loadingOption'])
            ->where('booking_reference', $reference)
            ->first();
    }

    public function updateStatus(int $id, string $status): bool
    {
        return Delivery::where('id', $id)->update(['status' => $status]) > 0;
    }

    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $query = Delivery::with(['vehicleType', 'timeSlot', 'loadingOption']);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['date_from'])) {
            $query->where('pickup_date', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where('pickup_date', '<=', $filters['date_to']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('booking_reference', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        return $query->orderByDesc('created_at')->paginate($perPage);
    }

    public function getByDateRange(string $from, string $to): Collection
    {
        return Delivery::with(['stops', 'vehicleType', 'timeSlot', 'loadingOption'])
            ->whereBetween('pickup_date', [$from, $to])
            ->orderBy('pickup_date')
            ->get();
    }

    public function countByStatus(): array
    {
        return Delivery::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
    }
}
