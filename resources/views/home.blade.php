@extends('layouts.app')

@section('content')
<div class="container bg-white custom-rounded  mt-2 pt-2" style="height: 300px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <!-- Link para a rota de pedidos -->
                    <a href="{{ route('sales.index') }}">Ver Pedidos</a>
                    <p>Você está logado!</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
