<?php

namespace Tests\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;


    /**
     * Teste o método show para usuários não autenticados.
     *
     * Comando para teste:  sail php artisan test --filter=testShowUnauthenticated
     * @return void
     */
    public function testShowUnauthenticated()
    {
        $response = $this->json('GET', '/api/users');

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }

    /**
     * Teste o método show para usuário autenticado.
     *
     * Comando para teste:  sail php artisan test --filter=testShowAuthenticated
     * @return void
     */
    public function testShowAuthenticated()
    {
        $user = User::factory()->create();
        Auth::login($user);
        $token = JWTAuth::fromUser($user);

        // Adiciona o token ao header da requisição e faz a requisição
        $response = $this->withHeaders([
            'Authorization' => "Bearer $token"
        ])->json('GET', '/api/users');

        $response->assertStatus(200)
            ->assertJson([
                'success' => 'true',
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ]);
    }


    /**
     * Teste o método de login com entrada inválida.
     *
     * Comando para teste:  sail php artisan test --filter=testLoginInvalidInput
     * @return void
     */
    public function testLoginInvalidInput()
    {
        $response = $this->json('POST', '/api/users/login', [
            'email' => 'not-an-email',
            'password' => '',
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'error' => 'Invalid input',
            ]);
    }

    /**
     * Teste de login com credenciais inválidas
     *
     * Comando para teste:  sail php artisan test --filter=testLoginInvalidCredentials
     * @return void
     */
    public function testLoginInvalidCredentials()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->json('POST', '/api/users/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'error' => 'Unauthorized',
            ]);
    }

    /**
     * Teste de login com credenciais válidas
     *
     * Comando para teste:  sail php artisan test --filter=testLoginValidCredentials
     * @return void
     */
    public function testLoginValidCredentials()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->json('POST', '/api/users/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'token',
                    'token_type',
                    'expires_in',
                ],
            ]);
    }
}
