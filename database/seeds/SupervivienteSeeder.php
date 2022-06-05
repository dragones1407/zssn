<?php

use App\Superviviente;
use Illuminate\Database\Seeder;

class SupervivienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\Superviviente::class, 10)->create();
    }
}
