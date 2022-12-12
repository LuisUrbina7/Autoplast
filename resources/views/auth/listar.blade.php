@extends('Maestra')

@section('css')

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Perfil</title>
@endsection

@section('contenido')

@if ( session('success') )
<div class="alert alert-success" role="alert">
    <strong> {{ session('success') }}</strong>
</div>
@endif
@if ( session('error') )
<div class="alert alert-success" role="alert">
    <strong>Felicitaciones {{ session('error') }}</strong>
</div>
@endif
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
        <li class="breadcrumb-item active" aria-current="page">Clientes</li>
    </ol>
    </div>
<div class="row justify-content-center overflow-scroll">
    <div class="col-md-12">
        <table class="table" id="tabla">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Usuario</th>
                    <th scope="col">Email</th>
                    <th scope="col">Rol</th>
                    <th scope="col">Opciones</th>

                </tr>
            </thead>
            <tbody>
             
                @foreach ($Usuarios as $Usuario)

                <tr>
                    <th scope="row" class="id">{{$Usuario->id}}</th>
                    <td class="name">{{$Usuario->name}}</td>
                    <td class="username">{{$Usuario->username}}</td>
                    <td class="email">{{$Usuario->email}}</td>
                    <td class="rol">{{$Usuario->rol}}</td>
                    <td><a class="btn btn-success"  id="editarr" data-bs-toggle="modal" data-bs-target="#exampleModal">Edtar</a>
                        <a href="{{ route('borrar.usuario',$Usuario->id) }}" class="btn btn-danger">Borrar</a>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('usuario.actualizar') }}" enctype="multipart/form-data">
                    @csrf
                    <input class="d-none" type="text" id="id" name="id">     
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nombre') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" required autocomplete="name" autofocus>

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
                            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="" required autocomplete="username" autofocus>

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
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="" required autocomplete="email">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                   

                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Rol') }}</label>

                        <div class="col-md-6">
                            <select class="form-select @error('rol') is-invalid @enderror" aria-label="Default select example" id="rol" name="rol" value="Hola" required>
                                <option value="adm">Administrador</option>
                                <option value="vdr">Vendedor</option>
                            </select>

                            @error('rol')
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection
@section('js')
<script>
    $(document).on('click', '#editarr', function() {
        var fila = $(this).parents("tr");
        var datos = {
            id: fila.find(".id").html(),
            name: fila.find(".name").html(),
            username: fila.find(".username").html(),
            email: fila.find(".email").html(),
            rol: fila.find(".rol").html()
        };
        $('#id').val(datos['id']);
        $('#name').val(datos['name']);
        $('#username').val(datos['username']);
        $('#email').val(datos['email']);
        $('#rol').val(datos['rol']);
        console.log(datos['id']);
    });


  
</script>
@endsection