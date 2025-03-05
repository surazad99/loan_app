<?php

namespace App\Policies;

use App\Models\Loan;
use App\Models\User;

class LoanPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the user can approve loans (only admins allowed).
     */
    public function approve(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine if the user can view a specific loan.
     */
    public function view(User $user, Loan $loan): bool
    {
        return $user->id === $loan->user_id || $user->role === 'admin';
    }
}
