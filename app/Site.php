<?php
/**
 * Created by PhpStorm.
 * User: dirk
 * Date: 2018-05-23
 * Time: 10:18 AM
 */

namespace App;

use Illuminate\Support\Facades\DB;

class Site
{
    /*
     * In the complete system this would be an Eloquent Model class with records in the DB
     * We are just stubbing it out here for now
     */

    public $id = 1; // hard code an id that would normally reference the Site record in the DB

    public $sample_data = [];

    public function alcoholExpenses($from_date, $to_date)
    {
        return DB::table('expenses')
            ->join('expense_items', 'expenses.id', '=', 'expense_items.expense_id')
            ->whereBetween('date', [$from_date, $to_date])
            ->where('category', '=', 'Alcohol')
            ->sum('expense_items.amount');
    }

    public function alcoholSales($from_date, $to_date)
    {
        return Sale::where('site_id', $this->id)
            ->whereBetween('date', [$from_date, $to_date])
            ->sum('alcohol_sales');
    }

    public function foodExpenses($from_date, $to_date)
    {
        return DB::table('expenses')
            ->join('expense_items', 'expenses.id', '=', 'expense_items.expense_id')
            ->whereBetween('date', [$from_date, $to_date])
            ->where('category', '=', 'Food')
            ->sum('expense_items.amount');
    }

    public function foodSales($from_date, $to_date)
    {
        return Sale::where('site_id', $this->id)
            ->whereBetween('date', [$from_date, $to_date])
            ->sum('food_sales');
    }

    public function beverageExpenses($from_date, $to_date)
    {
        return DB::table('expenses')
            ->join('expense_items', 'expenses.id', '=', 'expense_items.expense_id')
            ->whereBetween('date', [$from_date, $to_date])
            ->where('category', '=', 'Beverage')
            ->sum('expense_items.amount');
    }

    public function beverageSales($from_date, $to_date)
    {
        return Sale::where('site_id', $this->id)
            ->whereBetween('date', [$from_date, $to_date])
            ->sum('alcohol_sales');
    }
}