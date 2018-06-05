<?php

namespace Tests\Feature;

use App\Budget;
use App\Exceptions\DarkBlackException;
use App\Forecast;
use App\Site;
use Tests\TestCase;

class BudgetTest extends TestCase
{
    /** @test */
    public function it_exists()
    {
        $site = new Site();

        $forecast = new Forecast($site);

        $budget = new Budget($forecast);

        // If my forecast sales is S, and my COGS target is Y%, then my spending budget = S x Y

        $this->assertClassHasAttribute('forecast', 'app\Budget');
        $this->assertClassHasAttribute('cogs_target', 'app\Budget');
        $this->assertClassHasAttribute('weekly_food', 'app\Budget'); // weekly spending budget
        $this->assertClassHasAttribute('weekly_alcohol', 'app\Budget'); // weekly spending budget
        $this->assertClassHasAttribute('weekly_beverage', 'app\Budget'); // weekly spending budget
    }

    /** @test */
    public function must_set_a_cogs_target()
    {
        $site = new Site();

        $forecast = new Forecast($site);

        $budget = new Budget($forecast);

        $this->expectException(DarkBlackException::class);

        // If we try get the cogs_target without setting the value first, we should get an exception
        $budget->cogsTarget();
    }

    /** @test */
    public function can_set_cogs_target()
    {
        $site = new Site();

        $forecast = new Forecast($site);

        $budget = new Budget($forecast);

        $target = 33;

        // Can set a target, if we do not pass in a category the target applies to all categories
        $budget->cogsTarget($target);

        $this->assertEquals($target, $budget->cogsTarget($target));
        $this->assertEquals($target, $budget->cogsCategoryTarget('Food'));
        $this->assertEquals($target, $budget->cogsCategoryTarget('Alcohol'));
    }

    /** @test */
    public function can_set_cogs_target_by_category()
    {
        $site = new Site();

        $forecast = new Forecast($site);

        $budget = new Budget($forecast);

        $general_target = 33;
        $food_target = 22;

        $budget->cogsTarget($general_target);

        // Can set a target of a specific category
        $budget->cogsTarget($food_target, 'Food');

        $this->assertEquals($food_target, $budget->cogsCategoryTarget('Food'));

        // Any other category should report the default
        $this->assertEquals($general_target, $budget->cogsCategoryTarget('Alcohol'));
        $this->assertEquals($general_target, $budget->cogsCategoryTarget('SomeOtherCategory'));
    }

    /** @test */
    public function cogs_target_has_one_decimal_place()
    {
        $site = new Site();

        $forecast = new Forecast($site);

        $budget = new Budget($forecast);

        // one decimal is fine
        $budget->cogsTarget(33.1);

        $this->assertEquals(33.1, $budget->cogsCategoryTarget('Food'));

        // two decimals gets rounded to one
        $result = $budget->cogsTarget(33.13); //I added this result variable since the original cogsTarget call was always throwing a null exception

        $this->assertEquals(33.1, $result); //Now checking to see if == result calculated above
        $this->assertEquals(33.1, $budget->cogsCategoryTarget('Food'));
    }

    /** @test */
    public function provides_budget_by_category()
    {
        $site = new Site();

        $forecast = new Forecast($site);

        $budget = new Budget($forecast);

        foreach (['Alcohol', 'Beverage', 'Food'] as $category) {

            $property_name = 'weekly_' . strtolower($category);

            // Assign a random cogs target
            $cogs_target = rand(200, 400) / 10;
            $budget->cogsTarget($cogs_target, $category);

            $this->assertEquals($cogs_target * $forecast->sevenDay($category) / 100, $budget->byCategory($category));
            $this->assertEquals($cogs_target * $forecast->sevenDay($category) / 100, $budget->$property_name);
        }
    }

    /** @test */
    public function provides_total_budget()
    {
        $site = new Site();

        $forecast = new Forecast($site);

        $budget = new Budget($forecast);

        $target = 22.4;

        $total = $budget->cogsTarget($target);

        $this->assertEquals($target * $forecast->seven_day / 100, $total / 100);
    }

}
