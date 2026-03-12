<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_bookings')->only(['create']);
        $this->middleware('permission:create_bookings')->only(['store']);
    }

    public function create(Booking $booking): View
    {
        $booking->load(['vehicle:id,brand,model,registration_number', 'customer:id,name,email']);

        return view('payments.create', compact('booking'));
    }

    public function store(StorePaymentRequest $request, Booking $booking): RedirectResponse
    {
        $validated = $request->validated();

        $amount = min((float) $validated['amount'], (float) $booking->due_amount);

        if ($amount <= 0) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['amount' => 'No due amount remaining for this booking.']);
        }

        Payment::create([
            'booking_id' => $booking->id,
            'transaction_id' => 'TXN-'.now()->format('YmdHis').'-'.Str::upper(Str::random(6)),
            'amount' => $amount,
            'payment_method' => $validated['payment_method'],
            'payment_type' => $validated['payment_type'],
            'status' => 'success',
            'payment_details' => [
                'mode' => 'manual',
                'captured_by' => auth()->id(),
            ],
            'paid_at' => now(),
            'notes' => $validated['notes'] ?? null,
        ]);

        $newPaidAmount = (float) $booking->paid_amount + $amount;
        $newDueAmount = max(0, (float) $booking->total_amount - $newPaidAmount);

        $booking->update([
            'paid_amount' => $newPaidAmount,
            'due_amount' => $newDueAmount,
            'payment_status' => $newDueAmount <= 0 ? 'completed' : 'partial',
            'booking_status' => $booking->booking_status === 'pending' ? 'confirmed' : $booking->booking_status,
        ]);

        return redirect()
            ->route('bookings.show', $booking->id)
            ->with('status', 'Payment recorded successfully.');
    }
}
