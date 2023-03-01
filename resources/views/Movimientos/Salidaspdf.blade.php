<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   <style>
    .tabla-title {
            background: #1c4598;
            color: #fefefe;
        }

        .footer{
            background: #1c4598;
            color: #fefefe;
        }
   </style>
   
    <title>Cobranza</title>

</head>

<body>
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
                        <th scope="col">Fecha</th>
                        <th scope="col">Nombre</th>
                        <th colspan="2" class="text-center" style="width: 10%;" scope="col">COL</th>
                        <th colspan="2" class="text-center" style="width: 10%;" scope="col">USD</th>
                        <th scope="col">Estado</th>
                    </tr>
                </thead>
                <tbody id="tabla">
                    @php
                        $vendidoA=0;
                        $abonadoA=0;
                        $vendidoB=0;
                        $abonadoB=0;
                    @endphp
                    @foreach ($Facturas as $Factura )
                    @php
                        $vendidoA+=$Factura->vendido_A;
                        $abonadoA+=$Factura->pagado_A;
                        $vendidoB+=$Factura->vendido_B;
                        $abonadoB+=$Factura->pagado_B;
                    @endphp
                     <tr>
                        <td>{{$Factura->id}}</td>
                        <td>{{$Factura->fecha}}</td>
                        <td>{{$Factura->nombre}}</td>
                        <td>{{number_format($Factura->vendido_A,2) }}</td>
                        <td>{{number_format($Factura->pagado_A,2) }}</td>
                        <td>{{number_format($Factura->vendido_B,2) }}</td>
                        <td>{{number_format($Factura->pagado_B,2) }}</td>
                        <td>{{$Factura->estado}}</td>
                     </tr>   
                    @endforeach
                </tbody>
                <tfoot class="footer">
                <tr>
                        <td colspan="3">Total</td>
                        <td id="totalventa">{{number_format($vendidoA,2) }}</td>
                        <td  id="totalabono">{{number_format($abonadoA,2)}}</td>
                        <td id="totalventa">{{number_format($vendidoB,2) }}</td>
                        <td  id="totalabono">{{number_format($abonadoB,2)}}</td>
                        <td ></td>
                    </tr>
                </tfoot>
            </table>
    
</script>
   
</body>
</html>

