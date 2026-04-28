# Contrato Inicial da API Mobile

Este arquivo define o alvo do proximo ciclo. O Laravel atual esta pronto para homologacao web, mas ainda usa rotas web com sessao. O app Flutter deve consumir uma API JSON versionada.

## Base

`/api/v1`

## Autenticacao

### `POST /auth/login`

Request:

```json
{
  "login": "admin@hotel.local",
  "password": "password"
}
```

Response:

```json
{
  "token": "mobile-token",
  "user": {
    "id": 1,
    "name": "Administrador Hotel",
    "login": "admin@hotel.local",
    "role": "Administrador"
  }
}
```

### `POST /auth/logout`

Headers:

```http
Authorization: Bearer mobile-token
```

## Dashboard

### `GET /dashboard`

Response:

```json
{
  "products_total": 20,
  "available": 7,
  "attention": 5,
  "critical": 8,
  "purchase_priorities": []
}
```

## Produtos

### `GET /products`

Query:

- `status=ATIVO`
- `criticality=critical|attention|available`
- `page=1`

### `POST /products`

Cria produto.

### `PUT /products/{id}`

Atualiza produto.

## Compras

### `GET /orders`

Lista compras.

### `POST /orders`

Cria compra.

## Lista de Compra

### `GET /purchase-list`

Retorna a mesma informacao do PDF em JSON, agrupada por criticidade e familia.

### `GET /purchase-list/pdf`

Pode continuar retornando PDF para compartilhamento/download.

## Observacoes

- Usar HTTPS em producao.
- Tokens devem expirar.
- App deve tratar offline/cache em ciclo posterior.
- Manter regras de criticidade iguais ao backend web.
