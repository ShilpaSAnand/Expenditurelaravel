<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use App\Modules\Transaction\Models\MoneyTransaction;


class CreateMoneyTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function __construct(){

     $this->money_transaction = (new MoneyTransaction())->getTable();


    }

    public function up()
    {
        Schema::create( $this->money_transaction , function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('voucher_id');
            $table->bigInteger('amount');
            $table->bigInteger('from_account_head');
            $table->bigInteger('to_account_head');
            $table->unsignedInteger('created_by');
            $table->longText('narration')->nullable();


            // $table->timestamps();
        });
    }


    public function down()
    {
       Schema::dropIfExists($this->money_transaction);
    }
}
