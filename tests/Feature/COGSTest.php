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
        $cogs = new COGS(new Site());

        $this->assertClassHasAttribute('site', 'app\COGS');
    }

    /** @test */
    public function calculate()
    {
        // Setup some Sales Data
        $site = new Site();

        /*
         * Initially we will set up simple data that is the same every day
         * However, we should make this a more complex test later
         * Pull in real data or randomized sample data
         */
        $alcohol_sales = 200000; // $2,000
        $food_sales = 1000000; // $10,000
        for($i = 0; $i < 28; $i++) {
            $site->sample_data[] = [
                'food' => $food_sales,
                'alcohol' => $alcohol_sales
            ];
        }

        // Create an expense
        // TODO: We will need to setup an expense to test frequently, this could be extracted to a method in Test Case for reuse
        $expense = Expense::create([
            'date' => Carbon::now()->toDateString(), // TODO: The expense table needs a date column
            'supplier' => 'Test Supplier',
            'site_id' => $site->id,
            'user_id' => $this->user->id
            // other expense details
        ]);

        ExpenseItem::create([
            'expense_id' => $expense->id,
            'description' => 'Testing',
            'category' => 'Food',
            'amount' => '50000' // $500
        ]);

        // Should now be able to calculate COGS
        $cogs = new COGS($site);

        $cogs->calculate();

        $this->assertEquals(50000 / (28 * $food_sales), $cogs->twenty_eight_day_food);
        // Test all the food cogs
        // etc..

        // Add new Alcohol expense, recalculate cogs and test the values

    }
}
