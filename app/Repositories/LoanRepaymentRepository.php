<?php

namespace App\Repositories;

use App\Models\Repayment;

class LoanRepaymentRepository
{
    /**
     * Create a new loan repayment
     */
    public function create(array $data): array
    {
        return Repayment::create($data)->toArray();
    }
}