<?php

use App\Etiqueta;
use App\Evento;
use App\Permiso;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Permiso::truncate();
        Etiqueta::truncate();
        User::truncate();
        Evento::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $this->call(PermisosTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(EtiquetasTableSeeder::class);
    }
}
