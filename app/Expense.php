<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
     protected $fillable = ['id','user_id','site_id','supplier','invoice','created_at','updated_at'];

     public function items()
     {
         return $this->hasMany(ExpenseItem::class, 'expense_id', 'id');
     }
}
