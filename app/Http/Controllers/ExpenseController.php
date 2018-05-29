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
    
}
