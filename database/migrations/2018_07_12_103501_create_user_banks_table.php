<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Transaction\Models\UserBank;

class CreateUserBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function __construct(){

     $this->user_banks = (new UserBank())->getTable();


    }


    public function up()
    {
        Schema::create( $this->user_banks, function (Blueprint $table) {
            $table->increments('id');
            $table->string('bank_name',50);
            $table->bigInteger('account_number');
            $table->unsignedInteger('user_id');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->user_banks);
    }
}
