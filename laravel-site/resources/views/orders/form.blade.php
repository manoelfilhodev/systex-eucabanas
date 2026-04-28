@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div>
        <div class="page-kicker">Reposição e compras</div>
        <h1 class="page-title">{{ $order->exists ? 'Editar compra' : 'Nova compra' }}</h1>
        <p class="page-caption">Registre a compra aprovada com status, data e valor para manter rastreabilidade.</p>
    </div>
</div>
<form method="post" action="{{ $order->exists ? route('orders.update', $order) : route('orders.store') }}" class="card">
    @csrf
    @if ($order->exists)
        @method('put')
    @endif
    <div class="card-body row g-3">
        <div class="col-md-6">
            <label class="form-label">Nome</label>
            <input class="form-control" name="ord_name" value="{{ old('ord_name', $order->ord_name) }}" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Valor</label>
            <input class="form-control" type="number" step="0.01" min="0" name="ord_value" value="{{ old('ord_value', $order->ord_value) }}" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Data</label>
            <input class="form-control" type="date" name="ord_date" value="{{ old('ord_date', $order->ord_date) }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Status</label>
            <select class="form-select" name="ord_status" required>
                @foreach (['ABERTA', 'EM COTACAO', 'COMPRADA', 'CANCELADA'] as $status)
                    <option value="{{ $status }}" @selected(old('ord_status', $order->ord_status ?: 'ABERTA') === $status)>{{ $status }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-8">
            <label class="form-label">Descrição</label>
            <textarea class="form-control" name="ord_desc" rows="3">{{ old('ord_desc', $order->ord_desc) }}</textarea>
        </div>
    </div>
    <div class="card-footer d-flex gap-2">
        <button class="btn btn-primary" type="submit">Salvar</button>
        <a class="btn btn-light" href="{{ route('orders.index') }}">Cancelar</a>
    </div>
</form>
@endsection
