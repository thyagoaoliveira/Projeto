<?php

use Illuminate\Database\Seeder;

class ClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Para apagar dados da tabela.
        \Projeto\Entities\Client::truncate();

        // Gerar 10 registros na tabela.
        factory(\Projeto\Entities\Client::class, 10)->create();
    }
}
