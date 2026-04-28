@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div>
        <div class="page-kicker">Estoque operacional</div>
        <h1 class="page-title">Produtos</h1>
        <p class="page-caption">Cadastro e atualização diária dos itens que precisam chegar ao hóspede sem falha.</p>
    </div>
    <div class="d-flex gap-2">
        @if (auth()->user()?->isAdmin())
            <a class="btn btn-light" href="{{ route('products.index', ['inactive' => request()->boolean('inactive') ? 0 : 1]) }}">
                {{ request()->boolean('inactive') ? 'Ver ativos' : 'Ver inativos' }}
            </a>
        @endif
        <a class="btn btn-primary" href="{{ route('products.create') }}">Novo produto</a>
    </div>
</div>

<div class="card">
    <div class="card-body table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr><th>Nome</th><th>Família</th><th>Cadastro</th><th>Preço</th><th>Quantidade</th><th>Validade</th><th>Vence em</th><th>Criticidade</th><th>Status</th><th></th></tr>
            </thead>
            <tbody>
            @forelse ($products as $product)
                @php
                    $daysToExpire = $product->daysToExpire();
                    $validity = blank($product->prod_valid) ? '-' : \Carbon\Carbon::parse($product->prod_valid)->format('d/m/Y');
                    $createdAt = blank($product->prod_date_cad) ? '-' : \Carbon\Carbon::parse($product->prod_date_cad)->format('d/m/Y');
                @endphp
                <tr>
                    <td>
                        <strong>{{ $product->prod_name }}</strong>
                        @if (filled($product->prod_desc))
                            <div class="small text-muted">{{ $product->prod_desc }}</div>
                        @endif
                    </td>
                    <td>{{ $product->prod_family }}</td>
                    <td>{{ $createdAt }}</td>
                    <td>R$ {{ number_format((float) $product->prod_price, 2, ',', '.') }}</td>
                    <td>{{ $product->prod_qtde }}</td>
                    <td>{{ $validity }}</td>
                    <td>
                        @if (is_null($daysToExpire))
                            -
                        @elseif ($daysToExpire < 0)
                            <span class="badge bg-danger">Vencido</span>
                        @elseif ($daysToExpire <= 7)
                            <span class="badge bg-warning text-dark">{{ $daysToExpire }} dias</span>
                        @else
                            {{ $daysToExpire }} dias
                        @endif
                    </td>
                    <td><span class="badge {{ $product->purchaseStatusBadgeClass() }}">{{ $product->purchaseStatusLabel() }}</span></td>
                    <td><span class="badge bg-{{ $product->prod_status === 'ATIVO' ? 'success' : 'secondary' }}">{{ $product->prod_status }}</span></td>
                    <td class="text-end">
                        <a class="btn btn-sm btn-outline-primary" href="{{ route('products.edit', $product) }}">Editar</a>
                        @if (auth()->user()?->isAdmin() && $product->prod_status === 'ATIVO')
                            <form class="d-inline" method="post" action="{{ route('products.destroy', $product) }}">
                                @csrf
                                @method('delete')
                                <button class="btn btn-sm btn-outline-danger" type="submit">Inativar</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center py-5">
                        <h5 class="mb-2">Nenhum produto encontrado</h5>
                        <p class="text-muted mb-3">Cadastre o primeiro item para iniciar o controle diário de estoque.</p>
                        <a class="btn btn-primary" href="{{ route('products.create') }}">Cadastrar produto</a>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
        @if (method_exists($products, 'links'))
            {{ $products->links() }}
        @endif
    </div>
</div>
@endsection
