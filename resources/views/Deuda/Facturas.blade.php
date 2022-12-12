@extends('Maestra')

@section('css')

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<title>Facturas</title>
@endsection

@section('contenido')

<div>
    <table id="example" class="table table-striped display nowrap" cellspacing="0" style="width:100%">
        <thead class="bg-primary text-white">
            <tr>
                <th>Factura</th>
                <th>Fecha</th>
                <th>Venta</th>
                <th>Pagos</th>
                <th>Estado</th>
                <th>Opciones</th>
            </tr>
            </tr>
        </thead>
        <tbody id="tabla-cobranza">
            @foreach ($Factura as $factura )
            <tr>
                <td>00{{$factura->id}}</td>
                <td> {{$factura->Fecha}}</td>
                <td> {{number_format ($factura->VendidoA,2)}}</td>
                <td> {{number_format ($factura->VendidoB,2)}}</td>
                @if (($factura->Estado) == 'Cancelada')
                <td> <span class="badge bg-secondary h4">Cancelada</span></td>
                @else
                <td> <span class="badge bg-success h4">Credito</span></td>
                @endif

                <td> <div class="btn-group">

                    <a href="{{route('eliminar.deuda',[$factura->id])}}" class="btn-group btn btn-danger" value="{{$factura->id}}" id="btnborrar">Borrar</a>
                    <a href="{{route('detalles.deuda',[$factura->idProveedor,$factura->id])}}" class="btn btn-info btn-group" value="{{$factura->id}}" id="btnver">Ver</a>
                    <a href="{{route('deuda.generarpdf',[$factura->idProveedor,$factura->id])}}" class="btn btn-warning btn-group" value="{{$factura->id}}" target="_blank" id="btnver">Ver</a>
                </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
< @endsection @section('js') <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js">
    </script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#example').DataTable({
                responsive: true,
                "language": {
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "zeroRecords": "No hay datos - Disculpa",
                    "info": "Página _PAGE_ de _PAGES_",
                    "infoEmpty": "No records available",
                    "infoFiltered": "(filtrado por _MAX_ registros totales)",
                    "search": "Buscar:",
                    "paginate": {
                        "next": "Siguiente",
                        "previous": "Anterior"

                    },
                }
            });

        });
    </script>
    <script>
        $(document).on('click', '#btnborrar', function(e) {
            e.preventDefault();

            var link = $(this).attr('href');

            Swal.fire({
                title: 'Seguro?',
                text: "Borrar una compra eliminará los detalles y quitará los productos agregados!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, quiero hacerlo!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'GET',
                        url: link,
                        success: function(response) {
                            Swal.fire(
                                'Borrado!',
                                'Excelente.',
                                'success'
                            );
                        },
                        error: function() {
                            Swal.fire(
                                'Algo esta mal.',
                                'Vuelve a intentarlo más tarde',
                                'error'
                            )
                        }
                    });
                }
            })

        });
    </script>
    @endsection