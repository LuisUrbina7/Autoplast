<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .tabla-title {
            background: #212529;
            ;
            color: #ffff;
        }

        .tabla-subtitle {
            margin-top: 10px;
            margin-bottom: 10px;
            padding-left: 1.4rem;
            background: #ebebeb;
            color: #212529;
        }
        .tabla-subtitle h4{
            margin-top: 10px;
            margin-bottom: 10px;
            padding-left: 1.4rem;
            
        }

        .footer {
            background: #212529;
            ;
            color: #ffff;
        }

        .text-end {
            text-align: end;
            text-align: right;
        }

        .tle {
            line-height: 10px;
            font-weight: 700;
            font-size: small;
            color: #514f4f;
        }

        span {
            letter-spacing: 2px;
        }
    </style>

    <title>Cobranza</title>

</head>

<body>
    <div style="text-align:center ;">
        <h2>TOTAL PEDIDOS POR CLIENTES</h2>
        <hr>
        <div>
            <h4 class="tle">Consutal realizada por: <span>{{Auth::user()->name}}</span></h4>
            <h4 class="tle">Usuario: <span>{{Auth::user()->username}}</span></h4>
        </div>

    </div>

    <table style="width: 100%; margin-bottom:20px;" cellpadding="0" cellspacing="0">
        <thead>

            <tr>
                 <th>Desde:</th>
                <th>{{$Fechas['Inicio']}}</th>
                <th>Hasta:</th>
                <th>{{$Fechas['Fin']}}</th>
            </tr>


        </thead>
    </table>
    <table class="table table-hover table-bordered " style="width: 100%;" cellpadding="0" cellspacing="0">
        <thead class="tabla-title">
            <tr>

                <th colspan="2">Pedidos</th>
            </tr>
        </thead>
        <tbody id="tabla">

            @foreach ($nombref as $n)
            <tr class="tabla-subtitle">
                <td>
                    <div>
                        <h4 style="margin-top: 10px;">  CLIENTE: {{$n}}</h4>
                    </div>
                </td>
                <td></td>
            </tr>
            @foreach ($data as $pedidos )
            @if ($n == $pedidos->Cliente)

            <tr>

                <td>{{$pedidos->DetallesTem}}</td>
                <td class="text-end">{{$pedidos->Cantidad}}</td>

            </tr>
            @endif
            @endforeach
            @endforeach


        </tbody>
        <tfoot class="footer">
            <tr>
                <td colspan="2">Total</td>
                <td id="totalabono" class="text-end"></td>
                <td id="totalventa" class="text-end"></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
    <div>
        <p>*Se adjunta una estimacion relativa del costo de los pedidos, expresados en COL*</p>
    </div>

    </script>

</body>

</html>