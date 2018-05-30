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

    /**s
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

    
    //--------------------------------item controller--------------------------------------------------------------------------
     public function itemIndex(Request $request)
    {
        $expense_id = $request->get('expense_id');

        $expense_items = ExpenseItem::orderBy('updated_at','DESC')
            ->where('expense_id', '=', $expense_id)->orderBy('updated_at','DESC')
            ->get();

        return view('expense_item.index', compact('expense_items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function itemCreate()
    {
        return view('expense_item.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function itemStore(Request $request)
    {   
        $this->validate($request, [
            'description'=>'Required',
            'category'=>'Required']);
        $expense_item = $request->all();
        ExpenseItem::create($expense_item);
        return redirect('expenseitem');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function itemShow($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function itemEdit($id)
    {
        $expense_item = ExpenseItem::find($id);
        return view('expense_item.edit', compact('expense_item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function itemUpdate(Request $request, $id)
    {   
        $this->validate($request, [
            'description'=>'Required',
            'category'=>'Required']);
        $expense_item = ExpenseItem::find($id);
        $expense_itemUpdate = $request->all();
        $expense_item->update($expense_itemUpdate);
        return redirect('expense');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function itemDestroy($id)
    {
        $expense_item = ExpenseItem::find($id);
        $expense_item->delete();
        return redirect('expenseitem');
        
    }
    
//---------------------------------------end item controller----------------------------------------------------------
    

    //add cost of all expenses
    public static function amountTotal($id)
    {
        return ExpenseItem::where('expense_id', '=', $id)
            ->sum('expense_items.amount');
    }

    //add cost of all food expenses
    public static function categoryTotal($from_date, $to_date)
    {
        $expense_holder = [];//holds all expenses


        $expense_items = DB::table('expenses')
            ->join('expense_items', 'expenses.id', '=', 'expense_items.expense_id')
            ->select('expense_items.*')
            ->whereBetween('date', array($from_date, $to_date))
            ->get();

        foreach ($expense_items as $item) {
            if (isset($expense_holder[$item->category])) {
                $expense_holder[$item->category] += $item->amount;
            }
            else {
                $expense_holder[$item->category] = $item->amount;
            }
        }

        return $expense_holder;
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
    
}
