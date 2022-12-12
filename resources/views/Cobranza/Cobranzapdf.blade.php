<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400&display=swap" rel="stylesheet">
    <title>Document</title>
    <style>
        * {
            font-family: 'Open Sans', sans-serif;
        }

        .tb-detalles {
            width: 50%;
        }

        .tb-cc {
            width: 8%;
        }

        .invoice-box {
            background-color: #fff;
            color: #2a2a2a;
            font-size: 16px;
            height: auto;
            line-height: 24px;
            margin: 0 auto;
            max-width: 21.5cm;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .items-table td {
            padding: 5px;
            vertical-align: top;
            border-bottom: 1px solid #eee;
        }

        .items-table th {
            padding: 5px;
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .items-table .total {
            border-top: 2px solid #eee;
            font-weight: bold;
            text-align: right;
        }

        .w-25 {
            width: 25%;
        }

        .w-50 {
            width: 50%;
        }

        .w-75 {
            width: 75%;
        }

        .w-100 {
            width: 100%;
        }

        .mt {
            margin-top: 1cm;
        }

        .bold {
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;

        }

        .options {
            padding: 1rem 0;
            text-align: center;
        }

        .button {
            border: none;
            color: #fff;
            padding: 0.5rem;
            border-radius: 5px;
            background-color: #6abe84;
            text-decoration: none;
            font-size: 1rem;
            display: inline-block;
        }

        .tabla-title {
            background: #1c4598;
            color: #fefefe;
        }

        .text-align-end {
            text-align: end;
            line-height: 18px;
        }

        .px-2 {
            padding: 0 10px;
        }

        .lh-2 {
            line-height: 1rem;
        }

        @media print {
            .invoice-box {
                margin: 0;
                padding: 0;
            }

            .options {
                display: none;
            }
        }

        @page {
            margin: 0.8cm;
        }
    </style>
</head>

<body>

    <div class="invoice-box">
        @foreach ($facturas as $factura)
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td class="w-25 text-center">
                    <p><span class="h6"> NUMERO FACTURA :</span> <input type="text" size="10px" class="form-control" id="factura" value="{{$factura->id}}" id="idFactura"></p>
                    @if (($factura->Estado)=='Cancelada')
                    <span class="badge bg-secondary h4">CANCELADA</span>
                    @else
                    <span class="badge bg-warning h4">EN PROCESO</span>
                    @endif
                </td>
                <td class="text-center w-25">
                    <div style="display: flex;position: relative;">

                        <img src="{{ asset('img/logo.png') }}" style="position: absolute;top: -86px;left: 30px;z-index: 1;" alt="Logo" width="235px" height="auto">
                    </div>
                </td>
                <td class=" w-50" style="z-index: 2;position: relative;">
                    <div style="text-align: right;">
                        <h3 class="text-capitalice">Auntoplast Urbina</h3>
                        <h4>Excelenca y calidad a tu Alcance</h4>
                        <hr>
                        <p>Sector 5 de julio, Capacho Libertad, Estado Tachira Venezuela</p>
                        <p> <span class="bold">Telefono: </span> 04147487500</p>
                        <p>Instagram: AutoplastUrbina</p>
                    </div>
                </td>
            </tr>
        </table>
        @foreach ($clientes as $datos)
        <div class="text-center">
            <h4> **Detalles de la venta realizada** ({{$datos->Zona}})</h4>
        </div>
        <table class="mt" cellpadding="0" cellspacing="0">
            <tr>
                <td class="w-50 px-2 lh-2">
                    <p><span class="bold"> Nomre :</span>{{$datos->Nombre}}</p>
                    <p><span class="bold"> Apellido :</span>{{$datos->Apellido}}</p>
                    <p><span> # :</span>{{$datos->Identificador}}</p>
                </td>

                <td class="w-50 px-2 lh-2">
                    <p><span class="bold"> Direccion:</span>{{$datos->Direccion}}</p>
                    <p><span class="bold"> Telefono :</span>{{$datos->Telefono}}</p>
                    <p><span class="bold"> Fecha :</span>{{$factura->Fecha}}</p>
                </td>
            </tr>
            @endforeach
        </table>

        <table class=" table table-hover table-bordered " cellspacing="0" style="width:100%">

            <thead class="tabla-title">
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

                @foreach ($detalles as $detalle )
                <tr>
                    <td> {{$detalle->Producto->Detalles}}</td>
                    <td> {{$detalle->Cantidad}}</td>
                    <td> {{$detalle->Producto->Unidad}}</td>
                    <td> {{number_format($detalle->Precio,2)}}</td>
                    <td> {{number_format($detalle->Total,2)}}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
            @if ($factura->VendidoA==0)
                
                <tr>
                    <td colspan="2"></td>
                    <td>Total :</td>
                    <td>{{number_format($factura->VendidoB,2)}}</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td>Pagado :</td>
                    <td>{{number_format($factura->PagadoB,2)}}</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td>Diferencia :</td>
                    <td><input type="text" class="form-control" id="deuda" disabled value="{{number_format($factura->VendidoB-$factura->PagadoB,2)}}"></td>
                </tr>
                @else
                <tr>
                    <td colspan="2"></td>
                    <td>Total :</td>
                    <td>{{number_format($factura->VendidoA,2)}}</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td>Pagado :</td>
                    <td>{{number_format($factura->PagadoA,2)}}</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td>Diferencia :</td>
                    <td><input type="text" class="form-control" id="deuda" disabled  value="{{number_format($factura->VendidoA-$factura->PagadoA)}}"></td>
                </tr>
                    
                @endif
            </tfoot>
        </table>

        <div class="text-center" style="margin-top: 30px;">
            *Lorem ipsum dolor, sit amet consectetur adipisicing elit. Distinctio in quae laborum eligendi soluta hic quas reprehenderit molestiae facilis voluptatibus?*
            <hr class="w-50 bold">
        </div>
    </div>
    
    @endforeach
</body>

</html>