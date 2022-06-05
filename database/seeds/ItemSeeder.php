<?php
use App\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Item::create([
            'descripcion' => 'Agua',
            'puntos' => 4
        ]);
        Item::create([
            'descripcion' => 'Comida',
            'puntos' => 3
        ]);
        Item::create([
            'descripcion' => 'Medicamento',
            'puntos' => 2
        ]);
        Item::create([
            'descripcion' => 'Municion',
            'puntos' => 1
        ]);
    }
}
