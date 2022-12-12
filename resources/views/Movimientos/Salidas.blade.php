@extends('Maestra')

@section('css')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<title>Cobranza</title>
@endsection

@section('contenido')
<div aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">Cobranza</li>
    </ol>
</div>

<div class="d-flex justify-content-center px-md-5">
    <div class="row w-100">
        <div class="col">
            <input type="date" class="form-control" id="FechaInicio" name="FechaInicio" placeholder="First name" aria-label="First name">
        </div>
        <div class="col">
            <input type="date" class="form-control" id="FechaFin" name="FechaFin" placeholder="Last name" aria-label="Last name">
        </div>
        <div class="col-12 text-center">
            <a class="btn btn-warning w-25 mt-4" onclick="buscar()">Buscar</a>
            <a class="btn btn-danger w-25 mt-4" onclick="generarpdf()">Pdf</a>
        </div>
        <div class="d-flex justify-content-center mt-3">
            <div class="" role="status" id="spinner">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div id="contendor-tabla" class="col-12">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Nombre</th>
                        <th colspan="2" class="text-center" style="width: 10%;" scope="col">COL</th>
                        <th colspan="2" class="text-center" style="width: 10%;" scope="col">USD</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Ver</th>
                    </tr>
                </thead>
                <tbody id="tabla">
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3">Total</td>
                        <td id="totalventa"></td>
                        <td id="totalabono"></td>
                        <td id="totalventaB"></td>
                        <td id="totalabonoB"></td>
                        <td></td>




                    </tr>
                </tfoot>
            </table>
        </div>

    </div>

</div>
@endsection

@section('js')
<script>
    function generarpdf() {
        var Fecha1 = '';
        var Fecha2 = '';
        var url = "{{route('pdf.salidas',['fecha1','fecha2'])}}";

        Fecha1 = $('#FechaInicio').val();
        Fecha2 = $('#FechaFin').val();
        if (Fecha1 != '' && Fecha2 != '') {
            url = url.replace('fecha1', Fecha1);
            url = url.replace('fecha2', Fecha2);

            window.open(url, '_blank');
        } else {
            window.open(url, '_blank');

        }
    }

    function buscar() {
        var Fecha1 = '';
        var Fecha2 = '';
        var url = "{{route('buscar.salidas',['fecha1','fecha2'])}}";
        Fecha1 = $('#FechaInicio').val();
        Fecha2 = $('#FechaFin').val();

        if (Fecha1 != '' && Fecha2 != '') {
            url = url.replace('fecha1', Fecha1);
            url = url.replace('fecha2', Fecha2);
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                beforeSend: function(response) {
                     $('#spinner').addClass('spinner-border');  
                },
                success: function(response) {
                    $('#spinner').removeClass('spinner-border');  
                    console.log(response);
                    var contenido = '',
                        ventaA = 0,
                        abonoA = 0,
                        ventaB = 0,
                        abonoB = 0;


                    $.each(response, (index, item) => {
                        ventaA += item.VendidoA;
                        abonoA += item.PagadoA;
                        ventaB += item.VendidoB;
                        abonoB += item.PagadoB;
                        if (item.Estado == 'Cancelada') {
                            contenido += '<tr><td>' + item.id + '</td><td>' + item.Fecha + '</td><td>' + item.Nombre + '</td><td>' + item.VendidoA + '</td><td>' + item.PagadoA + '</td><td>' + item.VendidoB + '</td><td>' + item.PagadoB + '</td><td ><p class="badge bg-secondary">' + item.Estado + '</p></td><td><a href="../cobranza/zona/detalles/' + item.clientesid + '/' + item.id + '" class="btn btn-info text-white">ver</a></td></tr>';
                        } else {
                            contenido += '<tr><td>' + item.id + '</td><td>' + item.Fecha + '</td><td>' + item.Nombre + '</td><td>' + item.VendidoA + '</td><td>' + item.PagadoA + '</td><td>' + item.VendidoB + '</td><td>' + item.PagadoB + '</td><td ><p class="badge bg-warning text-dark">' + item.Estado + '</p></td><td><a href="../cobranza/zona/detalles/' + item.clientesid + '/' + item.id + '" class="btn btn-info text-white">ver</a></td></tr>';
                        }

                        console.log(contenido);
                    });

                    $('#tabla').html(contenido);
                    $('#totalventa').text(ventaA.toFixed(2))
                    $('#totalabono').text(abonoA.toFixed(2))
                    $('#totalventaB').text(ventaB.toFixed(2))
                    $('#totalabonoB').text(abonoB.toFixed(2))
                },
                error: function(response) {
                    $('#spinner').removeClass('spinner-border');  
                    Swal.fire(
                        'Error!',
                        'No hay datos.',
                        'error'
                    );
                }
            });
        } else {

            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                beforeSend: function(response) {
                     $('#spinner').addClass('spinner-border');  
                },
                success: function(response) {
                    $('#spinner').removeClass('spinner-border');  
                    console.log(response);
                    var contenido = '',
                        ventaA = 0,
                        abonoA = 0,
                        ventaB = 0,
                        abonoB = 0;


                    $.each(response, (index, item) => {
                        ventaA += item.VendidoA;
                        abonoA += item.PagadoA;
                        ventaB += item.VendidoB;
                        abonoB += item.PagadoB;
                        if (item.Estado == 'Cancelada') {
                            contenido += '<tr><td>' + item.id + '</td><td>' + item.Fecha + '</td><td>' + item.Nombre + '</td><td>' + item.VendidoA + '</td><td>' + item.PagadoA + '</td><td>' + item.VendidoB + '</td><td>' + item.PagadoB + '</td><td ><p class="badge bg-secondary">' + item.Estado + '</p></td><td><a href="../cobranza/zona/detalles/' + item.clientesid + '/' + item.id + '" class="btn btn-info text-white">ver</a></td></tr>';
                        } else {
                            contenido += '<tr><td>' + item.id + '</td><td>' + item.Fecha + '</td><td>' + item.Nombre + '</td><td>' + item.VendidoA + '</td><td>' + item.PagadoA + '</td><td>' + item.VendidoB + '</td><td>' + item.PagadoB + '</td><td ><p class="badge bg-warning text-dark">' + item.Estado + '</p></td><td><a href="../cobranza/zona/detalles/' + item.clientesid + '/' + item.id + '" class="btn btn-info text-white">ver</a></td></tr>';
                        }


                    });

                    $('#tabla').html(contenido);
                    $('#totalventa').text(ventaA.toFixed(2))
                    $('#totalabono').text(abonoA.toFixed(2))
                    $('#totalventaB').text(ventaB.toFixed(2))
                    $('#totalabonoB').text(abonoB.toFixed(2))

                },
                error: function(response) {
                    $('#spinner').removeClass('spinner-border');  
                    Swal.fire(
                        'Error!',
                        'No hay nada',
                        'error'
                    );
                }
            });
        }



    }
</script>
@endsection