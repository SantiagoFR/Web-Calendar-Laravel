<?php

use App\Etiqueta;
use Illuminate\Database\Seeder;

class EtiquetasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Etiqueta::create(['name'=>'Sala de Grados','approval'=>1,'exclusive'=>1]);
        Etiqueta::create(['name'=>'Seminario','approval'=>0,'exclusive'=>1]);
        Etiqueta::create(['name'=>'Torneo LOL','approval'=>1,'exclusive'=>0]);
    }
}
