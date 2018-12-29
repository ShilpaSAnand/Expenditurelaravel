<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use App\Modules\AccountHead\Models\AccountHead;

class CreateAccountHeadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function __construct(){

         $this->account_head = (new AccountHead())->getTable();


    }

    public function up()
    {
        Schema::create(  $this->account_head , function (Blueprint $table) {
            $table->increments('id');
            $table->string('category',30);
            $table->tinyInteger('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->account_head);
    }
}
