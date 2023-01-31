@extends('Maestra')

@section('css')

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Perfil</title>
@endsection

@section('contenido')
@if ( session('name') )
<div class="alert alert-success" role="alert">
    <strong>Felicitaciones </strong>
    Nombre y rol modificados..
</div>
@endif
@if ( session('claveIncorrecta') )
<div class="alert alert-danger" role="alert">
    <strong>Lo siento!</strong> {{ session('claveIncorrecta') }}
</div>
@endif
@if ( session('pares') )
<div class="alert alert-danger" role="alert">
    <strong>Lo siento!</strong> {{ session('pares') }}
</div>
@endif
@if ( session('updateClave') )
<div class="alert alert-success" role="alert">
    <strong>Felicitaciones !</strong>
    {{ session('updateClave') }}
</div>
@endif
<div aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">Perfil</li>
    </ol>
    </div>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between">Actualizar
                @if (Auth::user()->rol == 'adm')
                <div class="btn-group" role="group">
                    <a href="{{ route('register') }}" class="btn btn-success"><i class="las la-user-plus fs-4"></i></a> 
                    <a href="{{ route('usuarios.lista') }}" class="btn btn-warning"><i class="las la-users fs-4"></i></a>
                </div>
            @endif 
        </div>

            <div class="card-body">
                <form method="POST" action="{{ route('usuarioPerfil.actualizar') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nombre') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ Auth::user()->name }}" required autocomplete="name" autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Usuario') }}</label>

                        <div class="col-md-6">
                            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ Auth::user()->username }}" required autocomplete="username" autofocus>

                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ Auth::user()->email }}" required autocomplete="email">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    @if (Auth::user()->rol == 'adm')
                        
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Rol') }}</label>

                        <div class="col-md-6">
                            <select class="form-select @error('rol') is-invalid @enderror" aria-label="Default select example" id="rol" name="rol" value="Hola" required>
                                <option value="{{ Auth::user()->rol }}" selected>{{ Auth::user()->rol }}</option>
                                <option value="adm">Administrador</option>
                                <option value="vdr">Vendedor</option>
                            </select>
                            <!--   <input id="rol" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus> -->

                            @error('rol')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    @endif
                    <div class="row mb-3">
                        <label for="oldpassword" class="col-md-4 col-form-label text-md-end">{{ __('Actual Contraseña') }}</label>

                        <div class="col-md-6">
                            <input id="oldpassword" type="password" class="form-control @error('oldpassword') is-invalid @enderror" name="oldpassword" autocomplete="new-password">

                            @error('oldpassword')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Nueva Contraseña') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirmar') }}</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-info">
                                {{ __('Actualizar') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection