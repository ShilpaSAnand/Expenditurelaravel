<?php

namespace App\Modules\Transaction\Models;

use Illuminate\Database\Eloquent\Model;

class MoneyTransaction extends Model
{
    protected $table = 'money_transaction';

    public $timestamps = false;
}
