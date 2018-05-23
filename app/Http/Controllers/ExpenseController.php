<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expense;
use App\ExpenseItem;
use App\Sale;
use Illuminate\Support\Facades\Auth;


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

        $expense->update($request->all());//Original:$expense->update($request->all());

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

    public static function amountTotal($id){
    	$expense = Expense::find($id);
        $expense_item = ExpenseItem::where('expense_id', '=', $id)->sum('expense_items.amount');
        return $expense_item;
    }


    public static function foodTotal($id){
        $expense = Expense::find($id);
        $expense_item = ExpenseItem::where('expense_id', '=', $id)->where('category', '=', 'Food' )->sum('expense_items.amount');
        return $expense_item;
    }

    public static function beverageTotal($id){
        $expense = Expense::find($id);
        $expense_item = ExpenseItem::where('expense_id', '=', $id)->where('category', '=', 'Beverage' )->sum('expense_items.amount');
        return $expense_item;
    }


    public static function alcoholTotal($id){
        $expense = Expense::find($id);
        $expense_item = ExpenseItem::where('expense_id', '=', $id)->where('category', '=', 'Alcohol' )->sum('expense_items.amount');
        return $expense_item;
    }


     public static function amountGst($id){
    	$expense = Expense::find($id);
        $expense_item = ExpenseItem::where('expense_id', '=', $id)->sum('expense_items.gst');
        return $expense_item;
    }

     public static function amountPst($id){
    	$expense = Expense::find($id);
        $expense_item = ExpenseItem::where('expense_id', '=', $id)->sum('expense_items.pst');
        return $expense_item;
    }

    public static function total_seven_days($id){
        $sales = Sale::find($id);
    }
}
