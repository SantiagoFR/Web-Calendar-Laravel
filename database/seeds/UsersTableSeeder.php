<?php

use App\Evento;
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
        \Illuminate\Support\Facades\DB::table('permiso_user')->truncate();
        $user=User::create(['name'=>'Administrador','username'=>'admin','email'=>'admin@tfg.com','password'=>Hash::make('admin')]);
        $user->permisos()->attach(1);
        factory(App\User::class, 50)->create();
    }
}
