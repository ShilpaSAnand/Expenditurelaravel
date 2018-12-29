<?php

use Illuminate\Database\Seeder;

use App\Modules\AccountHead\Models\AccountHead;

class AccountHeadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $account_head = (new AccountHead())->getTable();;

      	DB::table($account_head)->truncate();

        DB::table($account_head)->insert(array(
         
        array( 'category' => 'cash'), array( 'category' => 'bank'), array( 'category' => 'journal entry'), array( 'category' => 'job salary'),array( 'category' => 'house rent'), array( 'category' => 'bank intrest'), array( 'category' => 'shop rents'), array( 'category' => 'income from pets'), array( 'category' => 'mobile recharge'),array( 'category' => 'income from other source'),
      ));

      $this->command->info('Account table succesfully seeded!');
    }
}



  

