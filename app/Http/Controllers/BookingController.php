<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\User;
use App\Models\Vehicle;
use App\Services\Contracts\BookingServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function __construct(
        private readonly BookingServiceInterface $bookingService
    ) {
        $this->middleware('permission:view_bookings')->only(['index', 'show']);
        $this->middleware('permission:create_bookings')->only(['create', 'store']);
        $this->middleware('permission:edit_bookings')->only(['edit', 'update']);
        $this->middleware('permission:cancel_bookings')->only(['destroy']);
    }

    public function index(Request $request): View
    {
        $bookings = $this->bookingService->paginate((int) $request->integer('per_page', 10));

        return view('bookings.index', compact('bookings'));
    }

    public function create(Request $request): View
    {
        $defaults = [
            'customer_id' => auth()->user()?->role === 'customer' ? auth()->id() : null,
            'vehicle_id' => $request->filled('vehicle_id') ? (int) $request->integer('vehicle_id') : null,
            'vendor_id' => $request->filled('vendor_id') ? (int) $request->integer('vendor_id') : null,
        ];

        return view('bookings.create', $this->formData(compact('defaults')));
    }

    public function store(StoreBookingRequest $request): RedirectResponse
    {
        $booking = $this->bookingService->create($request->validated());

        return redirect()
            ->route('payments.create', $booking->id)
            ->with('status', 'Booking created successfully. Please complete payment.');
    }

    public function show(int $id): View
    {
        $booking = $this->bookingService->findById($id);

        return view('bookings.show', compact('booking'));
    }

    public function edit(int $id): View
    {
        $booking = $this->bookingService->findById($id);

        return view('bookings.edit', $this->formData(['booking' => $booking]));
    }

    public function update(UpdateBookingRequest $request, int $id): RedirectResponse
    {
        $this->bookingService->update($id, $request->validated());

        return redirect()
            ->route('bookings.index')
            ->with('status', 'Booking updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->bookingService->delete($id);

        return redirect()
            ->route('bookings.index')
            ->with('status', 'Booking cancelled successfully.');
    }

    /**
     * @param array<string, mixed> $extra
     * @return array<string, mixed>
     */
    private function formData(array $extra = []): array
    {
        $customers = User::query()->select(['id', 'name'])->where('role', 'customer')->orderBy('name')->get();
        $vendors = User::query()->select(['id', 'name'])->where('role', 'vendor')->orderBy('name')->get();
        $drivers = User::query()->select(['id', 'name'])->where('role', 'driver')->orderBy('name')->get();
        $vehicles = Vehicle::query()->select(['id', 'brand', 'model', 'registration_number'])->orderBy('brand')->orderBy('model')->get();

        return array_merge($extra, compact('customers', 'vendors', 'drivers', 'vehicles'));
    }
}
