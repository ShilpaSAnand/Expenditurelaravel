<?php

use Illuminate\Database\Seeder;

use App\Modules\Transaction\Models\UserBank;

class UserBanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $user_banks = (new UserBank())->getTable();;

      	DB::table($user_banks)->truncate();

        DB::table($user_banks)->insert(array(
         
        array( 'bank_name' => 'Axis Bank', 'account_number' =>'10001', 'user_id' => '1'),
        array( 'bank_name' => 'SBI', 'account_number' =>'10002', 'user_id' => '1'),
        array( 'bank_name' => 'Canara', 'account_number' =>'15463', 'user_id' => '1'),
        array( 'bank_name' => 'SBI', 'account_number' =>'7878877', 'user_id' => '2'),
        array( 'bank_name' => 'Union Bank Of India', 'account_number' =>'123456789', 'user_id' => '2'),
        array( 'bank_name' => 'Axis Bank', 'account_number' =>'4545454545', 'user_id' => '2'),
        array( 'bank_name' => 'SBI', 'account_number' =>'454545454', 'user_id' => '3'),
        array( 'bank_name' => 'Canara', 'account_number' =>'4747496', 'user_id' => '3'),
      ));

      $this->command->info('Account table succesfully seeded!');
    
    }
}
