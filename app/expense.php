<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class expense extends Model
{
     protected $fillable = ['id','user_id','site_id','supplier','invoice','created_at','updated_at'];
}
