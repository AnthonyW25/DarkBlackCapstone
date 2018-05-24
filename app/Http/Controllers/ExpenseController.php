<?php

namespace App\Http\Controllers;

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
        // We have access to the Expense Items via a relationship we setup in the Expense model
        // Fetch the items with the expense
        $expenses = Expense::with('items')
            ->orderBy('updated_at', 'DESC')
            ->get();

        $sales = Sale::orderBy('id','DESC')->get();
        return view('expense.index', compact('expenses', 'sales'));

        //access user stuff
        //Auth::user();
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
        //dd(Auth::user());

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
        $expense = Expense::find($id);
        $expenseItem = ExpenseItem::where('expense_id', '=', $id);
        $expenseItem->delete();
        $expense->delete();

        return redirect('expense');
    }

    //add cost of all expenses
    public static function amountTotal($id){
    	$expense = Expense::find($id);
        $expense_item = ExpenseItem::whereRaw('DATE(created_at) BETWEEN (NOW() - INTERVAL 28 DAY) AND NOW()')->where('expense_id', '=', $id)->sum('expense_items.amount');
        return $expense_item;
    }

    //add cost of all food expenses
    public static function foodTotal(){
        $expense_item = ExpenseItem::whereRaw('DATE(created_at) BETWEEN (NOW() - INTERVAL 28 DAY) AND NOW()')->where('category', '=', 'Food' )->sum('expense_items.amount');
        return $expense_item;
    }

    //add cost of all beverage expenses
    public static function beverageTotal(){
        
        $expense_item = ExpenseItem::whereRaw('DATE(created_at) BETWEEN (NOW() - INTERVAL 28 DAY) AND NOW()')->where('category', '=', 'Beverage' )->sum('expense_items.amount');
        return $expense_item;
    }

    //add cost of all alcohol expenses
    public static function alcoholTotal(){
        
        $expense_item = ExpenseItem::whereRaw('DATE(created_at) BETWEEN (NOW() - INTERVAL 28 DAY) AND NOW()')->where('category', '=', 'Alcohol' )->sum('expense_items.amount');
        return $expense_item;
    }


     public static function amountGst($id){
    	$expense = Expense::find($id);
        $expense_item = ExpenseItem::whereRaw('DATE(created_at) BETWEEN (NOW() - INTERVAL 28 DAY) AND NOW()')->where('expense_id', '=', $id)->sum('expense_items.gst');
        return $expense_item;
    }

     public static function amountPst($id){
    	$expense = Expense::find($id);
        $expense_item = ExpenseItem::whereRaw('DATE(created_at) BETWEEN (NOW() - INTERVAL 28 DAY) AND NOW()')->where('expense_id', '=', $id)->sum('expense_items.pst');
        return $expense_item;
    }

    public static function total_seven_days(){

        $total_food_expense = ExpenseItem::whereRaw('DATE(created_at) BETWEEN (NOW() - INTERVAL 7 DAY) AND NOW()')->where('category', '=', 'Food' )->sum('expense_items.amount');
        $total_alcohol_expense = ExpenseItem::whereRaw('DATE(created_at) BETWEEN (NOW() - INTERVAL 7 DAY) AND NOW()')->where('category', '=', 'Alcohol' )->sum('expense_items.amount');
        $total_beverage_expense = ExpenseItem::whereRaw('DATE(created_at) BETWEEN (NOW() - INTERVAL 7 DAY) AND NOW()')->where('category', '=', 'Beverage' )->sum('expense_items.amount');

        $sales = Sale::whereRaw('DATE(created_at) BETWEEN (NOW() - INTERVAL 7 DAY) AND NOW()')->get();
        $total = array(0, 0, 0, 0);
        foreach($sales as $sale){
            $total[0] += $sale->food_sales;
            $total[1] += $sale->alcohol_sales;
            $total[2] += $sale->beverage_sales;
            $total[3] = $total[0] + $total[1] + $total[2];
        }
        
        $total[3] = $total[3]/7;//seven day sale average; insert this into database

    }

    public static function total_twenty_eight_days(){

        $total_food_expense = ExpenseItem::whereRaw('DATE(created_at) BETWEEN (NOW() - INTERVAL 28 DAY) AND NOW()')->where('category', '=', 'Food' )->sum('expense_items.amount');
        $total_alcohol_expense = ExpenseItem::whereRaw('DATE(created_at) BETWEEN (NOW() - INTERVAL 28 DAY) AND NOW()')->where('category', '=', 'Alcohol' )->sum('expense_items.amount');
        $total_beverage_expense = ExpenseItem::whereRaw('DATE(created_at) BETWEEN (NOW() - INTERVAL 28 DAY) AND NOW()')->where('category', '=', 'Beverage' )->sum('expense_items.amount');

        $sales = Sale::whereRaw('DATE(created_at) BETWEEN (NOW() - INTERVAL 28 DAY) AND NOW()')->get();
        $total = array(0, 0, 0, 0);
        foreach($sales as $sale){
            $total[0] += $sale->food_sales;
            $total[1] += $sale->alcohol_sales;
            $total[2] += $sale->beverage_sales;
            $total[3] = $total[0] + $total[1] + $total[2];
        }
        $total[0] = $total_food_expense/($total[0]/28) * 100;
        $total[1] = $total_alcohol_expense/($total[1]/28) * 100;
        $total[2] = $total_beverage_expense/($total[2]/28) * 100;
        $total[3] = $total[3]/28;//28 day sale average; insert this into database
        return $total;
    }
}
