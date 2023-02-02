<?php

use App\Http\Controllers\AbonosController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CobranzaController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ComprasController;
use App\Http\Controllers\DeudaController;
use App\Http\Controllers\MovimientosController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\UsuariosController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('auth.login');
});

Route::get('/nada', function () {
    return view('Maestra');
});
Auth::routes();

Route::group(['middleware' => 'auth'], function () {  
Route::get('/clientes', [ClienteController::class,'index'])->name('clientes');
Route::get('/clientes/vista', [ClienteController::class,'view'])->name('agregar-cliente-vista');
Route::get('/clientes/lista', [ClienteController::class,'listar'])->name('clientes-tabla');
Route::post('/clientes/agregar', [ClienteController::class,'create'])->name('agregar-cliente');
Route::get('/clientes/eliminar/{id}', [ClienteController::class,'destroy'])->name('eliminar-cliente')->middleware('adm');
Route::post('/clientes/actualizar/{id}', [ClienteController::class,'update'])->name('actualizar-cliente')->middleware('adm');
Route::post('/clientes/importar',[ClienteController::class,'importar'])->name('clientes.importar');
Route::get('/clientes/modal/{id}', [ClienteController::class,'modal'])->name('modal.cliente');

Route::get('/proveedores', [ProveedoresController::class,'index'])->name('proveedores');
Route::get('/proveedores/vista', [ProveedoresController::class,'view'])->name('agregar-proveedores-vista');
Route::get('/proveedores/lista', [ProveedoresController::class,'listar'])->name('proveedores-tabla');
Route::post('/proveedores/agregar', [ProveedoresController::class,'create'])->name('agregar-proveedores');
Route::get('/proveedores/eliminar/{id}', [ProveedoresController::class,'destroy'])->name('eliminar-proveedores')->middleware('adm');
Route::get('/proveedores/modal/{id}', [ProveedoresController::class,'edit'])->name('modal-proveedores');
Route::post('/proveedores/actualizar/{id}', [ProveedoresController::class,'update'])->name('actualizar-proveedores')->middleware('adm');
Route::post('/proveedores/importar',[ProveedoresController::class,'importar'])->name('proveedores.importar');

Route::get('/categorias', [CategoriasController::class,'index'])->name('categorias');
Route::get('/categorias/lista', [CategoriasController::class,'listar'])->name('categorias-tabla');
Route::post('/categorias/agregar', [CategoriasController::class,'create'])->name('agregar-categorias');
Route::get('/categorias/eliminar/{id}', [CategoriasController::class,'destroy'])->name('eliminar-categorias')->middleware('adm');
Route::get('/categorias/modal/{id}', [CategoriasController::class,'edit'])->name('modal-categorias');
Route::post('/categorias/actualizar/{id}', [CategoriasController::class,'update'])->name('actualizar-categorias')->middleware('adm');

Route::get('/productos', [ProductoController::class ,'index'])->name('productos');
Route::get('/productos/vista', [ProductoController::class,'view'])->name('agregar-productos-vista');
Route::get('/productos/lista/{id}', [ProductoController::class,'listar'])->name('productos-tabla');
Route::post('/productos/agregar', [ProductoController::class,'create'])->name('agregar-productos');
Route::get('/productos/eliminar/{id}', [ProductoController::class,'destroy'])->name('eliminar-productos')->middleware('adm');
Route::get('/productos/modal/{id}', [ProductoController::class,'edit'])->name('modal-productos');
Route::post('/productos/actualizar/{id}', [ProductoController::class,'update'])->name('actualizar-productos')->middleware('adm');
Route::get('/autocompletado/{id}', [ProductoController::class ,'autocompletado'])->name('autocompletado');
Route::get('/productos/minimo', [ProductoController::class ,'stockminimo'])->name('productos.Minimo');
Route::post('/productos/importar',[ProductoController::class,'importar'])->name('productos.importar');

Route::get('/cobranza', [CobranzaController::class ,'index'])->name('cobranza');
Route::get('/cobranza/{zona}', [CobranzaController::class ,'zona'])->name('cobranza.zona');
Route::get('/cobranza/zona/{id}', [CobranzaController::class,'show'])->name('facturas.cobranza');
Route::get('/cobranza/zona/detalles/{idFactura}/{idCliente}', [CobranzaController::class,'buscarDetalles'])->name('detalles.cobranza');
Route::get('/cobranza/eliminar/{id}', [CobranzaController::class,'destroy'])->name('eliminar.cobranza')->middleware('adm');
Route::get('/pdf/{idCliente}/{idFactura}', [CobranzaController::class ,'generarpdf'])->name('generarpdf');

Route::get('/deuda', [DeudaController::class ,'index'])->name('deuda');
Route::get('/deuda/detalles/{id}', [DeudaController::class,'show'])->name('facturas.deuda');
Route::get('/deuda/detalles/{idProveedor}/{idFactura}', [DeudaController::class,'buscarDetalles'])->name('detalles.deuda');
Route::get('/deuda/eliminar/{id}', [DeudaController::class,'destroy'])->name('eliminar.deuda')->middleware('adm');
Route::get('/deuda/pdf/{idProveedor}/{idFactura}', [DeudaController::class ,'generarpdf'])->name('deuda.generarpdf');

Route::get('/factura', [FacturaController::class ,'indexSalida'])->name('salida');
Route::get('/factura/datos/{id}', [FacturaController::class,'buscar'])->name('buscar.producto');
Route::post('/factura/agregar', [FacturaController::class,'createSalida'])->name('agregar-salida');
Route::get('/factura/stock/{id}', [FacturaController::class,'restar'])->name('restar.salida');
Route::post('/factura/devolver/', [FacturaController::class,'devolver'])->name('devolver.salida');

Route::get('/movimientos/salidas', [MovimientosController::class ,'indexA'])->name('movimientos.salidas');
Route::get('/movimientos/salidas/{Fecha1}/{Fecha2}', [MovimientosController::class ,'buscarSalida'])->name('buscar.salidas');
Route::get('/movimientos/pdf/salidas/{Fecha1}/{Fecha2}', [MovimientosController::class ,'pdfSalida'])->name('pdf.salidas');
Route::get('/movimientos/entradas', [MovimientosController::class ,'indexB'])->name('movimientos.entradas');
Route::get('/movimientos/entradas/{Fecha1}/{Fecha2}', [MovimientosController::class ,'buscarEntrada'])->name('buscar.entradas');
Route::get('/movimientos/pdf/entradas/{Fecha1}/{Fecha2}', [MovimientosController::class ,'pdfEntrada'])->name('pdf.entradas');

Route::get('/compras', [ComprasController::class ,'indexEntrada'])->name('entrada');
Route::get('/compras/datos/{id}', [ComprasController::class,'buscar'])->name('buscar.entrada');
Route::post('/compras/agregar', [ComprasController::class,'createEntrada'])->name('agregar-entrada');
Route::get('/compras/stock/{id}', [ComprasController::class,'sumar'])->name('sumar.entrada');
Route::post('/compras/devolver/', [ComprasController::class,'devolver'])->name('devolver.entrada');


Route::get('/cobranza/abonos/{id}', [AbonosController::class ,'cargarA'])->name('cargar.abonos');
Route::post('/cobranza/abonos/agregar', [AbonosController::class ,'agregarA'])->name('crear.abonos');
Route::get('/deuda/abonos/{id}', [AbonosController::class ,'cargarB'])->name('abonos.compra');
Route::post('/deuda/abonos/agregar', [AbonosController::class ,'agregarB'])->name('crear.abonos.compra');

Route::get('/usuarios', [UsuariosController::class ,'index'])->name('usuario');
Route::post('/usuarios/actualizar', [UsuariosController::class ,'actualizarPerfil'])->name('usuarioPerfil.actualizar');
Route::post('/usuarios/agregar', [UsuariosController::class ,'crear'])->name('registrar');
Route::get('/usuarios/listar', [UsuariosController::class ,'listar'])->name('usuarios.lista')->middleware('adm');
Route::post('/usuarios/listar/actualizar', [UsuariosController::class ,'actualizar'])->name('usuario.actualizar')->middleware('adm');
Route::get('/usuarios/borrar/{id}', [UsuariosController::class ,'borrar'])->name('borrar.usuario')->middleware('adm');

Route::get('/pedidos', [PedidosController::class ,'index'])->name('pedidos');
Route::get('/pedidos/buscar/{Fecha1}/{Fecha2}', [PedidosController::class ,'buscar'])->name('pedidos.buscar');
Route::get('/pedidos/pdf/{Fecha1}/{Fecha2}', [PedidosController::class ,'pdf'])->name('pedidos.buscarPdf');
Route::get('/pedidos/todos/{Fecha1}/{Fecha2}', [PedidosController::class ,'buscarAll'])->name('pedidos.buscarAll');
Route::get('/pedidos/pdftodos/{Fecha1}/{Fecha2}', [PedidosController::class ,'pdfAll'])->name('pedidos.buscarAllPdf');
Route::post('/pedidos/agregar', [PedidosController::class ,'agregar'])->name('pedidos.agregar');
Route::get('/pedidos/actualizar/{id}', [PedidosController::class ,'vistaActualizar'])->name('pedidos.vistaActualizar');
Route::get('/pedidos/elemento/borrar/{id}', [PedidosController::class ,'borrarElemento'])->name('pedidos.borrarElemento');
Route::post('/pedidos/procesar', [PedidosController::class ,'procesar'])->name('pedidos.procesar');

Route::get('/inicio', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/ventas', [App\Http\Controllers\HomeController::class, 'ventas'])->name('home.ventas');
Route::get('/grafico', [App\Http\Controllers\HomeController::class, 'grafico'])->name('home.grafico');
Route::get('/movimientos-facturas', [App\Http\Controllers\HomeController::class, 'grafico_barras'])->name('home.grafico.barras');
});