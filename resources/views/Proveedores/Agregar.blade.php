@extends('Maestra')

@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<title>Proveedores</title>
@endsection

@section('contenido')
<div aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('proveedores')}}">Proveedores</a></li>
        <li class="breadcrumb-item active" aria-current="page">Nuevo Proveedor</li>
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
    ocurrió un fallo en la carga.
</div>
@endif
<div class="d-flex justify-content-center px-md-5">
    <form id="formulario-proveedores" method="POST" class="mx-md-5" enctype="multipart/form-data" action="{{ route('agregar-proveedores')}}">
        @csrf
    <div class="row">
            <div class="col-md-12 mb-3">
                <label for="validationDefault01">Nombre</label>
                <input type="text" class="form-control @error('Nombre') is-invalid @enderror" id="txtNombre" placeholder="Nombre" name="Nombre" required>
                @error('Nombre')
                <span class="invalid-feedback" role="alert">
                    <strong>Error, éste nombre ya existe.</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="validationDefault03">Direccion</label>
                <input type="text" class="form-control" id="txtDireccion" placeholder="Direccion" name="Direccion" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="validationDefault04">Telefono</label>
                <input type="number" class="form-control" id="txtTelefono" placeholder="Telefono" name="Telefono" required>
            </div>
        </div>
        <div class="col-12">
            <input type="submit" class="btn btn-primary w-100"  value="Guardar">
        </div>
    </form>
</div>
@endsection

