<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoanRepayRequest;
use App\Http\Requests\LoanRequest;
use App\Models\Loan;
use App\Services\LoanService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;


class LoanController extends Controller
{
    protected LoanService $loanService;

    public function __construct(LoanService $loanService)
    {
        $this->loanService = $loanService;
    }

    /**
     * Apply for a loan.
     */
    public function apply(LoanRequest $request): JsonResponse
    {
        try {
            $loan = $this->loanService->applyLoan($request->validated());
            return sendHttpResponse('Loan applied.', Response::HTTP_CREATED, $loan);
        } catch (Exception $exception) {
            return sendHttpResponse('Failed to apply loan.', 200, null, $exception);
        }
    }

    /**
     * Fetch loan details.
     */
    public function show(Loan $loan): JsonResponse
    {
        try {
            $data = $this->loanService->getLoanDetails($loan->id);
            return sendHttpResponse('Loan fetched.', Response::HTTP_OK, $data);
        } catch (Exception $exception) {
            return sendHttpResponse('Failed to fetch loan.', 200, null, $exception);
        }
    }

    /**
     * Approve a loan (only for admins).
     */
    public function approve(int $id): JsonResponse
    {
        try {
            $this->loanService->approveLoan($id);
            return sendHttpResponse('Loan Approved.', Response::HTTP_OK, []);
        } catch (Exception $exception) {
            return sendHttpResponse('Failed to approve loan.', $exception->getCode(), null, $exception);
        }
    }

    /**
     * Make a repayment.
     */
    public function repay(LoanRepayRequest $loanRepayRequest, int $id): JsonResponse
    {
        try {
            $loanRepayment = $this->loanService->makeRepayment($id, $loanRepayRequest->validated());
            return sendHttpResponse('Loan Repayment created.', Response::HTTP_OK, $loanRepayment);
        } catch (Exception $exception) {
            return sendHttpResponse('Failed to create repayment.', 200, null, $exception);
        }
    }
}
