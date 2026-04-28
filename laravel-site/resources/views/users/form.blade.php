@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div>
        <div class="page-kicker">Governança</div>
        <h1 class="page-title">{{ $legacyUser->exists ? 'Editar usuário' : 'Novo usuário' }}</h1>
        <p class="page-caption">Defina o nível de acesso de cada pessoa que atua na rotina do hotel.</p>
    </div>
</div>
<form method="post" action="{{ $legacyUser->exists ? route('users.update', $legacyUser) : route('users.store') }}" class="card">
    @csrf
    @if ($legacyUser->exists)
        @method('put')
    @endif
    <div class="card-body row g-3">
        <div class="col-md-6">
            <label class="form-label">Nome</label>
            <input class="form-control" name="nome" value="{{ old('nome', $legacyUser->nome) }}" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Login</label>
            <input class="form-control" name="login" value="{{ old('login', $legacyUser->login) }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Senha</label>
            <input class="form-control" type="password" name="senha" {{ $legacyUser->exists ? '' : 'required' }}>
        </div>
        <div class="col-md-4">
            <label class="form-label">Status</label>
            <select class="form-select" name="status">
                <option value="ATIVO" @selected(old('status', $legacyUser->status ?: 'ATIVO') === 'ATIVO')>ATIVO</option>
                <option value="INATIVO" @selected(old('status', $legacyUser->status) === 'INATIVO')>INATIVO</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Nível</label>
            <select class="form-select" name="desc_nivel" required>
                <option value="Usuario" @selected(old('desc_nivel', $legacyUser->desc_nivel ?: 'Usuario') === 'Usuario')>Usuário</option>
                <option value="Administrador" @selected(old('desc_nivel', $legacyUser->desc_nivel) === 'Administrador')>Administrador</option>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Unidade</label>
            <input class="form-control" name="unidade" value="{{ old('unidade', $legacyUser->unidade) }}">
        </div>
    </div>
    <div class="card-footer d-flex gap-2">
        <button class="btn btn-primary" type="submit">Salvar</button>
        <a class="btn btn-light" href="{{ route('users.index') }}">Cancelar</a>
    </div>
</form>
@endsection
