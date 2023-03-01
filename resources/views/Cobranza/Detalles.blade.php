@extends('Maestra')

@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Facturas</title>
@endsection

@section('contenido')
<div class="row">
    @foreach ($factura as $info)
    <div class="col-12 col-md-4 text-center">
        <p><span class="h6"> NUMERO FACTURA :</span> <input type="text" size="10px" class="form-control" id="factura" value="{{$info->id}}" id="idFactura"></p>
        @if ($info->estado== 'Cancelada')
        <td> <span class="badge bg-secondary h4">CANCELADA</span></td>
        @else
        <td> <span class="badge bg-warning h4">EN PROCESO</span></td>
        @endif
    </div>

    <div class="col-12 col-md-8 d-md-flex">
        <div class="row">
            <div class="col-12 col-md-3 text-center">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" width="235px" height="auto">
            </div>
            <div class="col-12 col-md-9 text-end">
                <h3 class="text-capitalice">Auntoplast Urbina</h3>
                <h4>Excelenca y calidad a tu Alcance</h4>
                <hr>
                <p>Sector 5 de julio, Capacho Libertad, Estado Tachira Venezuela</p>
                <p>Telefono: 04147487500</p>
                <p>Instagram: AutoplastUrbina</p>

                <a class="btn btn-danger" href="{{ route('generarpdf',[$info->idCliente,$info->id]) }}" target="_blank">PDF</a>
            </div>

        </div>

    </div>
    <div class="col-6 mb-4">
        <p><span> Nomre :</span>{{$info->nombre}}</p>
        <p><span> Apellido :</span>{{$info->apellido}}</p>
        <p><span> # :</span>{{$info->identificador}}</p>
    </div>
    <div class="col-6 mb-4">
        <p><span> Direccion:</span>{{$info->direccion}}</p>
        <p><span> Telefono :</span>{{$info->telefono}}</p>
        <p><span> Fecha :</span>{{$info->fecha}}</p>
    </div>
    <div class="col-12">

        <div class="table-responsive">

            <table class=" table table-hover table-bordered caption-top" cellspacing="0" style="width:100%">
                <caption>Detalles..</caption>
                <thead>
                    <tr>
                        <th class="tb-detalles">Producto</th>
                        <th class="tb-cc">Cantidad</th>
                        <th class="tb-cc">Unidad</th>
                        <th>Precio</th>
                        <th>Total</th>
                    </tr>
                    </tr>
                </thead>
                <tbody id="tabla-cobranza">

                    @foreach ($productos as $detalle )
                    <tr>
                        <td> {{$detalle->Producto->detalles}}</td>
                        <td> {{$detalle->cantidad}}</td>
                        <td> {{$detalle->Producto->unidad}}</td>
                        <td> {{number_format($detalle->precio,2)}}</td>
                        <td> {{number_format($detalle->total,2)}}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>

                    @if ($info->vendido_A==0)

                    <tr>
                        <td colspan="3"></td>
                        <td>Total :</td>
                        <td>{{number_format($info->vendido_B,2)}}</td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td>Pagado :</td>
                        <td>{{number_format($info->pagado_B,2)}}</td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td>Resta :</td>
                        <td><input type="text" class="form-control" id="deuda" disabled value="{{number_format($info->vendido_B-$info->pagado_B,2)}}"></td>
                    </tr>
                    @else
                    <tr>
                        <td colspan="3"></td>
                        <td>Total :</td>
                        <td>{{number_format($info->vendido_A,2)}}</td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td>Pagado :</td>
                        <td>{{number_format($info->pagado_A,2)}}</td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td>Resta :</td>
                        <td><input type="text" class="form-control" id="deuda" disabled value="{{number_format($info->vendido_A-$info->pagado_A,2)}}"></td>
                    </tr>

                    @endif
                </tfoot>
            </table>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 col-md-5 ">

            <div class="card text-center">
                <div class="card-header">
                    Pagos realizados
                </div>
                <div class="card-body">
                    <h5 class="card-title">Abonos</h5>
                    <p class="card-text">Se observa el historal de abonos realzados</p>

                    @if ($info->estado == 'Credito')

                    <button type="button" class="btn btn-success" onclick="deuda()" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Agregar</button>
                    @endif

                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Monto</th>
                            </tr>
                        </thead>
                        <tbody id="table-body-deudas">

                        </tbody>
                    </table>
                </div>
                <div class="card-footer ">
                    Los abonos serán procesados al instante..
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>



<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">


            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="formulario-abono" method="POST" enctype="multipart/form-data" action="{{route('crear.abonos')}}">
                    @csrf
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Fecha:</label>
                        <input type="date" class="form-control" id="txtFecha" name="Fecha" required>
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Deuda:</label>
                        <input type="number" readonly class="form-control" name="Deuda" id="txtDeuda">
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Abono:</label>
                        <input type="text" class="form-control" id="txtAbono" name="Monto" value="0">
                    </div>
                    <input type="text" name="idFactura" class="d-none" value="{{$info->id}}">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection

@section('js')


<script>
    $(document).ready(function() {
        cargarTabla();
    });


    function cargarTabla() {
        let id = $('#factura').val();
        let url = "{{route('cargar.abonos',['id'])}}";
        url = url.replace('id', id);
        $.ajax({
            type: 'GET',
            url: url,
            dataType: 'json',
            success: function(response) {

                var llenado = '';
                $.each(response, (index, item) => {
                    llenado += '<tr><td>' + (index + 1) + '</td><td>' + item.fecha + '</td><td>' + item.monto.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }) + '</td></tr>';

                });
                $('#table-body-deudas').append(llenado);

            },
            error: function(response) {
                console.log(response.Mensaje);

                console.log('algomal');
            }
        });
    }

    function deuda() {
        var deuda = parseFloat($('#deuda').val().replace(/,/g, ''), 10);
        $('#txtDeuda').val(deuda);

    }
</script>
@endsection