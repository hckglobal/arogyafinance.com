<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class cardApplicationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCardApplicationForm()
    {
         $this->visit('/apply/card')
         ->type('first name', 'first_name')
         ->type('middle name', 'middle_name')
         ->type('last name', 'last_name')
         ->select('1','birthday_day')
         ->select('1','birthday_month')
         ->select('1990','birthday_year')
         ->select('Male','gender')
         ->select('9876543210','mobile_number')
         ->select('test@email.com','email')
         ->select('PAN Card','id_proof_type')
         ->select('1234','id_proof_number')
         ->select('Owned','residence_type')
         ->type('add1','address1')
         ->type('add2','address2')
         ->select('Jammu and Kashmir','state')
         ->type('city','city')
         ->type('1234','pincode')
         ->press('Apply')
         ->seePageIs('/dashboard');
    }
}
