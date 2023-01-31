@extends('Maestra')

@section('css')
<title>Clientes</title>
@endsection

@section('contenido')
<div aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('clientes')}}">Clientes</a></li>
        <li class="breadcrumb-item active" aria-current="page">Nuevo Cliente</li>
    </ol>
</div>
@if ( session('Excelente') )
<div class="alert alert-success" role="alert">
    <strong>Felicitaciones, </strong>
    Datos agregados correctamente..
</div>
@endif
@if ( session('Error') )
<div class="alert alert-danger" role="alert">
    <strong>Error, </strong>
    ocurrió un error en la carga.
</div>
@endif

<div class="d-flex justify-content-center px-md-5">
    <form id="formulario-clientes" class="mx-md-5" method="POST" enctype="multipart/form-data" action="{{ route('agregar-cliente')}}">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="validationDefault01">Nombre</label>
                <input type="text" class="form-control" id="txtNombre" placeholder="Nombre" name="Nombre" required>
                @error('Nombre')
                <span class="invalid-feedback" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="validationDefault02">Apellido</label>
                <input type="text" class="form-control" id="txtApellido" placeholder="Apellido" name="Apellido" required>
                @error('Apellido')
                <span class="invalid-feedback" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>
            <div class="col-md-12 mb-3">
                <label for="Zona">Zona o Ruta</label>
                <select class="form-select" name="Zona" id="txtZona" required>
                    <option disabled selected>--Seleccione--</option>
                    <option value="Panamericana">Panamericana</option>
                    <option value="Barinas">Barinas</option>
                </select>
                @error('Zona')
                <span class="invalid-feedback" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>
            <div class="col-md-12 mb-3">
                <label for="validationDefault03">Direccion</label>
                <input type="text" class="form-control" id="txtDireccion" placeholder="Direccion" name="Direccion" required>
                @error('Direccion')
                <span class="invalid-feedback" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="validationDefaultUsername">Identificador</label>
                <div class="input-group has-validation">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroupPrepend2"><i class="las la-feather fs-4"></i></span>
                    </div>
                    <input type="text" class="form-control @error('Identificador') is-invalid @enderror" id="txtIdentificador"  name="Identificador" required>
                    @error('Identificador')
                    <span class="invalid-feedback" role="alert">
                        <strong>Error, éste Identificador ya existe.</strong> 
                    </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="validationDefault04">Telefono</label>
                <input type="number" class="form-control" id="txtTelefono" placeholder="Telefono" name="Telefono" required>
                @error('Telefono')
                <span class="invalid-feedback" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>
            <div class="col-12">
                <input type="submit" class="btn btn-primary w-100">
            </div>
        </div>
    </form>
</div>
@endsection