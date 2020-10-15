<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Client;
use Illuminate\Support\Facades\Hash;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $user = new User;
      $user->name = 'Client';
      $user->email = 'client@gmail.com';
      $user->password = Hash::make('12345678');
      $user->save();

      $user->assignRole('client');

      $client = new Client;
      $client->contact_person = 'Ma Su';
      $client->phone_no = '09-123456789';
      $client->address = 'Baho Street, Mayangone Township';
      $client->codeno = '001';
      $client->user_id = $user->id;
      $client->township_id = 1;
      $client->save();
    }
}
