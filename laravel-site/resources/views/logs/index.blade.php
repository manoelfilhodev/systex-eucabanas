@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div>
        <div class="page-kicker">Auditoria</div>
        <h1 class="page-title">Log Sistema</h1>
        <p class="page-caption">Histórico recente das ações executadas pela equipe e administração.</p>
    </div>
</div>
<div class="card">
    <div class="card-body table-responsive">
        <table class="table table-striped">
            <thead><tr><th>Data</th><th>Usuário</th><th>Atividade</th></tr></thead>
            <tbody>
            @forelse ($logs as $log)
                <tr>
                    <td>{{ blank($log->log_data) ? '-' : \Carbon\Carbon::parse($log->log_data)->format('d/m/Y H:i') }}</td>
                    <td>{{ $log->user?->name ?? 'Usuário #'.$log->log_id_user }}</td>
                    <td>{{ $log->log_id_movimento }}</td>
                </tr>
            @empty
                <tr><td colspan="3">Nenhuma atividade encontrada.</td></tr>
            @endforelse
            </tbody>
        </table>
        @if (method_exists($logs, 'links'))
            {{ $logs->links() }}
        @endif
    </div>
</div>
@endsection
