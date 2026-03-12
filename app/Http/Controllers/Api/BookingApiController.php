<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Services\Contracts\BookingServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookingApiController extends Controller
{
    public function __construct(
        private readonly BookingServiceInterface $bookingService
    ) {
        $this->middleware('permission:view_bookings')->only(['index', 'show']);
        $this->middleware('permission:create_bookings')->only(['store']);
        $this->middleware('permission:edit_bookings')->only(['update']);
        $this->middleware('permission:cancel_bookings')->only(['destroy']);
    }

    public function index(Request $request): JsonResponse
    {
        $bookings = $this->bookingService->paginate((int) $request->integer('per_page', 10));

        return response()->json($bookings);
    }

    public function show(int $id): JsonResponse
    {
        $booking = $this->bookingService->findById($id);

        return response()->json($booking);
    }

    public function store(StoreBookingRequest $request): JsonResponse
    {
        $booking = $this->bookingService->create($request->validated());

        return response()->json($booking, 201);
    }

    public function update(UpdateBookingRequest $request, int $id): JsonResponse
    {
        $booking = $this->bookingService->update($id, $request->validated());

        return response()->json($booking);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->bookingService->delete($id);

        return response()->json(['message' => 'Booking cancelled successfully.']);
    }
}
