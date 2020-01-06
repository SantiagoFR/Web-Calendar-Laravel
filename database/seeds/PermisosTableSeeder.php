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
        Permiso::truncate();
        Permiso::create(['nombre'=>'Admin']);
        Permiso::create(['nombre'=>'Profesor']);
        Permiso::create(['nombre'=>'Alumno']);
        Permiso::create(['nombre'=>'Administracion']);
    }
}
