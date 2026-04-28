@extends('layouts.app')

@php
    $available = $statusCounts[\App\Models\Legacy\Product::STATUS_AVAILABLE] ?? 0;
    $attention = $statusCounts[\App\Models\Legacy\Product::STATUS_ATTENTION] ?? 0;
    $critical = $statusCounts[\App\Models\Legacy\Product::STATUS_CRITICAL] ?? 0;
@endphp

@section('content')
<div class="page-heading">
    <div>
        <div class="page-kicker">Controle diário de hotelaria</div>
        <h1 class="page-title">Dashboard de abastecimento</h1>
        <p class="page-caption">Visão executiva dos itens que sustentam a experiência Eucabanas: gastronomia, limpeza, amenities e reposição operacional.</p>
    </div>
    <div class="d-flex gap-2">
        <a class="btn btn-light" href="{{ route('products.index') }}">Atualizar estoque</a>
        @if (auth()->user()?->isAdmin())
            <a class="btn btn-primary" href="{{ route('purchases.pdf') }}">Gerar PDF de compras</a>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-xl-7">
        <div class="card executive-panel">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <div class="page-kicker text-white-50">Inventário ativo</div>
                        <h4 class="text-white mb-0">Produtos monitorados</h4>
                    </div>
                    <span class="badge bg-light text-dark">{{ $attention + $critical }} pedem atenção</span>
                </div>
                <div class="row align-items-center">
                    <div class="col-md-5 text-center">
                        <div class="metric-ring">
                            <div class="metric-ring-content">
                                <div class="metric-number">{{ $productsTotal }}</div>
                                <div class="metric-label">itens ativos</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="status-line">
                            <span class="status-label"><span class="status-dot bg-success"></span>Saldo Disponível</span>
                            <span class="status-count">{{ $available }}</span>
                        </div>
                        <div class="status-line">
                            <span class="status-label"><span class="status-dot bg-warning"></span>Saldo em Atenção</span>
                            <span class="status-count">{{ $attention }}</span>
                        </div>
                        <div class="status-line">
                            <span class="status-label"><span class="status-dot bg-danger"></span>Saldo Crítico</span>
                            <span class="status-count">{{ $critical }}</span>
                        </div>
                    </div>
                </div>
                <h5 class="mt-4 text-white">Itens com saldo crítico</h5>
                <div class="table-responsive priority-table">
                    <table class="table table-sm">
                        <thead><tr><th>Produto</th><th>Família</th><th>Qtde</th><th>Criticidade</th></tr></thead>
                        <tbody>
                        @forelse ($purchaseProducts as $product)
                            <tr>
                                <td>{{ $product->prod_name }}</td>
                                <td>{{ $product->prod_family }}</td>
                                <td>{{ $product->prod_qtde }}</td>
                                <td><span class="badge {{ $product->purchaseStatusBadgeClass() }}">{{ $product->purchaseStatusLabel() }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="4">Nenhum item com saldo crítico no momento.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if (auth()->user()?->isAdmin())
        <div class="col-xl-5">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <div class="page-kicker">Auditoria</div>
                            <h4 class="mb-0">Atividades recentes</h4>
                        </div>
                        <a class="btn btn-sm btn-light" href="{{ route('logs.index') }}">Ver tudo</a>
                    </div>
                    @forelse ($logs as $log)
                        <div class="activity-item">
                            <div class="activity-action">{{ strtok($log->log_id_movimento, ' -') }}</div>
                            <div>{{ $log->log_id_movimento }}</div>
                            <small class="text-muted">
                                {{ blank($log->log_data) ? '-' : \Carbon\Carbon::parse($log->log_data)->format('d/m/Y H:i') }}
                                @if ($log->user)
                                    · {{ $log->user->name }}
                                @endif
                            </small>
                        </div>
                    @empty
                        <p class="mb-0">Nenhuma atividade encontrada.</p>
                    @endforelse
                </div>
            </div>
        </div>
    @else
        <div class="col-xl-5">
            <div class="card">
                <div class="card-body">
                    <div class="page-kicker">Operação</div>
                    <h4>Rotina de atualização</h4>
                    <p class="text-muted mb-3">Atualize quantidades, validade e detalhes dos itens usados no dia. A administração acompanha automaticamente o que entrou em atenção ou crítico.</p>
                    <a class="btn btn-primary" href="{{ route('products.index') }}">Atualizar produtos</a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
