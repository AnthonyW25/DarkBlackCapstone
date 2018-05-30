<?php
/**
 * Created by PhpStorm.
 * User: dirk
 * Date: 2018-05-23
 * Time: 10:06 AM
 */

namespace App;

use Carbon\Carbon;
use DB;
class COGS
{
    public $site;


    //  COGS
    public $seven_day_beverage;
    public $seven_day_food;
    public $seven_day_alcohol;
    public $seven_day_total;
    public $twenty_eight_day_beverage;
    public $twenty_eight_day_food;
    public $twenty_eight_day_alcohol;
    public $twenty_eight_day_total;


    /*
     * For any give site, which has daily sales and expenses
     * The COGS class will calculate the Food, Alcohol, and Total COGS for the previous 7 and 28 day periods
     */

    // TODO: Bring back the constructor. We want the site to provide the sales data
    // public function __construct(Site $site)
    // {
    //     $this->site = $site;
    // }

    
public static function total_seven_days()
    {
        // TODO: I've commented on this before, you are hitting the db 3 times here, it's inefficient. REFACTOR!

        // Instead do this. It's one db query and loads all sales categories, with an index that is descriptive instead of an arbitrary integer
        // What happens if you have 25 different sales categories, using your method you have to make 25 queries and 25 differnt loops
//        $totals = [];
//
//        $expense_items = DB::table('expenses')
//            ->join('expense_items', 'expenses.id', '=', 'expense_items.expense_id')
//            ->select('expense_items.*')
//            ->whereBetween('expenses.date', [$from->toDateString(), $to->toDateString()])
//            ->get();
//
//        foreach ($expense_items as $item) {
//            if (isset($totals[$item->category])) {
//                $totals[$item->category] += $item->amount;
//            }
//            else {
//                $totals[$item->category] = $item->amount;
//            }
//        }

        $total_food_expense = DB::table('expenses')
            ->join('expense_items', 'expenses.id', '=', 'expense_items.expense_id')
            ->select('expense_items.*')
            ->whereRaw('DATE(date) BETWEEN (NOW() - INTERVAL 7 DAY) AND NOW()')
            ->where('category', '=', 'Food')
            ->sum('expense_items.amount');

        $total_alcohol_expense = DB::table('expenses')
            ->join('expense_items', 'expenses.id', '=', 'expense_items.expense_id')
            ->select('expense_items.*')
            ->whereRaw('DATE(date) BETWEEN (NOW() - INTERVAL 7 DAY) AND NOW()')
            ->where('category', '=', 'Alcohol')
            ->sum('expense_items.amount');

        $total_beverage_expense = DB::table('expenses')
            ->join('expense_items', 'expenses.id', '=', 'expense_items.expense_id')
            ->select('expense_items.*')
            ->whereRaw('DATE(date) BETWEEN (NOW() - INTERVAL 7 DAY) AND NOW()')
            ->where('category', '=', 'Beverage')
            ->sum('expense_items.amount');


        //total expenses
        $total_expenses = $total_food_expense + $total_alcohol_expense + $total_beverage_expense;

        // The COGS class is responsible for calculating COGS, not fetching sales data
        // Move all this into the Site model
        // Should be able to pull this by $site->foodSales($seven_days_ago, $now)

        $seven_day_sales = Sale::whereRaw('DATE(date) BETWEEN (NOW() - INTERVAL 7 DAY) AND NOW()')->get();
        $total = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($seven_day_sales as $sale) {

            // These 3 lines don't do anything! You just overwrite these values below
            $total[0] = $sale->food_sales;//individual food sale
            $total[1] = $sale->alcohol_sales;//individual alcohol sale
            $total[2] = $sale->beverage_sales;//individual beverage sale

            $total[3] += $sale->food_sales + $sale->alcohol_sales + $sale->beverage_sales;//full total

            $total[4] += $sale->food_sales;//full food total
            $total[5] += $sale->alcohol_sales;//full alcohol total
            $total[6] += $sale->beverage_sales;//full beverage total
        }

        // These are arbitrary indices. How is anyone supposed to know that food COGS are index 1?
        // Instead load the public properties of this class that have readable names eg. $this->seven_day_food

        $total[0] = ($total_food_expense / $total[4]) * 100;//COGS of food
        $total[1] = ($total_alcohol_expense / $total[5]) * 100;//COGS of alcohol
        $total[2] = ($total_beverage_expense / $total[6]) * 100;//COGS of beverage

        $total[8] = ($total_expenses / $total[3]) * 100; //COGS of everything

        $total[7] = $total[3] / 7;//seven day sale average; insert this into database
        $sales = Sale::orderBy('id', 'desc')->first();
        DB::table('sales')->where('id', $sales->id)->update(['seven_day_average'=>$total[7]]);

        //Expenses totals
        $total[9] = $total_food_expense; //total food expenses
        $total[10] = $total_alcohol_expense; //total alcohol expenses
        $total[11] = $total_beverage_expense; //total beverage expenses
        return $total;
    }



/*-------------------------------------- TWENTY EIGHT DAY AVERAGE------------------------------------*/
    //this function stores the tenty-eight day average as well as the net total for that day
    public static function total_twenty_eight_days()
    {
        $total_food_expense =  DB::table('expenses')
            ->join('expense_items', 'expenses.id', '=', 'expense_items.expense_id')
            ->select('expense_items.*')
            ->whereRaw('DATE(date) BETWEEN (NOW() - INTERVAL 28 DAY) AND NOW()')
            ->where('category', '=', 'Food')
            ->sum('expense_items.amount');

        $total_alcohol_expense = DB::table('expenses')
            ->join('expense_items', 'expenses.id', '=', 'expense_items.expense_id')
            ->select('expense_items.*')
            ->whereRaw('DATE(date) BETWEEN (NOW() - INTERVAL 28 DAY) AND NOW()')
            ->where('category', '=', 'Alcohol')
            ->sum('expense_items.amount');

        $total_beverage_expense = DB::table('expenses')
            ->join('expense_items', 'expenses.id', '=', 'expense_items.expense_id')
            ->select('expense_items.*')
            ->whereRaw('DATE(date) BETWEEN (NOW() - INTERVAL 28 DAY) AND NOW()')
            ->where('category', '=', 'Beverage')
            ->sum('expense_items.amount');

        //total expenses
        $total_expenses = $total_food_expense + $total_alcohol_expense + $total_beverage_expense;

         //net sale for that day
        $net_sales = 0;

        $sales = Sale::orderBy('id', 'desc')->first();
        
        $net_sales = $sales->food_sales + $sales->alcohol_sales + $sales->beverage_sales;
        
        DB::table('sales')->where('id', $sales->id)->update(['net'=>$net_sales]);

        //This is for calculating and storing the twenty-eight day average sales
        $twenty_eight_sales = Sale::whereRaw('DATE(date) BETWEEN (NOW() - INTERVAL 28 DAY) AND NOW()')->get();

        $total = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($twenty_eight_sales as $sale) {
            $total[0] = $sale->food_sales;//individual food sale
            $total[1] = $sale->alcohol_sales;//individual alcohol sale
            $total[2] = $sale->beverage_sales;//individual beverage sale

            $total[3] += $sale->food_sales + $sale->alcohol_sales + $sale->beverage_sales;//full sales total

            $total[4] += $sale->food_sales;//full food sale total
            $total[5] += $sale->alcohol_sales;//full alcohol sale total
            $total[6] += $sale->beverage_sales;//full beverage sale total
            
        }
            
        if($total[4] == 0 or $total[5] == 0 or $total[6] == 0){
            return "Sales are empty";
        }
        else{
            $total[0] = ($total_food_expense / $total[4]) * 100;//COGS of food
            $total[1] = ($total_alcohol_expense / $total[5]) * 100;//COGS of alcohol
            $total[2] = ($total_beverage_expense / $total[6]) * 100;//COGS of beverage

            $total[7] = $total[3]/28;//the variable is now the twenty-eight day average of sales 
            $total[8] = ($total_expenses / $total[3]) * 100; //COGS of everything

            DB::table('sales')->where('id', $sales->id)->update(['twenty_eight_day_average'=>$total[7]]);//storing twenty-eight day evg into the most recent sales(the one the user should be in)

            $total[9] = $total_food_expense; //total food expenses
            $total[10] = $total_alcohol_expense; //total alcohol expenses
            $total[11] = $total_beverage_expense; //total beverage expenses

            return $total; 
        }      
    }
}