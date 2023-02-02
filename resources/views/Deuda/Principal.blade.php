@extends('Maestra')

@section('css')

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.bootstrap.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Deudas</title>
@endsection

@section('contenido')
<div aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">Deudas</li>
    </ol>
</div>

<table id="example" class="table table-hover" cellspacing="0" style="width:100%">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>Proveedor</th>
            <th>COL</th>
            <th>USD</th>
            <th>Deuda</th>
            <th>Opciones</th>
        </tr>
        </tr>
    </thead>
    <tbody id="tabla-deuda">
        @php
        $contador=0;
        @endphp
        @foreach ($Proveedores as $Proveedor)
        @php
        $contador+=1;
        @endphp
        <tr>
            <td> {{$contador}}</td>
            <td> {{$Proveedor->Nombre}}</td>
            <td> {{number_format($Proveedor->COL,2) }}</td>
            <td> {{number_format($Proveedor->USD,2)}}</td>
            @if ($Proveedor->COL == 0 && $Proveedor->USD == 0 )
            <td> <span class="badge bg-success h4 etiqueta-uno">Solvente</span></td>
            @else
            <td> <span class="badge bg-danger h4 etiqueta-dos">Pendiente</span></td>
            @endif


            <td> <a href="{{route('facturas.deuda',[$Proveedor->id])}}" class="btn btn-primary" id="btneditar"><i class="las la-stream fs-4"></i></a>
            </td>
            @endforeach
    </tbody>
    <tfoot class="bg-primary text-white">
        <tr>
            <td colspan="2">Total : </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
        </tr>
    </tfoot>
</table>

@endsection

@section('js')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
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
            },
            "footerCallback": function(row, data, start, end, display) {

                total_pesos = this.api()
                    .column(2) //numero de columna a sumar
                    //.column(1, {page: 'current'})//para sumar solo la pagina actual
                    .data()
                    .reduce(function(a, b) {
                        if (typeof a === 'string') {
                            a = a.replace(/[^\d.-]/g, '') * 1;
                        }
                        if (typeof b === 'string') {
                            b = b.replace(/[^\d.-]/g, '') * 1;
                        }

                        return a + b;

                    }, 0);
                total_dolar = this.api()
                    .column(3)
                    .data()
                    .reduce(function(a, b) {
                        if (typeof a === 'string') {
                            a = a.replace(/[^\d.-]/g, '') * 1;
                        }
                        if (typeof b === 'string') {
                            b = b.replace(/[^\d.-]/g, '') * 1;
                        }

                        return a + b;

                    }, 0);

                $(this.api().column(2).footer()).html(total_pesos.toLocaleString('en-US',{minimumFractionDigits: 2, maximumFractionDigits: 2}));
                $(this.api().column(3).footer()).html(total_dolar.toLocaleString('en-US',{minimumFractionDigits: 2, maximumFractionDigits: 2}));

            }

        });

    });
</script>
<script>

</script>
@endsection