<?php

namespace App\Modules\Transaction\Models;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class MoneyVoucher extends Model
{
    protected $table = 'money_voucher';

    public $timestamps = false;

    protected $dates = ['transaction_time'];

    public function setTransactionTimeAttribute($value)
    {
        $this->attributes['transaction_time'] = Carbon::parse($value);
    }
}
