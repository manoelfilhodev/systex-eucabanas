@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div>
        <div class="page-kicker">Governança</div>
        <h1 class="page-title">Usuários</h1>
        <p class="page-caption">Controle de acesso da equipe operacional e administrativa.</p>
    </div>
    <a class="btn btn-primary" href="{{ route('users.create') }}">Novo usuário</a>
</div>

<div class="card">
    <div class="card-body table-responsive">
        <table class="table table-striped align-middle">
            <thead><tr><th>Nome</th><th>Login</th><th>Status</th><th>Nível</th><th></th></tr></thead>
            <tbody>
            @forelse ($users as $legacyUser)
                <tr>
                    <td>{{ $legacyUser->name }}</td>
                    <td>{{ $legacyUser->email }}</td>
                    <td><span class="badge bg-{{ $legacyUser->status === 'ATIVO' ? 'success' : 'secondary' }}">{{ $legacyUser->status }}</span></td>
                    <td>{{ $legacyUser->desc_nivel === 'Usuario' ? 'Usuário' : $legacyUser->desc_nivel }}</td>
                    <td class="text-end">
                        <a class="btn btn-sm btn-outline-primary" href="{{ route('users.edit', $legacyUser) }}">Editar</a>
                        <form class="d-inline" method="post" action="{{ route('users.destroy', $legacyUser) }}">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm btn-outline-danger" type="submit">Inativar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">Nenhum usuário encontrado.</td></tr>
            @endforelse
            </tbody>
        </table>
        @if (method_exists($users, 'links'))
            {{ $users->links() }}
        @endif
    </div>
</div>
@endsection
