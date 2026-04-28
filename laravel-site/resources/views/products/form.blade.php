@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div>
        <div class="page-kicker">Estoque operacional</div>
        <h1 class="page-title">{{ $product->exists ? 'Editar produto' : 'Novo produto' }}</h1>
        <p class="page-caption">Mantenha família, quantidade e validade precisas para que a compra responda à operação real.</p>
    </div>
</div>
<form method="post" action="{{ $product->exists ? route('products.update', $product) : route('products.store') }}" class="card">
    @csrf
    @if ($product->exists)
        @method('put')
    @endif
    <div class="card-body row g-3">
        <div class="col-md-6">
            <label class="form-label">Nome</label>
            <input class="form-control" name="prod_name" value="{{ old('prod_name', $product->prod_name) }}" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Família</label>
            <select class="form-select" name="prod_family" required>
                <option value="">Selecione...</option>
                @foreach (['Alimentos', 'Produtos de Limpeza', 'Produtos de Revenda', 'Outros'] as $family)
                    <option value="{{ $family }}" @selected(old('prod_family', $product->prod_family) === $family)>{{ $family }}</option>
                @endforeach
            </select>
        </div>
        @if (auth()->user()?->isAdmin())
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select class="form-select" name="prod_status">
                    <option value="ATIVO" @selected(old('prod_status', $product->prod_status ?: 'ATIVO') === 'ATIVO')>ATIVO</option>
                    <option value="INATIVO" @selected(old('prod_status', $product->prod_status) === 'INATIVO')>INATIVO</option>
                </select>
            </div>
        @endif
        <div class="col-md-3">
            <label class="form-label">Preço</label>
            <input class="form-control" type="number" step="0.01" min="0" name="prod_price" value="{{ old('prod_price', $product->prod_price) }}" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Quantidade</label>
            <input class="form-control" type="number" min="0" name="prod_qtde" value="{{ old('prod_qtde', $product->prod_qtde) }}" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Validade</label>
            <input class="form-control" type="date" name="prod_valid" value="{{ old('prod_valid', $product->prod_valid) }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">Foto URL</label>
            <input class="form-control" name="prod_foto" value="{{ old('prod_foto', $product->prod_foto) }}">
        </div>
        <div class="col-12">
            <label class="form-label">Descrição</label>
            <textarea class="form-control" name="prod_desc" rows="3">{{ old('prod_desc', $product->prod_desc) }}</textarea>
        </div>
    </div>
    <div class="card-footer d-flex gap-2">
        <button class="btn btn-primary" type="submit">Salvar</button>
        <a class="btn btn-light" href="{{ route('products.index') }}">Cancelar</a>
    </div>
</form>
@endsection
