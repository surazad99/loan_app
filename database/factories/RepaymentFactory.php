<?php

namespace Database\Factories;

use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Repayment>
 */
class RepaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'loan_id' => Loan::factory(),
            'amount' => $this->faker->randomFloat(2, 50, 5000),
            'due_date' => Carbon::now()->addDays($this->faker->numberBetween(1, 30))->format('Y-m-d'),
            'status' => $this->faker->randomElement(['pending', 'paid', 'overdue']),
        ];
    }
}
