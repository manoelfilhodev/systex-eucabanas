# Systex Laravel Admin

Conversao padronizada do legado `base-site` para Laravel, conduzida no fluxo de agentes Systex.

## Rodar localmente

```bash
cd laravel-site
php artisan migrate
php artisan serve
```

Usuario local criado pela migration de compatibilidade:

- Login: `admin@systex.local`
- Senha: `password`

## Documentacao

- `docs/agents/atlas-validation.md`
- `docs/migration-map.md`
- `docs/homologation-checklist.md`

## Observacao

O legado `base-site` foi preservado. Nao leve arquivos de dump, logs ou credenciais hardcoded para producao.
