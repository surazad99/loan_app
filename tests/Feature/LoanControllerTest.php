<?php

namespace Tests\Feature;

use App\Models\Loan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class LoanControllerTest extends TestCase
{
    use RefreshDatabase;
    
    protected $user;
    protected $admin;
    protected $loanFactory;
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    /** @test */
    public function user_can_apply_for_loan()
    {
        $response = $this->actingAs($this->user, 'sanctum')->postJson('/api/loan/apply', [
            'amount' => 5000,
            'term' => 12,
            'interest_rate' => 5.5,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('loans', ['user_id' => $this->user->id, 'status' => 'pending']);
    }

    /** @test */
    public function user_can_fetch_own_loan_details()
    {
        
        $loan = Loan::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user, 'sanctum')->getJson("/api/loan/{$loan->id}");

        $response->assertStatus(200)
                 ->assertJson(['id' => $loan->id]);
    }

    /** @test */
    public function admin_can_approve_loan()
    {
        $loan = Loan::factory()->create(['status' => 'pending']);

        $response = $this->actingAs($this->admin, 'sanctum')->patchJson("/api/loan/{$loan->id}/approve");

        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('loans', ['id' => $loan->id, 'status' => 'approved']);
    }

    /** @test */
    public function user_can_make_repayment()
    {
        $loan = Loan::factory()->create(['user_id' => $this->user->id, 'status' => 'approved']);

        $due_date = Carbon::now()->addDays(random_int(1, 30))->format('Y-m-d');
        $response = $this->actingAs($this->user, 'sanctum')->postJson("/api/loan/{$loan->id}/repay", [
            'amount' => 500,
            'due_date' => $due_date
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('repayments', ['loan_id' => $loan->id, 'due_date' => $due_date, 'amount' => 500, 'status' => 'pending']);
    }
}
