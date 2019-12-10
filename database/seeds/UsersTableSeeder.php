<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(['name'=>'Administrador','username'=>'admin','email'=>'admin@tfg.com','password'=>Hash::make('admin')]);
        factory(App\User::class, 50)->create();
    }
}
