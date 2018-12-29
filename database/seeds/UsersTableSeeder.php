<?php

use Illuminate\Database\Seeder;

use App\User;


 class UsersTableSeeder extends Seeder {
      /**
       * Run the database seeds.
       *
       * @return void
       */

  public function run() {

      $user_table = (new User())->getTable();;

      DB::table($user_table)->truncate();

      DB::table($user_table)->insert(array(
          array( 'password' => bcrypt('123456'),'username'=> 'cybooz', 'name'=> 'Cybooz',  'email' => 'info@cybooz.com'),
          array( 'password' => bcrypt('shilpa'),'username'=> 'shilpa', 'name'=> 'Shilpa',  'email' => 'shilpa@gmail.com'),
          array( 'password' => bcrypt('swetha'),'username'=> 'swetha', 'name'=> 'Swetha',  'email' => 'swetha@gmail.com'), 
      ));

      $this->command->info('User table succesfully seeded!');
  }

}
