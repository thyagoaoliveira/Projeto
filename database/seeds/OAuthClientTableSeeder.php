<?php

use Illuminate\Database\Seeder;

class OAuthClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\Projeto\Entities\OAuthClient::class, 1)->create();
    }
}
