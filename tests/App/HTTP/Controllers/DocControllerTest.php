<?php

namespace Tests\App\HTTP\Controllers;

use App\Models\Doc;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Testes para o controlador de documentos.
 *
 * Comando para rodar todos os testes: sail php artisan test
 */

class DocControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Teste o método show para um documento existente.
     *
     * Comando para teste:  sail php artisan test --filter=testShowExistingDocument
     * @return void
     */
    public function testShowExistingDocument()
    {
        $user = User::factory()->create();
        $title = 'documento 20';
        $description = 'Descrição 20';

        $document = Doc::factory()->create([
            'titulo' => $title,
            'descricao' => $description,
        ]);

        $this->assertIsInt($document->id, 'Id do documento não encontrado');

        $response = $this->actingAs($user, 'api')->json('GET', "/api/docs/{$document->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => 'true',
                'data' => [
                    'id' => $document->id,
                    'titulo' => $document->titulo,
                    'descricao' => $document->descricao,
                    'created_at' => $document->created_at->toJSON(),
                    'updated_at' => $document->updated_at->toJSON(),
                ],
            ])
            ->assertJsonStructure([
                'success',
                'data' => [
                    'id',
                    'titulo',
                    'descricao',
                    'created_at',
                    'updated_at',
                ],
            ])
            ->assertJsonFragment([
                'id' => $document->id,
                'titulo' => $title,
                'descricao' => $description,
            ])
            ->assertJsonPath('success', 'true');
    }
    /**
     * Teste o método show para um documento inexistente.
     *
     * Comando para teste:  sail php artisan test --filter=testShowNonExistingDocument
     * @return void
     */
    public function testShowNonExistingDocument()
    {
        $nonExistingId = 999;

        $user = User::factory()->create();
        $response = $this->actingAs($user, 'api')->json('GET', "/api/docs/{$nonExistingId}");

        $response->assertStatus(404)
            ->assertJson([
                'success' => 'false',
                'message' => 'Documento não encontrado',
                'data' => [],
            ]);
    }

    /**
     * Teste o método de índice quando existirem documentos.
     *
     * Comando para teste:  sail php artisan test --filter=testIndexDocumentsExist
     * @return void
     */
    public function testIndexDocumentsExist()
    {
        $user = User::factory()->create();

        $documents = Doc::factory()->count(6)->create();

        $response = $this->actingAs($user, 'api')->json('GET', "/api/docs");

        $response->assertStatus(200)
            ->assertJson([
                'success' => 'true',
                'data' => $documents->map(function ($document) {
                    return [
                        'id' => $document->id,
                        'titulo' => $document->titulo,
                        'descricao' => $document->descricao,
                        'created_at' => $document->created_at->toJSON(),
                        'updated_at' => $document->updated_at->toJSON(),
                    ];
                })->toArray(),
            ]);
    }

    /**
     * Teste o método de índice quando não existir nenhum documento.
     *
     * Comando para teste:  sail php artisan test --filter=testIndexNoDocumentsExist
     * @return void
     */
    public function testIndexNoDocumentsExist()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->json('GET', "/api/docs");

        $response->assertStatus(200)
            ->assertJson([
                'success' => 'true',
                'data' => [],
            ]);
    }
}
