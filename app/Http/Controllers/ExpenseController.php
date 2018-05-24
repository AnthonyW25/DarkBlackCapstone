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
        $this->validate($request, [
            'supplier' => 'Required',
            'invoice'  => 'Required']);

        Expense::create($request->all());

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
        return ExpenseItem::whereRaw('DATE(created_at) BETWEEN (NOW() - INTERVAL 28 DAY) AND NOW()')
            ->where('expense_id', '=', $id)
            ->sum('expense_items.amount');
    }

    //add cost of all food expenses
    public static function foodTotal()
    {
        return ExpenseItem::whereRaw('DATE(created_at) BETWEEN (NOW() - INTERVAL 28 DAY) AND NOW()')
            ->where('category', '=', 'Food')
            ->sum('expense_items.amount');

        /*
        What if I don't want 28 days? maybe 7, or 24, or 31
        The dates should be provided to the method so that it can be flexible and work for any time period
        */

        // Carbon is a great PHP class for working with dates and times that is included with Laravel.
        $from = Carbon::now()->subDay(28);
        $to = Carbon::now();

        // TODO: The Expense table needs a date column. You can't use created_at because a user may enter an expense dated last week
        /*
         * Instead of doing a db query for every category query the database once and flip through the records adding up all the categories
         * eg.
         */

        $totals = [];

        $expense_items = DB::table('expenses')
            ->join('expense_items', 'expenses.id', '=', 'expense_items.expense_id')
            ->select('expense_items.*')
            ->whereBetween('expenses.date', [$from->toDateString(), $to->toDateString()])
            ->get();

        foreach ($expense_items as $item) {
            if (isset($totals[$item->category])) {
                $totals[$item->category] += $item->amount;
            }
            else {
                $totals[$item->category] = $item->amount;
            }
        }

        // Now you have an array of totals by category and you only went to the db once
    }

    //add cost of all beverage expenses
    public static function beverageTotal()
    {
        return ExpenseItem::whereRaw('DATE(created_at) BETWEEN (NOW() - INTERVAL 28 DAY) AND NOW()')
            ->where('category', '=', 'Beverage')
            ->sum('expense_items.amount');
    }

    //add cost of all alcohol expenses
    public static function alcoholTotal()
    {
        return ExpenseItem::whereRaw('DATE(created_at) BETWEEN (NOW() - INTERVAL 28 DAY) AND NOW()')
            ->where('category', '=', 'Alcohol')
            ->sum('expense_items.amount');
    }

    public static function amountGst($id)
    {
        return ExpenseItem::whereRaw('DATE(created_at) BETWEEN (NOW() - INTERVAL 28 DAY) AND NOW()')
            ->where('expense_id', '=', $id)
            ->sum('expense_items.gst');
    }

    public static function amountPst($id)
    {
        return ExpenseItem::whereRaw('DATE(created_at) BETWEEN (NOW() - INTERVAL 28 DAY) AND NOW()')
            ->where('expense_id', '=', $id)
            ->sum('expense_items.pst');
    }

    public static function total_seven_days()
    {
        $total_food_expense = ExpenseItem::whereRaw('DATE(created_at) BETWEEN (NOW() - INTERVAL 7 DAY) AND NOW()')
            ->where('category', '=', 'Food')
            ->sum('expense_items.amount');

        $total_alcohol_expense = ExpenseItem::whereRaw('DATE(created_at) BETWEEN (NOW() - INTERVAL 7 DAY) AND NOW()')
            ->where('category', '=', 'Alcohol')
            ->sum('expense_items.amount');

        $total_beverage_expense = ExpenseItem::whereRaw('DATE(created_at) BETWEEN (NOW() - INTERVAL 7 DAY) AND NOW()')
            ->where('category', '=', 'Beverage')
            ->sum('expense_items.amount');

        $sales = Sale::whereRaw('DATE(created_at) BETWEEN (NOW() - INTERVAL 7 DAY) AND NOW()')->get();
        $total = array(0, 0, 0, 0);
        foreach ($sales as $sale) {
            $total[0] += $sale->food_sales;
            $total[1] += $sale->alcohol_sales;
            $total[2] += $sale->beverage_sales;
            $total[3] = $total[0] + $total[1] + $total[2];
        }

        $total[3] = $total[3] / 7;//seven day sale average; insert this into database
    }

    public static function total_twenty_eight_days()
    {
        $total_food_expense = ExpenseItem::whereRaw('DATE(created_at) BETWEEN (NOW() - INTERVAL 28 DAY) AND NOW()')
            ->where('category', '=', 'Food')
            ->sum('expense_items.amount');

        $total_alcohol_expense = ExpenseItem::whereRaw('DATE(created_at) BETWEEN (NOW() - INTERVAL 28 DAY) AND NOW()')
            ->where('category', '=', 'Alcohol')
            ->sum('expense_items.amount');

        $total_beverage_expense = ExpenseItem::whereRaw('DATE(created_at) BETWEEN (NOW() - INTERVAL 28 DAY) AND NOW()')
            ->where('category', '=', 'Beverage')
            ->sum('expense_items.amount');

        $sales = Sale::whereRaw('DATE(created_at) BETWEEN (NOW() - INTERVAL 28 DAY) AND NOW()')->get();
        $total = array(0, 0, 0, 0);
        foreach ($sales as $sale) {
            $total[0] += $sale->food_sales;
            $total[1] += $sale->alcohol_sales;
            $total[2] += $sale->beverage_sales;
            $total[3] = $total[0] + $total[1] + $total[2];
        }
        $total[0] = $total_food_expense / ($total[0] / 28) * 100;
        $total[1] = $total_alcohol_expense / ($total[1] / 28) * 100;
        $total[2] = $total_beverage_expense / ($total[2] / 28) * 100;
        $total[3] = $total[3] / 28;//28 day sale average; insert this into database

        return $total;
    }
}
