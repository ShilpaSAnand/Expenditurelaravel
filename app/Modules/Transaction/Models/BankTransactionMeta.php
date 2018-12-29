<?php

namespace App\Modules\Transaction\Models;

use Illuminate\Database\Eloquent\Model;

class BankTransactionMeta extends Model
{
    protected $table = 'bank_transaction_meta';

    public $timestamps = false;
}
