<?php

namespace App\Services;

use App\Models\Booking;
use App\Repositories\Contracts\BookingRepositoryInterface;
use App\Services\Contracts\BookingServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class BookingService implements BookingServiceInterface
{
    public function __construct(
        private readonly BookingRepositoryInterface $bookingRepository
    ) {
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return $this->bookingRepository->paginate($perPage);
    }

    public function findById(int $id): Booking
    {
        return $this->bookingRepository->findById($id);
    }

    public function create(array $data): Booking
    {
        $payload = $this->normalizePayload($data);
        $payload['booking_number'] = $this->generateBookingNumber();

        return $this->bookingRepository->create($payload);
    }

    public function update(int $id, array $data): Booking
    {
        $booking = $this->bookingRepository->findById($id);
        $payload = $this->normalizePayload($data);

        return $this->bookingRepository->update($booking, $payload);
    }

    public function delete(int $id): bool
    {
        $booking = $this->bookingRepository->findById($id);

        return $this->bookingRepository->delete($booking);
    }

    private function normalizePayload(array $data): array
    {
        $basePrice = (float) ($data['base_price'] ?? 0);
        $extraCharges = (float) ($data['extra_charges'] ?? 0);
        $taxAmount = (float) ($data['tax_amount'] ?? 0);
        $discountAmount = (float) ($data['discount_amount'] ?? 0);
        $securityDeposit = (float) ($data['security_deposit'] ?? 0);
        $paidAmount = (float) ($data['paid_amount'] ?? 0);

        $totalAmount = max(0, ($basePrice + $extraCharges + $taxAmount + $securityDeposit) - $discountAmount);
        $dueAmount = max(0, $totalAmount - $paidAmount);

        $data['total_amount'] = $totalAmount;
        $data['due_amount'] = $dueAmount;

        if ($paidAmount <= 0) {
            $data['payment_status'] = 'pending';
        } elseif ($dueAmount > 0) {
            $data['payment_status'] = 'partial';
        } else {
            $data['payment_status'] = 'completed';
        }

        if (array_key_exists('additional_requirements', $data)) {
            $data['additional_requirements'] = $this->normalizeArrayField($data['additional_requirements']);
        }

        return $data;
    }

    private function normalizeArrayField(mixed $value): array
    {
        if (is_array($value)) {
            return collect($value)
                ->map(fn ($item) => is_string($item) ? trim($item) : '')
                ->filter()
                ->values()
                ->all();
        }

        if (! is_string($value) || trim($value) === '') {
            return [];
        }

        return collect(explode(',', $value))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();
    }

    private function generateBookingNumber(): string
    {
        do {
            $number = 'BK-'.now()->format('Ymd').'-'.Str::upper(Str::random(6));
        } while (Booking::query()->where('booking_number', $number)->exists());

        return $number;
    }
}
