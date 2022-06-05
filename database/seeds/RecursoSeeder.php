<?php
use App\Recurso;
use Illuminate\Database\Seeder;

class RecursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(Recurso::class, 6)->create();

        Recurso::create([
            'cantidad' => 1,
            'superviviente_id' => 1,
            'item_id' => 1,
        ]);
        Recurso::create([
            'cantidad' => 3,
            'superviviente_id' => 1,
            'item_id' => 2,
        ]);
        Recurso::create([
            'cantidad' => 2,
            'superviviente_id' => 1,
            'item_id' => 4,
        ]);
        Recurso::create([
            'cantidad' => 1,
            'superviviente_id' => 2,
            'item_id' => 1,
        ]);
        Recurso::create([
            'cantidad' => 2,
            'superviviente_id' => 2,
            'item_id' => 3,
        ]);
        Recurso::create([
            'cantidad' => 5,
            'superviviente_id' => 2,
            'item_id' => 2,
        ]);

        Recurso::create([
            'cantidad' => 1,
            'superviviente_id' => 3,
            'item_id' => 1,
        ]);

        Recurso::create([
            'cantidad' => 1,
            'superviviente_id' => 3,
            'item_id' => 3,
        ]);
        Recurso::create([
            'cantidad' => 2,
            'superviviente_id' => 3,
            'item_id' => 4,
        ]);

    }
}
