<?php

namespace Tests\Feature;

use App\COGS;
use App\Expense;
use App\ExpenseItem;
use App\Site;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class COGSTest extends TestCase
{
    /** @test */
    public function it_exists()
    {
        $cogs = new COGS();

        $this->assertClassHasAttribute('site', 'app\COGS');
        $this->assertClassHasAttribute('seven_day_food', 'app\COGS');
        $this->assertClassHasAttribute('seven_day_food', 'app\COGS');
        $this->assertClassHasAttribute('seven_day_beverage', 'app\COGS');
        $this->assertClassHasAttribute('seven_day_food', 'app\COGS');
        $this->assertClassHasAttribute('seven_day_alcohol', 'app\COGS');
        $this->assertClassHasAttribute('seven_day_total', 'app\COGS');
        $this->assertClassHasAttribute('twenty_eight_day_beverage', 'app\COGS');
        $this->assertClassHasAttribute('twenty_eight_day_food', 'app\COGS');
        $this->assertClassHasAttribute('twenty_eight_day_alcohol', 'app\COGS');
        $this->assertClassHasAttribute('twenty_eight_day_total', 'app\COGS');
        
    }

    /** @test */
    public function calculate()
    {
        // Setup some Sales Data
        $site = new Site();

        $cogs = new COGS();

        // TODO: We will need to setup an expense to test frequently, this could be extracted to a method in Test Case for reuse
        $expense = Expense::create([
            'date' => Carbon::now()->toDateString(),
            'supplier' => 'Test Supplier',
            'site_id' => $site->id,
            'user_id' => $this->user->id,
            'invoice' => 'Test Invoice'
        ]);

        ExpenseItem::create([
            'expense_id' => $expense->id,
            'description' => 'Testing Food',
            'category' => 'Food',
            'amount' => '50000', // $500
            'gst' => '5000', // $50
            'pst' => '2500' // $25
        ]);

        // Should now be able to calculate COGS
        $seven_days_stuff = $cogs->total_seven_days();
        $twenty_eight_days_stuff = $cogs->total_twenty_eight_days();
        
        $this->assertEquals((50000 / $seven_days_stuff[4])*100, $seven_days_stuff[0]);
        $this->assertEquals((50000 / $twenty_eight_days_stuff[4])*100, $twenty_eight_days_stuff[0]);
        $this->assertEquals(0, $seven_days_stuff[10]);
        $this->assertEquals(0, $twenty_eight_days_stuff[10]);

        // Add new Alcohol expense, recalculate cogs and test the values
        ExpenseItem::create([
            'expense_id' => $expense->id,
            'description' => 'Testing Alcohol',
            'category' => 'Alcohol',
            'amount' => '123400', // $1234
            'gst' => '50000', // $500
            'pst' => '25000' // $250
        ]);

        //Should now be able to calculate COGS
        $seven_days_stuff = $cogs->total_seven_days();
        $twenty_eight_days_stuff = $cogs->total_twenty_eight_days();

        $this->assertEquals((50000 / $seven_days_stuff[4])*100, $seven_days_stuff[0]);
        $this->assertEquals((50000 / $twenty_eight_days_stuff[4])*100, $twenty_eight_days_stuff[0]);
        $this->assertEquals((123400 / $seven_days_stuff[5]) * 100, $seven_days_stuff[1]);
        $this->assertEquals((123400 / $twenty_eight_days_stuff[5])*100, $twenty_eight_days_stuff[1]);

        // Add an expense dated more than 7 days ago, so that it should only affect the 28 day numbers
        $expense = Expense::create([
            'date' => Carbon::now()->subDay(20)->toDateString(),
            'supplier' => 'Test Supplier',
            'site_id' => $site->id,
            'user_id' => $this->user->id,
            'invoice' => 'Test Invoice'
            // other expense details
        ]);

        ExpenseItem::create([
            'expense_id' => $expense->id,
            'description' => '20 day old invoice',
            'category' => 'Food',
            'amount' => '234500', // $2345
            'gst' => '5000', // $50
            'pst' => '2500' // $25
        ]);

        ExpenseItem::create([
            'expense_id' => $expense->id,
            'description' => 'Testing Alcohol',
            'category' => 'Alcohol',
            'amount' => '32100', // $321
            'gst' => '50000', // $500
            'pst' => '25000' // $250
        ]);

        // Should now be able to calculate COGS
         $seven_days_stuff = $cogs->total_seven_days();
        $twenty_eight_days_stuff = $cogs->total_twenty_eight_days();

        $this->assertEquals((50000 / $seven_days_stuff[4])*100, $seven_days_stuff[0]);
        $this->assertEquals(((50000 + 234500) / $twenty_eight_days_stuff[4])*100, $twenty_eight_days_stuff[0]);
        $this->assertEquals((123400 / $seven_days_stuff[5]) * 100, $seven_days_stuff[1]);
        $this->assertEquals(((123400 + 32100) / $twenty_eight_days_stuff[5])*100, $twenty_eight_days_stuff[1]);
    }
}
