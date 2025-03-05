<?php

namespace App\Services;

use App\Events\LoanStatusUpdated;
use App\Models\Loan;
use App\Repositories\LoanRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;

class LoanService
{
    protected LoanRepository $loanRepository;
    protected LoanRepaymentService $loanRepaymentService;

    public function __construct(LoanRepository $loanRepository, LoanRepaymentService $loanRepaymentService)
    {
        $this->loanRepository = $loanRepository;
        $this->loanRepaymentService = $loanRepaymentService;
    }

    /**
     * Apply for a loan.
     */
    public function applyLoan(array $data): array
    {
        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';
        return $this->loanRepository->create($data);
    }

    /**
     * Get loan details.
     */
    public function getLoanDetails(int $id): array
    {
        return $this->loanRepository->findById($id);
    }

    /**
     * Approve a loan (Admin Only).
     */
    public function approveLoan(int $id): array
    {
        $loan = $this->loanRepository->updateStatus($id, 'approved');
        Event::dispatch(new LoanStatusUpdated($loan));
        return $loan->toArray();
    }

    /**
     * Make a repayment.
     */
    public function makeRepayment(int $loanId, array $data): array
    {
        $data['loan_id'] = $loanId;
        return $this->loanRepaymentService->createRepayment($data);
    }
}
