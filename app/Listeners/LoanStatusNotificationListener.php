<?php

namespace App\Listeners;

use App\Events\LoanStatusUpdated;
use App\Mail\LoanStatusNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LoanStatusNotificationListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LoanStatusUpdated $event): void
    {
        $loan = $event->loan;
        $user = $loan->user;

        try {
            // Send email notification
            Mail::to($user->email)->send(new LoanStatusNotification($loan));

            // Log the notification
            Log::info("Loan status notification sent for Loan ID: {$loan->id} was {$loan->status}");
        } catch (\Exception $e) {
            // Log any email sending errors
            Log::error("Failed to send loan status notification: " . $e->getMessage());
        }
    }
}
