# Validacao Atlas - base-site para Laravel

Data: 2026-04-27

## Decisao

O sistema legado em `base-site` nao deve ser evoluido diretamente em PHP procedural. A conversao padronizada foi iniciada em `laravel-site`, preservando o legado como referencia ate a homologacao.

## Status da Conversao

- Laravel 13 criado em `laravel-site`.
- Assets visuais do legado copiados para `public/legacy-assets`.
- Login migrado para controller Laravel, middleware `auth`, sessao regenerada e CSRF nativo.
- Modulos iniciais migrados: dashboard, produtos, usuarios e compras.
- Models criados para tabelas legadas: `_tb_users`, `_tb_products`, `_tb_orders`, `_tb_log`.
- Migration de compatibilidade criada para ambiente local e testes.

## Bloqueios do Legado

- Credenciais reais em `_conexao/config.php` e `_conexao/conexao.php`.
- Dump `bros-bd.sql.gz` dentro da aplicacao.
- SQL montado por concatenacao em `_funcoes/func.php`.
- Login com `md5`.
- Include dinamico por `$_GET['page']` em `_init.php`.
- Formularios sem CSRF.
- Saida HTML sem escape em paginas de produtos, usuarios e logs.
- Divergencia entre dump SQL e banco configurado no app atual.

## Padrao Systex Aplicado

- ATLAS: decisao de migracao incremental com legado preservado.
- PROMETEU: separacao em rotas, controllers, requests, models e views.
- GAIA: tabelas centrais mapeadas e migration local criada.
- ARES: CRUDs passam por controllers e validacao.
- APOLLO: layout Blade com assets existentes.
- ATHENA: regras de negocio do controle de estoque diario do hotel formalizadas.
- HADES: segredos removidos do novo codigo; CSRF e escaping Blade ativos.
- ORION: sintaxe PHP e testes Laravel devem ser executados a cada incremento.

## Proximas Decisoes Necessarias

- Confirmar schema real do banco `systex91_BD_EUCABANAS`.
- Rotacionar credenciais expostas no legado.
- Remover dumps/logs da raiz publica antes de qualquer deploy.
- Definir se `clientes.php` e compras sao modulos reais ou telas reaproveitadas do template.
