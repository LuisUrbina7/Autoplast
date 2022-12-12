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
    <div class="d-flex justify-content-center px-md-5">
        <form id="formulario-proveedores" method="POST" class="mx-md-5" enctype="multipart/form-data" action="{{ route('agregar-proveedores')}}">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="validationDefault01">Nombre</label>
                    <input type="text" class="form-control" id="txtNombre" placeholder="Nombre" name="Nombre" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">Direccion</label>
                    <input type="text" class="form-control" id="txtDireccion" placeholder="Direccion" name="Direccion" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault04">Telefono</label>
                    <input type="text" class="form-control" id="txtTelefono" placeholder="Telefono" name="Telefono" required>
                </div>
            </div>
            <div class="col-12">
                <button class="btn btn-primary w-100" id="btnagregar">Guardar</button>
            </div>
        </form>
    </div>
@endsection

@section('js')

<script>
    $('#btnagregar').on('click', function(e) {
        e.preventDefault();

        let formurl = $('#formulario-proveedores').attr('action');
        let datos = $('#formulario-proveedores').serialize();
        if ($('#txtNombre').val()!=''&& $('#txtDireccion').val()!=''&&
        $('#txtTelefono').val()!='') {
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    
            $.ajax({
                type: 'POST',
                url: formurl,
                data: datos,
                dataType: 'json',
                success: function(response) {
                    Swal.fire(
                         'Guardado!',
                         'La factura ha sido cargada',
                         'success'
                     );
                     limpiar();
                },error:function(response) {
                    Swal.fire(
                         'Ops!',
                         'Ocurrió un error',
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



        alert(formurl);
        console.log(datos);
    })

    function limpiar() {
        $('#txtNombre').val('');
        $('#txtDireccion').val('');
        $('#txtTelefono').val('');
        $('#txtNombre').focus();
    }
</script>
@endsection