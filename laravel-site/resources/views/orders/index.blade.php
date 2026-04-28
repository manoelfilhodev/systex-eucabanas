@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div>
        <div class="page-kicker">Reposição e compras</div>
        <h1 class="page-title">Compras</h1>
        <p class="page-caption">Acompanhe solicitações aprovadas e mantenha rastreabilidade da reposição.</p>
    </div>
    <a class="btn btn-primary" href="{{ route('orders.create') }}">Nova compra</a>
</div>

<div class="card">
    <div class="card-body table-responsive">
        <table class="table table-striped align-middle">
            <thead><tr><th>ID</th><th>Nome</th><th>Valor</th><th>Status</th><th>Data</th><th></th></tr></thead>
            <tbody>
            @forelse ($orders as $order)
                @php
                    $orderDate = blank($order->ord_date) ? '-' : \Carbon\Carbon::parse($order->ord_date)->format('d/m/Y');
                @endphp
                <tr>
                    <td>{{ $order->ord_id }}</td>
                    <td>{{ $order->ord_name }}</td>
                    <td>R$ {{ number_format((float) $order->ord_value, 2, ',', '.') }}</td>
                    <td><span class="badge bg-secondary">{{ $order->ord_status }}</span></td>
                    <td>{{ $orderDate }}</td>
                    <td class="text-end">
                        <a class="btn btn-sm btn-outline-primary" href="{{ route('orders.edit', $order) }}">Editar</a>
                        <form class="d-inline" method="post" action="{{ route('orders.destroy', $order) }}">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm btn-outline-danger" type="submit">Remover</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <h5 class="mb-2">Nenhuma compra encontrada</h5>
                        <p class="text-muted mb-3">Use a lista em PDF para fechar prioridades e registre as compras aprovadas por aqui.</p>
                        <a class="btn btn-primary" href="{{ route('orders.create') }}">Cadastrar compra</a>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
        @if (method_exists($orders, 'links'))
            {{ $orders->links() }}
        @endif
    </div>
</div>
@endsection
