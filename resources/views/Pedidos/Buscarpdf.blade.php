<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .tabla-title {
            background: #ebebeb;;
            color: #212529;
        }

        .footer {
            background: #ebebeb;;
            color: #212529;
        }
        .text-end{
            text-align: end;
            text-align: right;
        }
        .tle{
            line-height: 10px;
            font-weight: 700;
          font-size: small;
          color:#514f4f;
        }
        span{
            letter-spacing: 2px;
        }
    </style>

    <title>Cobranza</title>

</head>

<body>
    <div style="text-align:center ;">
        <h2>TOTAL PEDIDOS EN PRODUCTOS</h2>
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
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Costo estimado</th>
            </tr>
        </thead>
        <tbody id="tabla">
            @php
            $x=0;
            $Cantidad=0;
            $Costo=0;
            @endphp
            @foreach ($data as $pedidos )
            @php
            $x++;
            $Cantidad+=$pedidos->Ccantidad;
            $Costo+=$pedidos->Total;

            @endphp
            <tr>
                <td>{{$x}}</td>
                <td>{{$pedidos->detalles}}</td>
                <td class="text-end">{{$pedidos->Cantidad}}</td>
                <td class="text-end">{{number_format($pedidos->Total) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot class="footer">
            <tr>
                <td colspan="2">Total</td>
                <td id="totalabono" class="text-end">{{$Cantidad}}</td>
                <td id="totalventa" class="text-end">{{number_format($Costo,2) }}</td>
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