<?php

use Illuminate\Database\Seeder;

class ProjectNoteTableSeeder extends Seeder
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

        // Gerar 50 registros na tabela.
        factory(\Projeto\Entities\ProjectNote::class, 50)->create();
    }
}
