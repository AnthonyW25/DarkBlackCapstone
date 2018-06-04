<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['id', 'user_id', 'site_id', 'supplier', 'invoice', 'created_at', 'updated_at', 'date'];

    protected $_total = 0;
    protected $_gst = 0;
    protected $_pst = 0;


    protected $computed; // Have we loaded and calculated our computed properties, if so just return them, no need to hit db again

    public function items()
    {
        return $this->hasMany(ExpenseItem::class, 'expense_id', 'id');
    }

    public function gst()
    {
        $this->compute();

        return $this->_gst;
    }

    public function pst()
    {
        $this->compute();

        return $this->_pst;
    }

    public function total()
    {
        $this->compute();

        return $this->_total;
    }

    private function compute()
    {
        // Only do this once per request lifecycle
        if ($this->computed) {
            return true;
        }

        $this->load('items');

        foreach ($this->items as $item) {
            $this->_total += $item->amount;
            $this->_gst += $item->gst;
            $this->_pst += $item->pst;
        }

        $this->computed = true;
    }
}
