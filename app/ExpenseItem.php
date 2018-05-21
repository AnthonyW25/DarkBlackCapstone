<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseItem extends Model
{
    protected $fillable = ['expense_id', 'description', 'category', 'amount', 'gst', 'pst'];
}
