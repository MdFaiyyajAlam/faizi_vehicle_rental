<?php

namespace App\Services\Contracts;

use App\Models\Booking;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface BookingServiceInterface
{
    public function paginate(int $perPage = 10): LengthAwarePaginator;

    public function findById(int $id): Booking;

    public function create(array $data): Booking;

    public function update(int $id, array $data): Booking;

    public function delete(int $id): bool;
}
