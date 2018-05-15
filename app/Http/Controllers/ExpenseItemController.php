<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\expense_item;

class ExpenseItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expense_items = expense_item::orderBy('updated_at','DESC')->get();
        return view('expense_item.index', compact('expense_items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('expense_item.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $expense_item = $request->all();
        expense_item::create($expense_item);
        return redirect('expenseitem');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $expense_item = expense_item::find($id);
        return view('expense_item.edit', compact('expense_item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $expense_item = expense_item::find($id);
        $expense_itemUpdate = $request->all();
        $expense_item->update($expense_itemUpdate);
        return redirect('expenseitem');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense_item = expense_item::find($id);
        $expense_item->delete();
        return redirect('expenseitem');
    }
}
