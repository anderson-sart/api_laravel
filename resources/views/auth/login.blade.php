@extends('layouts.app')

@section('content')
<div class="container mt-5 h-100">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    <!-- Adiciona uma imagem ao topo do formulário -->
                    <div class="text-center mb-4">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo Brilliance" class="img-fluid" style="max-width: 150px;" />
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Usuário') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<style>
    html, body {
        height: 100%;
        background: linear-gradient(180deg, #6a6e49, 
        rgba(30, 99, 164, .046875) 99.99%, 
        rgba(30, 99, 164, 0));
    }

    .container.h-100 {
        height: 100%;
    }

    .row.align-items-center {
        height: 100%;
    }

</style>
@endsection