<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class loanApplicationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->visit('/apply/loan')
         ->select('Pension', 'nature_of_income')
         ->type(20000, 'monthly_income')
         ->select('yes', 'q1')
         ->type(3000, 'current_loan_emi')
         ->select('yes', 'q2')
         ->type(1000, 'education_expenses')
         ->select('yes', 'q3')
         ->type(7000, 'house_rent')
         ->select('yes', 'q4')
         ->select('Rent', 'other_earnings_type')
         ->type(800, 'other_earnings')
         ->type(5, 'number_of_dependants')
         ->type(200000, 'loan_required')
         ->type(7000, 'monthly_emi_possible')
         ->select(24, 'requested_tenure');
         
    }
}
