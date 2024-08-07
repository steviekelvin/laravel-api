<?php
namespace Tests\App\HTTP\Controllers;

use App\Models\Doc;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DocControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Teste o método show para um documento existente.
     *
     * @return void
     */
    public function testShowExistingDocument()
    {
        $user = User::factory()->create();
        $document = Doc::factory()->create([
            'titulo' => 'documento 20',
            'descricao' => 'Descrição 20',
        ]);
        $response = $this->actingAs($user, 'api')->json('GET', "/api/docs/{$document->id}"); 

        $response->assertStatus(200)
            ->assertJson([
                'success' => 'true',
                'data' => [
                    'id' => $document->id,
                    'titulo' => 'documento 20',
                    'descricao' => 'Descrição 20',
                    'created_at' => $document->created_at->toJSON(),
                    'updated_at' => $document->updated_at->toJSON(),
                ],
            ]);
    }

    /**
     * Teste o método show para um documento inexistente.
     *
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
