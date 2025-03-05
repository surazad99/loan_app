<?php

namespace App\Repositories;

use App\Models\Loan;
use App\Models\Repayment;

class LoanRepository
{
    /**
     * Create a new loan.
     */
    public function create(array $data): array
    {
        return Loan::create($data)->toArray();
    }

    /**
     * Find a loan by ID and user ID.
     */
    public function findById(int $id): array
    {
        $loan = Loan::where('id', $id)->firstOrFail();
        return $loan->toArray();
    }

    /**
     * Update the loan status.
     */
    public function updateStatus(int $id, string $status): Loan
    {
        $loan = Loan::findOrFail($id);
        $loan->update(['status' => $status]);
        return $loan->fresh();
    }
}
