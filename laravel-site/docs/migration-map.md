# Mapa de Migracao

| Legado | Laravel |
| --- | --- |
| `index.php` | rota `/` com redirect/login |
| `_login.php` | `resources/views/auth/login.blade.php` |
| `_funcoes/read.php?id=authentication` | `AuthenticatedSessionController@store` |
| `_init.php` | `routes/web.php` + `layouts/app.blade.php` + middleware `auth` |
| `_pages/dash.php` | `DashboardController` + `dashboard/index.blade.php` |
| `_pages/product.php` | `ProductController` + views `products/*` |
| `_pages/users.php` | `UserController` + views `users/*` |
| `_pages/order.php` | `OrderController` + views `orders/*` |
| `_pages/log.php` | dashboard inicial; criar `ActivityLogController` no proximo ciclo |
| `_funcoes/func.php` | Eloquent, Query Builder, Form Requests e Services |
| `_conexao/*.php` | `config/database.php` + `.env` |

## Credenciais

Nao migrar credenciais hardcoded. Configurar no `.env`:

```dotenv
DB_CONNECTION=mysql
DB_HOST=
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

## Usuario Local

A migration local cria um usuario de desenvolvimento quando `_tb_users` nao existe:

- Login: `admin@systex.local`
- Senha: `password`

Trocar antes de qualquer ambiente compartilhado.
