<?php

namespace App\Jobs;

use App\Models\Repayment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class UpdateOverdueRepayments implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $overdueRepayments = Repayment::where('status', 'pending')
            ->where('due_date', '<', Carbon::now())->get();

        foreach($overdueRepayments as $overdueRepayment){
            $overdueRepayment->update(['status' => 'overdue']);
        }

        Log::info("Overdue repayments updated", ['count' => count($overdueRepayments)]);
    }
}
