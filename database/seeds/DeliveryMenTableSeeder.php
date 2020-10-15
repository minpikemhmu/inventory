<?php

use Illuminate\Database\Seeder;
use App\User;
use App\DeliveryMan;
use Illuminate\Support\Facades\Hash;

class DeliveryMenTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $user = new User;
      $user->name = 'Delivery Man';
      $user->email = 'deliveryman@gmail.com';
      $user->password = Hash::make('12345678');
      $user->save();

      $user->assignRole('delivery_man');

      $delivery_man = new DeliveryMan;
      $delivery_man->phone_no = '09-123456789';
      $delivery_man->address = 'Baho Street, Mayangone Township';
      $delivery_man->user_id = $user->id;
      $delivery_man->save();
    }
}
