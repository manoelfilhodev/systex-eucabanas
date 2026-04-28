# ATHENA - Regras de Negocio

Data: 2026-04-27

## Dominio

Sistema de controle diario de produtos de um hotel, incluindo alimentos, produtos de limpeza e demais itens operacionais.

## Atores

- Usuario operacional: atualiza diariamente quantidades, validade e dados dos produtos.
- Administrador: acompanha criticidade, compra novos produtos, repoe estoque, gerencia usuarios e audita logs.

## Produtos

Campos principais:

- Categoria/familia
- Data de cadastro
- Preco
- Quantidade
- Validade
- Vence em
- Status

Usuarios e administradores podem cadastrar e editar produtos.

## Criticidade de Compra

Regra inicial herdada do legado:

- Verde: quantidade maior ou igual a 6.
- Amarelo: quantidade 4 ou 5.
- Vermelho: quantidade menor que 4.

O dashboard deve mostrar a visao geral por cor para decisao rapida de compra.

## Dashboard

Deve conter:

- Total de produtos ativos.
- Distribuicao por criticidade: verde, amarelo e vermelho.
- Link para gerar PDF de compras, somente para administrador.
- Tabela/lista de atividades recentes.
- Lista resumida de itens em atencao ou criticos.

## PDF de Compra

O administrador gera uma lista de compras em PDF.

Agrupamento obrigatorio:

- Primeiro por criticidade.
- Depois por familia/categoria.

Itens verdes nao entram na lista de compra por padrao.

## Usuarios

Tela restrita ao administrador.

Necessario manter nivel de acesso para distinguir admin de usuario operacional.

## Clientes

Nao entra no escopo atual.

Uso futuro: cadastro de clientes que acessam o estabelecimento.

## Log Sistema

Tela restrita ao administrador.

Deve listar atividades recentes de usuarios e administradores:

- Login
- Logout
- Cadastro de produto
- Edicao de produto
- Inativacao/exclusao logica
- Alteracoes administrativas
