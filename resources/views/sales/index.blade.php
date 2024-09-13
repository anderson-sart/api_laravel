@extends('layouts.app')

@section('content')
<div class="container-md container-fluid-md bg-white custom-rounded mt-2 pt-2">
    <h1>Lista de Pedidos</h1>

    <!-- Abas de Situação -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link {{ request('status') == '' ? 'active' : '' }}" href="{{ route('sales.index', array_merge(request()->except('status'), ['status' => ''])) }}">Todos</a>
        </li>
        @foreach ($statusMapping as $key => $value)
            <li class="nav-item">
                <a class="nav-link {{ request('status') == $key ? 'active' : '' }}" href="{{ route('sales.index', array_merge(request()->except('status'), ['status' => $key])) }}">{{ $value }}</a>
            </li>
        @endforeach
    </ul>

    <!-- Formulário de Busca -->
    <form method="GET" action="{{ route('sales.index') }}" class="mb-4">
        <div class="row">
            <input type="hidden" name="status" id="status" value="{{ request('status') }}">
            <!-- Filtro de Usuário -->
            <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2 col-xl-3 col-xxl-3">
                <div class="form-group">
                    <select name="user_id" class="form-control" style="appearance: auto;">
                        <option value="">Todos os Usuários</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- Campo de Busca -->
            <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2 col-xl-3 col-xxl-3">
                <div class="form-group">
                    <input type="text" name="search" class="form-control" placeholder="Filtrar" value="{{ request('search') }}">
                </div>
            </div>
            <!-- Número de itens por página -->
            <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2 col-xl-2 col-xxl-2">
                <div class="form-group">
                    <select name="per_page" class="form-control" style="appearance: auto;">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 por página</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 por página</option>
                        <option value="50" {{ request('per_page') == 50 || empty(request('per_page')) ? 'selected' : '' }}>50 por página</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 por página</option>
                    </select>
                </div>
            </div>
            <!-- Botão de Submissão -->
            <div class="col-xs-6 col-sm-6 col-md-2 col-lg-1 col-xl-1 col-xxl-1">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </div>
    </form>
    
    <table id="salesTable" class="table table-bordered dt-responsive nowrap mb-4 dataTable no-footer dtr-inline collapsed">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th>PDF</th>
                <th>Situação</th>
                <th>Data Pedido</th>
                <th class="d-none d-sm-table-cell">Usuário</th>
                <th class="d-none d-md-table-cell">Valor</th>
                <th class="d-none d-md-table-cell">Qtde</th>
                <th class="d-none d-lg-table-cell">Itens</th>
                <th class="d-none d-xl-table-cell">Cliente</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $index => $sale)
                <tr data-toggle="collapse" data-target="#details{{ $sale->id }}" aria-expanded="false" aria-controls="details{{ $sale->id }}" class="{{ $index % 2 == 1 ? 'fd_td' : '' }}">

                    <td>
                        <button class="btn btn-link px-1">
                            <i class="fa fa-chevron-down"></i>
                        </button>
                        {{ $sale->id }}
                    </td>
                    <td class="no-print">
                        <a href="{{ route('sales.print.pdf', $sale->id) }}" class="btn btn-secondary" target="_blank">PDF</a>
                    </td>
                    <td>{{ $statusMapping[$sale->status] ?? 'Status Desconhecido' }}</td>
                    <td>{{ \Carbon\Carbon::parse($sale->created_at)->format('d/m/Y') }}</td>
                    <td class="d-none d-sm-table-cell text-truncate">{{ $sale->user->name ?? 'Nome do usuário não disponível' }}</td>
                    <td class="d-none d-md-table-cell">{{ number_format($sale->saleItems->sum('total_amount_item'), 2, ',', '.') }}</td>
                    <td class="d-none d-md-table-cell">{{ $sale->saleItems->sum('quantity') }}</td>
                    <td class="d-none d-lg-table-cell">{{ $sale->saleItems->count() }}</td>
                    <td class="d-none d-xl-table-cell">
                        <span class="text-truncate" style="width: 400px; float: left;">
                        {{ $sale->customer->corporate_name ?? ($sale->customer_corporate_name ?? 'Nome do cliente não disponível') }}
                        </span>
                    </td>
                </tr>
                <tr id="details{{ $sale->id }}" class="collapse">
                    <td colspan="17">
                        <div class="card card-body">
                            <div class="row">
                                    <div class="col-md-6"><strong>ID:</strong> {{ $sale->id }}</div>
                                    <div class="col-md-6"><strong>PDF:</strong> <a href="{{ route('sales.print.pdf', $sale->id) }}" class="btn btn-secondary" target="_blank">PDF</a></div>
                                    <div class="col-md-6"><strong>Situação:</strong> {{ $statusMapping[$sale->status] ?? 'Status Desconhecido' }}</div>
                                    <div class="col-md-6"><strong>Data Pedido:</strong> {{ \Carbon\Carbon::parse($sale->created_at)->format('d/m/Y') }}</div>
                                    <div class="col-md-6"><strong>Usuário:</strong> {{ $sale->user->name ?? 'Nome do usuário não disponível' }}</div>
                                    <div class="col-md-6"><strong>Valor:</strong> {{ number_format($sale->saleItems->sum('total_amount_item'), 2, ',', '.') }}</div>
                                    <div class="col-md-6"><strong>Qtde:</strong> {{ $sale->saleItems->sum('quantity') }}</div>
                                    <div class="col-md-6"><strong>Itens:</strong> {{ $sale->saleItems->count() }}</div>
                                    <div class="col-md-6"><strong>Cliente:</strong> 
                                        {{ $sale->customer->nickname ?? ($sale->customer_corporate_name ?? 'Nome do cliente não disponível') }}
                                    </div>
                                    <div class="col-md-6"><strong>Vendedor:</strong> {{ $sale->seller->corporate_name ?? 'Nome do vendedor não disponível' }}</div>
                                    <div class="col-md-6"><strong>Venda Coletor:</strong> {{ $sale->sale_code }}</div>
                                    <div class="col-md-6"><strong>Id Base Coletor:</strong> {{ $sale->database_id }}</div>
                                    <div class="col-md-6"><strong>Data Inclusão:</strong> {{ $sale->formatted_emission_date }}</div>
                                    <div class="col-md-6"><strong>Data Entrega:</strong> {{ \Carbon\Carbon::parse($sale->saleItems->max('delivery_date'))->format('d/m/Y') }}</div>
                                    <div class="col-md-6"><strong>Valor Bruto:</strong> {{ number_format($sale->saleItems->sum('gross_total_amount_item'), 2, ',', '.') }}</div>
                                    <div class="col-md-6"><strong>Valor Líquido:</strong> {{ number_format($sale->saleItems->sum('total_amount_item'), 2, ',', '.') }}</div>
                                </div>
                            <!-- Adicione mais campos conforme necessário -->
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {!! $sales->appends(request()->input())->links() !!}
    </div>
</div>
@endsection

@section('scripts')
<style>
    .text-truncate {
        white-space: nowrap !important;
        overflow: hidden;
        text-overflow: ellipsis;
    }
   th, td {
        padding: 5px 9px; /* Ajuste o padding aqui conforme necessário */
        white-space: nowrap; /* Impede que o texto quebre em várias linhas */
        overflow: hidden; /* Oculta o texto que ultrapassar o limite da célula */
        text-overflow: ellipsis; /* Adiciona "..." no fim do texto que ultrapassar o limite */
    }
    table.dataTable thead th, table.dataTable thead td {
        padding: 5px 9px; /* Ajuste esses valores conforme necessário */
    }
    .custom-rounded {
        border-radius: 15px; /* Escolha o valor desejado */
    }
    .table-fixed {
        table-layout: fixed; /* Define um layout fixo para a tabela */
        width: 100%; /* Garante que a tabela ocupe 100% da largura da div */
    }
    .fd_td {
            background-color: #e0e0e0;
    }
</style>
<script>
    $(document).ready(function() {
 
    });
</script>
@endsection
