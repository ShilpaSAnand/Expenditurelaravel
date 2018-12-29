<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Transaction\Models\BankTransactionMeta;

class CreateBankTransactionMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function __construct(){

     $this->bank_transaction_meta = (new BankTransactionMeta())->getTable();


    }

    public function up()
    {
        Schema::create($this->bank_transaction_meta, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('bank_id');
            $table->unsignedInteger('transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->bank_transaction_meta);
    }
}
