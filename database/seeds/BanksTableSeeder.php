<?php

use Illuminate\Database\Seeder;
use App\Bank;
class BanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Bank::create(['name'=>'KBZ']);
      Bank::create(['name'=>'AYA']);
      Bank::create(['name'=>'MAU']);
      Bank::create(['name'=>'CB']);
    }
}
