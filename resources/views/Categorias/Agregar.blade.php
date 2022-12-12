@extends('Maestra')

@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Proveedores</title>
@endsection

@section('contenido')

<form id="formulario-proveedores" method="POST" enctype="multipart/form-data" action="{{ route('agregar-proveedores')}}">
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
    <button class="btn btn-primary" id="btnagregar">Guardar</button>
</form>
@endsection

@section('js')

<script>
    $('#btnagregar').on('click', function(e) {
        e.preventDefault();

        let formurl = $('#formulario-proveedores').attr('action');
        let datos = $('#formulario-proveedores').serialize();


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
                console.log(response.Mensaje);
                limpiar();
            }



        });


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