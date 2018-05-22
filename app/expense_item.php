<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class expense_item extends Model
{
    protected $fillable = ['id','expense_id','description','category','amount','gst','pst','created_at','updated_at'];
}
