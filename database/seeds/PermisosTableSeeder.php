<?php

use App\Permiso;
use Illuminate\Database\Seeder;

class PermisosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permiso::create(['nombre'=>'profesor']);
        Permiso::create(['nombre'=>'alumno']);
        Permiso::create(['nombre'=>'administracion']);
    }
}
