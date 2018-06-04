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

        $cogs = new COGS($site);

        $twenty_eight_days_ago = Carbon::now()->subDay(28);
        $seven_days_ago = Carbon::now()->subDay(7);
        $now = Carbon::now();

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

        $cogs->calculate();
        $this->assertEquals((50000 / $site->foodSales($seven_days_ago->toDateString(), $now->toDateString())) * 100, $cogs->seven_day_food);
        $this->assertEquals((50000 / $site->foodSales($twenty_eight_days_ago->toDateString(), $now->toDateString())) * 100, $cogs->twenty_eight_day_food);
        $this->assertEquals(0, $cogs->seven_day_alcohol);
        $this->assertEquals(0, $cogs->twenty_eight_day_alcohol);

        // Add new Alcohol expense, recalculate cogs and test the values
        ExpenseItem::create([
            'expense_id' => $expense->id,
            'description' => 'Testing Alcohol',
            'category' => 'Alcohol',
            'amount' => '123400', // $1234
            'gst' => '50000', // $500
            'pst' => '25000' // $250
        ]);

        // Should now be able to calculate COGS
        $cogs->calculate();

        $this->assertEquals((50000 / $site->foodSales($seven_days_ago->toDateString(), $now->toDateString())) * 100, $cogs->seven_day_food);
        $this->assertEquals((50000 / $site->foodSales($twenty_eight_days_ago->toDateString(), $now->toDateString())) * 100, $cogs->twenty_eight_day_food);
        $this->assertEquals((123400 / $site->alcoholSales($seven_days_ago->toDateString(), $now->toDateString())) * 100, $cogs->seven_day_alcohol);
        $this->assertEquals((123400 / $site->alcoholSales($twenty_eight_days_ago->toDateString(), $now->toDateString())) * 100, $cogs->twenty_eight_day_alcohol);

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
        $cogs->calculate();

        $this->assertEquals((50000 / $site->foodSales($seven_days_ago->toDateString(), $now->toDateString())) * 100, $cogs->seven_day_food);
        $this->assertEquals(((50000 + 234500) / $site->foodSales($twenty_eight_days_ago->toDateString(), $now->toDateString())) * 100, $cogs->twenty_eight_day_food);
        $this->assertEquals((123400 / $site->alcoholSales($seven_days_ago->toDateString(), $now->toDateString()))*100, $cogs->seven_day_alcohol);
        $this->assertEquals(((123400 + 32100) / $site->alcoholSales($twenty_eight_days_ago->toDateString(), $now->toDateString())) * 100, $cogs->twenty_eight_day_alcohol);
    }
}