<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class client extends Model
{
    public function total_credit(){
        return $this->belongsTo(transaction::class,'to','id')
                    ->where('transaction_type','credit')
                    ->sum('amount');
    }
}
