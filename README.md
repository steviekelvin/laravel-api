# Backend API

Bem-vindo ao Backend API! Este projeto é uma API que oferece funcionalidades de autenticação e acesso a documentos.

## Rotas

### Autenticação

- **Login via Email e Senha**
  - **Endpoint:** `/api/users/`
  - **Método:** `POST`
  - **Descrição:** Autentica um usuário com email e senha.
  - **Body:** `{ "email": "usuario@exemplo.com", "senha": "sua_senha" }`
  - **Resposta:** Retorna um token JWT para autenticação.

- **Login via Token JWT**
  - **Endpoint:** `/api/users/login`
  - **Método:** `POST`
  - **Descrição:** Autentica um usuário com um token JWT.
  - **Body:** `{ "token": "seu_token_jwt" }`
  - **Resposta:** Retorna um token JWT válido para autenticação.

### Documentos

- **Lista de Documentos**
  - **Endpoint:** `/api/docs/`
  - **Método:** `GET`
  - **Descrição:** Obtém a lista completa de todos os documentos.
  - **Autenticação:** Necessário Bearer Token JWT

- **Documento por ID**
  - **Endpoint:** `/api/docs/{id}`
  - **Método:** `GET`
  - **Descrição:** Retorna o documento com o ID especificado.
  - **Autenticação:** Necessário Bearer Token JWT

## Autenticação

Para acessar rotas que requerem autenticação, você deve incluir um token JWT válido no cabeçalho da solicitação:

```http
Authorization: Bearer seu_token_jwt
```

## Link do Swagger
