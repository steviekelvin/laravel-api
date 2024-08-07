<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Whoops\Run;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(DocsSeeder::class);

        User::factory()->create([
            'name' => 'Stevie Kelvin',
            'email' => 'steviekelvinsilvabarbosa4@gmail.com',
            'password' => bcrypt('12345678')
        ]);

        User::factory()->create([
            'name' => 'Teste',
            'email' => 'etste@teste.com',
            'password' => bcrypt('12345678')
        ]);
    }
}
