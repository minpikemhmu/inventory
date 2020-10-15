<?php

use Illuminate\Database\Seeder;
use App\City;
class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      City::create(['name'=>'Yangon']);
      City::create(['name'=>'Mandalay']);
      City::create(['name'=>'Naypyitaw']);
      City::create(['name'=>'Myitkyinar']);
      City::create(['name'=>'Taunggyi']);
      City::create(['name'=>'Monywa']);
    }
}
