<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Expense;
use App\ExpenseItem;
use App\Sale;
use Illuminate\Support\Facades\Auth;
use DB;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = Expense::with('items')
            ->orderBy('updated_at', 'DESC')
            ->get();

        $sales = Sale::orderBy('id', 'DESC')->get();
        return view('expense.index', compact('expenses', 'sales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('/expense.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_info = Auth::user();

        $this->validate($request, [
            'date' => 'Required',
            'supplier' => 'Required',
            'invoice'  => 'Required']);
        Expense::create($request->all() + ['user_id' => $user_info->id]);
       
        return redirect('/expense');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expense = Expense::find($id);

        // TODO: this should return a view
        return $expense;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $expense = Expense::find($id);

        return view('expense.edit', compact('expense'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'date' => 'Required',
            'supplier' => 'Required',
            'invoice'  => 'Required']);

        $expense = Expense::find($id);

        $expense->update($request->all());

        return redirect('expense');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Expense::destroy($id);
$this->site->id;
        ExpenseItem::where('expense_id', '=', $id)
            ->delete();

        return redirect('expense');
    }

    /*
     * Everything below this should be placed somewhere else
     * Most of what you are doing below is querying the db, a good indication that this doesn't belong in the controller
     * You are querying the ExpenseItem model, so these methods could go there
     * You could also create a separate class (like the COGS class) to house this logic
     */

    //add cost of all expenses
    public static function amountTotal($id)
    {
        return ExpenseItem::where('expense_id', '=', $id)
            ->sum('expense_items.amount');
    }

    //add cost of all food expenses
    public static function categoryTotal()
    {
        $days_ago = 28;

        $totals = [];
        
        $expense_items = DB::table('expenses')
            ->join('expense_items', 'expenses.id', '=', 'expense_items.expense_id')
            ->select('expense_items.*')
            ->whereRaw('DATE(date) BETWEEN (NOW() - INTERVAL '. $days_ago .' DAY) AND NOW()')
            ->get();

        foreach ($expense_items as $item) {
            if (isset($totals[$item->category])) {
                $totals[$item->category] += $item->amount;
            }
            else {
                $totals[$item->category] = $item->amount;
            }
        }
        return $totals;

        // Now you have an array of totals by category and you only went to the db once
    }


    public static function amountGst($id)
    {
        return ExpenseItem::where('expense_id', '=', $id)
            ->sum('expense_items.gst');
    }

    public static function amountPst($id)
    {
        return ExpenseItem::where('expense_id', '=', $id)
            ->sum('expense_items.pst');
    }

/*-------------------------------------- SEVEN DAY AVERAGE------------------------------------*/
    public static function total_seven_days()
    {
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

        $seven_day_sales = Sale::whereRaw('DATE(date) BETWEEN (NOW() - INTERVAL 7 DAY) AND NOW()')->get();
        $total = array(0, 0, 0, 0);
        foreach ($seven_day_sales as $sale) {
            $total[0] = $sale->food_sales;//individual food sale
            $total[1] = $sale->alcohol_sales;//individual alcohol sale
            $total[2] = $sale->beverage_sales;//individual beverage sale

            $total[3] += $sale->food_sales + $sale->alcohol_sales + $sale->beverage_sales;//full total
        }

        $total[3] = $total[3] / 7;//seven day sale average; insert this into database
        $sales = Sale::orderBy('id', 'desc')->first();
        DB::table('sales')->where('id', $sales->id)->update(['seven_day_average'=>$total[3]]);
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

         //net sale for that day
        $net_sales = 0;

        $sales = Sale::orderBy('id', 'desc')->first();
        
        $net_sales = $sales->food_sales + $sales->alcohol_sales + $sales->beverage_sales;
        
        DB::table('sales')->where('id', $sales->id)->update(['net'=>$net_sales]);

        //This is for calculating and storing the twenty-eight day average sales
        $twenty_eight_sales = Sale::whereRaw('DATE(date) BETWEEN (NOW() - INTERVAL 28 DAY) AND NOW()')->get();

        $total = array(0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($twenty_eight_sales as $sale) {
            $total[0] = $sale->food_sales;//individual food sale
            $total[1] = $sale->alcohol_sales;//individual alcohol sale
            $total[2] = $sale->beverage_sales;//individual beverage sale

            $total[3] += $sale->food_sales + $sale->alcohol_sales + $sale->beverage_sales;//full total

            $total[4] += $sale->food_sales;//full food total
            $total[5] += $sale->alcohol_sales;//full alcohol total
            $total[6] += $sale->beverage_sales;//full beverage total
        }
            
        if($total[4] == 0 or $total[5] == 0 or $total[6] == 0){
            return "Sales are empty";
        }
        else{
            $total[0] = ($total_food_expense / $total[4]) * 100;//COGS of food
            $total[1] = ($total_alcohol_expense / $total[5]) * 100;//COGS of alcohol
            $total[2] = ($total_beverage_expense / $total[6]) * 100;//COGS of beverage
            $total[7] = $total[3]/28;//the variable is now the twenty-eight day average of sales 

            DB::table('sales')->where('id', $sales->id)->update(['twenty_eight_day_average'=>$total[7]]);//storing twenty-eight day evg into the most recent sales(the one the user should be in)

            return $total; 
        }      
    }
}
