<?php

use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Client::class, 10)->create()->each(function ($client) {
            $client->type()->save(factory(App\User::class)->create());
        });
    }
}
