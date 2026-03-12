<?php

namespace App\Repositories\Eloquent;

use App\Models\Booking;
use App\Repositories\Contracts\BookingRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BookingRepository implements BookingRepositoryInterface
{
    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return Booking::query()
            ->with([
                'vehicle:id,brand,model,registration_number',
                'customer:id,name',
                'vendor:id,name',
                'driver:id,name',
                'payments:id,booking_id,amount,payment_method,payment_type,status,paid_at,transaction_id',
            ])
            ->latest('id')
            ->paginate($perPage);
    }

    public function findById(int $id): Booking
    {
        return Booking::query()
            ->with([
                'vehicle:id,brand,model,registration_number',
                'customer:id,name',
                'vendor:id,name',
                'driver:id,name',
                'payments:id,booking_id,amount,payment_method,payment_type,status,paid_at,transaction_id',
            ])
            ->findOrFail($id);
    }

    public function create(array $data): Booking
    {
        return Booking::create($data);
    }

    public function update(Booking $booking, array $data): Booking
    {
        $booking->update($data);

        return $booking->refresh();
    }

    public function delete(Booking $booking): bool
    {
        return (bool) $booking->delete();
    }
}
