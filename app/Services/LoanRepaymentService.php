<?php
namespace App\Services;

use App\Repositories\LoanRepaymentRepository;

class LoanRepaymentService
{
    protected LoanRepaymentRepository $loanRepaymentRepository;

    public function __construct(LoanRepaymentRepository $loanRepaymentRepository)
    {
        $this->loanRepaymentRepository = $loanRepaymentRepository;
    }

    public function createRepayment(array $data) : array
    {
        return $this->loanRepaymentRepository->create($data);
    }
}