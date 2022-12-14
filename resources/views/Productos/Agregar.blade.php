@extends('Maestra')

@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<title>Productos</title>
@endsection

@section('contenido')

@php
    $Fecha=date("Y-m-d");
@endphp
<div aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('productos')}}">Productos</a></li>
        <li class="breadcrumb-item active" aria-current="page">Nuevo Producto</li>
    </ol>
</div>
<div class="d-flex justify-content-center ">
    <form id="formulario-productos" method="POST" class="mx-md-5" enctype="multipart/form-data" action="{{ route('agregar-productos')}}">
       @csrf
        <div class="row">
            <div class="col-md-7 mb-3">
                <label for="validationDefault01">Descripcion</label>
                <input type="text" class="form-control" id="txtDetalles" placeholder="Nombre" name="Detalles" required>
            </div>
              <div class="col-md-3 mb-3">
                <label for="idUnidad">Unidad :</label>
                <select class="form-select" id="idUnidad" name="idUnidad">
                    <option value="Millar">--Millar--</option>
                    <option value="Tiras">--Tiras--</option>
                    <option value="Bulto">--Bulto--</option>
                </select>
            </div>
            <div class="col-md-2 mb-3">
                <label for="validationDefault02">Stock</label>
                <input type="text" class="form-control" id="txtStock" placeholder="Apellido" name="Stock" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="validationDefault02">Precio de Compra</label>
                <input type="text" class="form-control" id="txtPrecioCompra" placeholder="Precio de costo" name="PrecioCompra" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="validationDefault02">Precio Venta</label>
                <input type="text" class="form-control" id="txtPrecioVenta" placeholder="Precio a vender" name="PrecioVenta" required>
            </div>
            <div class="col-md-12 mb-3">
                <label for="validationDefaultUsername">Fecha</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroupPrepend2">@</span>
                    </div>
                    <input type="date" class="form-control" id="txtFecha" name="Fecha" value="{{$Fecha}}">
                </div>
            </div>
    
            <div class="col-md-6 mb-3">
                <label for="idProveedor">Proveedor</label>
                <select class="form-select" aria-label="Default select example" id="txtProveedor" name="idProveedor">
                    <option selected disabled>--Selecione--</option>
                    @foreach ($Proveedor as $Pro )
                    <option value="{{$Pro->id}}">{{$Pro->Nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="idCategoria">Categoria</label>
                <select class="form-select" aria-label="Default select example" id="txtCategoria" name="idCategoria">
                    <option selected disabled>--Selecione--</option>
                    @foreach ($Categoria as $C )
                    <option value="{{$C->id}}">{{$C->Descripcion}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <button class="btn btn-primary w-100" id="btnagregar">Guardar</button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('js')

<script>
    $('#btnagregar').on('click', function(e) {
        e.preventDefault();
        var formurl = $('#formulario-productos').attr('action');
        var datos = $('#formulario-productos').serialize();
        
        if ( $('#txtCodigo').val()!='' &&
        $('#txtDetalles').val()!='' &&
        $('#txtPrecioCompra').val()!='' &&
        $('#txtPrecioVenta').val()!='' &&
        $('#txtFecha').val()!='' &&
        $('#txtProveedor').val()!='' &&
        $('#txtCategoria').val()!='' &&  $('#txtCategoria').val()!=null &&  $('#txtProveedor').val()!=null) {
            
           
            $.ajax({
                type: 'POST',
                url: formurl,
                data: datos,
                dataType: 'json',
                success: function(response) {
                    console.log(response.Mensaje);
                    Swal.fire(
                             'Guardado!',
                             'La factura ha sido cargada',
                             'success'
                         );
                  limpiar(); 
                },error:function(response) {
                    console.log(response);
                        Swal.fire(
                             'Ops!',
                             'Ocurri?? un error',
                             'error',
                         );
                    }
            });

        } else {
            Swal.fire(
                    'Error!',
                    'Faltan datos',
                    'error',
                );
        }
    })

    function limpiar() {
        $('#txtDetalles').val('');
        $('#txtPrecioCompra').val('');
        $('#txtPrecioVenta').val('');
        $('#txtStock').val('');
        $('#txtProveedor').val('');
        $('#txtCategoria').val('');
    }
</script>
@endsection