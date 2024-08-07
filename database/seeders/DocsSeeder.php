<?php

namespace Database\Seeders;

use App\Models\Doc;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DocsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $documentos = [
            [
                "titulo" => "documento 1",
                "descricao" => "Descrição 01",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                "titulo" => "documento 2",
                "descricao" => "Descrição 02"
            ],
            [
                "titulo" => "documento 3",
                "descricao" => "Descrição 03",
            ],
            [
                "titulo" => "documento 4",
                "descricao" => "Descrição 04"
            ],
            [
                "titulo" => "documento 5",
                "descricao" => "Descrição 05"
            ],
            [
                "titulo" => "documento 6",
                "descricao" => "Descrição 06"
            ],
        ];

        foreach ($documentos as $documento) {
            Doc::create($documento);
        }
    }
}
