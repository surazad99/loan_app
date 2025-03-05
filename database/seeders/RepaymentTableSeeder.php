<?php

namespace Database\Seeders;

use App\Models\Loan;
use App\Models\Repayment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RepaymentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $loans = Loan::get();

        foreach($loans as $loan){
            Repayment::factory(2)->create(['loan_id' => $loan->id]);
        }
    }
}
