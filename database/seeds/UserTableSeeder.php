<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Para apagar dados da tabela.
        //\Projeto\Entities\Project::truncate();

        // Gerar 10 registros na tabela.
        factory(\Projeto\Entities\User::class, 10)->create();
    }
}
