<?php

namespace Database\Seeders;

use App\Models\Doc;
use Carbon\Carbon;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class DocsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Doc::factory(10)->create();
    }
}
