# Backend API

Bem-vindo ao **Backend API**! Este projeto oferece funcionalidades de autenticação e acesso a documentos.

## Instalação

1. **Clone o projeto:**

    ```bash
    git clone https://github.com/steviekelvin/laravel-api.git
    ```

2.  **Navegue até a raiz do projeto:**

    ```bash
    cd laravel-api
    ```
3. **Instale as dependências do sistema:**

    ```bash
    sudo apt-get update
    sudo apt-get install php-xml php-curl
    ```

4. **Instale as dependências do projeto:**

    ```bash
    composer install
    ```

5. **Configure o ambiente:**

    - Copie o arquivo `.env.example` para `.env`:

        ```bash
        cp .env.example .env
        ```

    - Configure um alias para comandos Sail (opcional):

        ```bash
        alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'
        ```


6. **Suba o projeto:**

    ```bash
    sail up
    ```

7. **Gere a chave da aplicação e o segredo JWT:**

    ```bash
    sail php artisan key:generate
    sail php artisan jwt:secret
    sail php artisan config:clear
    ```

8. **Gere os dados iniciais no banco de dados:**

    ```bash
    sail php artisan migrate:fresh --seed
    ```

9. **Ajuste o manipulador de exceções:**

    - No arquivo `vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php`, substitua o retorno da função `unauthenticated` por:

        ```php
        protected function unauthenticated($request, AuthenticationException $exception)
        {
            return response()->json(['message' => $exception->getMessage()], 401);
        }
        ```

No arquivo `vendor/laravel/framework/src/Illuminate/Foundation/Configuration/ApplicationBuilder.php` substitua a função `withMiddleware` por:

```php
public function withMiddleware(?callable $callback = null)
    {
        $this->app->afterResolving(HttpKernel::class, function ($kernel) use ($callback) {
            $middleware = (new Middleware);

            if (!is_null($callback)) {
                $callback($middleware);
            }

            $this->pageMiddleware = $middleware->getPageMiddleware();
            $kernel->setGlobalMiddleware($middleware->getGlobalMiddleware());
            $kernel->setMiddlewareGroups($middleware->getMiddlewareGroups());
            $kernel->setMiddlewareAliases($middleware->getMiddlewareAliases());

            if ($priorities = $middleware->getMiddlewarePriority()) {
                $kernel->setMiddlewarePriority($priorities);
            }
        });

        return $this;
    }
```

## Rotas

### Autenticação

-   **Login via Email e Senha**

    -   **Endpoint:** `/api/users/`
    -   **Método:** `POST`
    -   **Descrição:** Autentica um usuário com email e senha.
    -   **Body:**
        ```json
        { "email": "usuario@exemplo.com", "senha": "sua_senha" }
        ```
    -   **Resposta:** Retorna um token JWT para autenticação.

-   **Login via Token JWT**

    -   **Endpoint:** `/api/users/login`
    -   **Método:** `POST`
    -   **Descrição:** Autentica um usuário com um token JWT.
    -   **Body:**
        ```json
        { "token": "seu_token_jwt" }
        ```
    -   **Resposta:** Retorna um token JWT válido para autenticação.

### Documentos

-   **Lista de Documentos**

    -   **Endpoint:** `/api/docs/`
    -   **Método:** `GET`
    -   **Descrição:** Obtém a lista completa de todos os documentos.
    -   **Autenticação:** Necessário Bearer Token JWT

-   **Documento por ID**

    -   **Endpoint:** `/api/docs/{id}`
    -   **Método:** `GET`
    -   **Descrição:** Retorna o documento com o ID especificado.
    -   **Autenticação:** Necessário Bearer Token JWT

## Autenticação

Para acessar rotas que requerem autenticação, inclua um token JWT válido no cabeçalho da solicitação:

```http
Authorization: Bearer seu_token_jwt
```

## Swagger

Para acessar o swagger da aplicação basta acessar o [http://localhost/api/documentation](http://localhost/api/documentation)


## Testes: 

```bash
 sail php artisan test
 ```
