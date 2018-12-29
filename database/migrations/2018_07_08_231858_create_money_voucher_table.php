<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use App\Modules\Transaction\Models\MoneyVoucher;

class CreateMoneyVoucherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function __construct(){

         $this->money_voucher = (new MoneyVoucher())->getTable();


    }

    public function up()
    {
        Schema::create( $this->money_voucher , function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('status')->default(1);
            $table->dateTime('transaction_time');
            $table->dateTime('created_on');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->money_voucher);
    }
}
