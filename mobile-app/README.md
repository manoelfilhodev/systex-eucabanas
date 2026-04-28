# EuCabanas App

Aplicativo Flutter inicial para a operacao mobile da EuCabanas.

## Estado Atual

- Projeto Flutter criado como `eucabanas_app`.
- Tema visual alinhado com a paleta EuCabanas.
- Tela inicial de login visual.
- Dashboard mobile inicial com KPIs e prioridades de compra.
- Teste de widget cobrindo abertura do app e navegacao para o dashboard.

## Rodar

No ambiente atual, o Flutter funcional esta instalado no Windows. A partir do Windows:

```bash
cd mobile-app
flutter test
flutter run
```

No WSL, o script do Flutter em `/mnt/c/dev/flutter/bin/flutter` esta com incompatibilidade de final de linha, entao a execucao direta por WSL falha. O projeto em si esta valido; os testes foram executados via Flutter do Windows.

## Proximo Passo

O backend Laravel ainda expoe rotas web com sessao. Para integrar o app, o proximo ciclo deve adicionar:

- API JSON versionada.
- Login mobile por token.
- Endpoints para dashboard, produtos, compras e PDF/lista de compras.
- Camada de cliente HTTP no Flutter.
- Persistencia local basica para sessao e cache.
