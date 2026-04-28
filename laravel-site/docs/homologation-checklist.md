# Checklist de Homologacao Local

Data: 2026-04-28

## Status

O sistema Laravel esta pronto para homologacao local do escopo atual:

- Login e logout.
- Dashboard de abastecimento.
- Produtos.
- Compras.
- Usuarios.
- Log do sistema.
- PDF de compras.
- Tema EuCabanas aplicado ao admin.

## Validacoes Executadas

- `php artisan test`: 4 testes, 9 assertions.
- Login real com `remember=1`.
- Acesso HTTP autenticado a `dashboard`, `products`, `orders`, `users` e `logs`.
- Download real do PDF em `/purchase-list/pdf`.
- Stress local moderado com ApacheBench:
  - 1.000 requests nas telas principais, 0 falhas.
  - 50 requests no PDF, 0 falhas.
- Validacao multiagente concluida com OK de todos os agentes.

## Pontos Corrigidos Durante Homologacao

- Tema admin consolidado em `public/css/eucabanas-admin.css`.
- Contraste do PDF ajustado para leitura em fundo branco.
- Login com "lembrar-me" ajustado para tabela legada sem `remember_token`.
- Testes automatizados adicionados para login com remember e download do PDF.

## Antes de Producao

- Configurar banco real no `.env`.
- Rotacionar credenciais expostas no legado.
- Remover dumps, logs e arquivos sensiveis da raiz publica.
- Configurar Nginx/Apache + PHP-FPM, nao `php artisan serve`.
- Rodar `php artisan migrate --force` com backup confirmado.
- Rodar `php artisan config:cache` e `php artisan route:cache`.
- Validar permissao de escrita em `storage/` e `bootstrap/cache/`.
- Definir politica de backup e retencao do PDF/listas de compra.
- Substituir CDN do Lucide por asset local ou versao fixada antes de ambiente critico.

## Proximo Ciclo

- Criar endpoints JSON para o aplicativo Flutter.
- Autenticacao mobile por token.
- Sincronizacao de produtos, compras e criticidade.
- Testes de integracao API + mobile.
