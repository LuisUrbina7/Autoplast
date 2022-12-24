<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/Style.css') }}">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('css')

</head>

<body>
    <div class="contenedor-loader">
        <div class="loader"></div>
    </div>
    <header class="p-3 shadow" id="fondo-encabezado">
       
            <div class="d-flex justify-content-between">
                <div>
                    <a href="#" class="d-flex align-items-center col-lg-4 mb-2 mb-lg-0 link-dark text-decoration-none">
                        <i class="bi bi-bootstrap text-dark"></i>
                    </a>
                   <!-- ----logo---- -->
                </div>
               
                    <div class="dropdown text-end user-bg boder px-3">
                        <a href="#" class="d-block text-light text-decoration-none dropdown-toggle " id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">

                            <li><a class="dropdown-item" href="{{route('usuario')}}">Perfil</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li> <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Salir') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
              
            </div>
        
    </header>
    <div class="container-fluid">
        <div class="row" style="height: calc(100vh - 8vh);">
            <div class="col-sm-3 col-12 pb-sm-0 border-end" style="background-color: #001950;">
                <div class="p-md-1">
                    <nav class="py-0 px-md-3 navbar navbar-expand-lg  text-center text-md-start">
                        
                        <button class="navbar-toggler w-100 h-25 text-light" type="button" data-bs-toggle="collapse" data-bs-target="#menu-general" aria-controls="menu-general" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="lab la-buromobelexperte  fs-1"></i>
                        </button>

                        <div class="flex-column collapse navbar-collapse mt-1 mt-md-0 " id="menu-general">
                            <ul class="list-unstyled mb-sm-auto mb-0 align-items-center align-items-sm-start w-100 nav-menu " id="menu">
                                <li>
                                    <a href="{{ route('home')}}" class="nav-link text-light px-2">
                                        <i class="las la-home"></i> <span>Inicio</span>
                                    </a>
                                </li>
                                <li class="w-100">
                                    <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-2">
                                        <i class="las la-users"></i>
                                        <span>Clientes</span> <i class="las la-caret-down"></i></a>
                                    <ul class="collapse nav flex-column submenu" id="submenu1" data-bs-parent="#menu">
                                        <li class="w-100">
                                            <a href="{{ route('agregar-cliente-vista')}}" class="nav-link px-2"> Nuevo Cliente</a>
                                        </li>
                                        <li>
                                            <a href="{{route('clientes')}}" class="nav-link px-2"> Registros </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="w-100">
                                    <a href="#submenu11" data-bs-toggle="collapse" class="nav-link px-2">
                                        <i class="las la-truck"></i>
                                        <span>Proveedores</span> <i class="las la-caret-down"></i> </a>
                                    <ul class="collapse nav flex-column  submenu" id="submenu11" data-bs-parent="#menu">
                                        <li class="w-100">
                                            <a href="{{route('agregar-proveedores-vista')}}" class="nav-link px-2"> Nuevo</a>
                                        </li>
                                        <li>
                                            <a href="{{route('proveedores')}}" class="nav-link px-2"> Registros </a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="{{route('categorias')}}" class="nav-link px-2 ">
                                        <i class="las la-certificate"></i>
                                        <span >Categorias</span></a>
                                </li>
                                <li class="w-100">
                                    <a href="#submenu2" data-bs-toggle="collapse" class="nav-link px-2">
                                        <i class="lab la-dropbox"></i>
                                        <span >Productos</span> <i class="las la-caret-down"></i></a>
                                    <ul class="collapse nav flex-column submenu" id="submenu2" data-bs-parent="#menu">
                                        <li class="w-100">
                                            <a href="{{route('agregar-productos-vista')}}" class="nav-link px-2">Agregar Productos</a>
                                        </li>
                                        <li>
                                            <a href="{{route('productos')}}" class="nav-link px-2">Listar</a>
                                        </li>
                                        <li>
                                            <a href="{{route('productos.Minimo')}}" class="nav-link px-2">Minimo</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="{{ route('pedidos')}}" class="nav-link px-2">
                                        <i class="las la-school"></i>
                                        <span >Pedidos</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('salida')}}" class="nav-link px-2">
                                        <i class="las la-cart-arrow-down"></i>
                                        <span >Ventas</span></a>
                                </li>
                                <li>
                                    <a href="{{route('entrada')}}" class="nav-link px-2">
                                        <i class="las la-cart-plus"></i>
                                        <span >Compras</span></a>
                                </li>
                                <li class="w-100">
                                    <a href="#submenu3" data-bs-toggle="collapse" class="nav-link px-2 ">
                                        <i class="las la-donate"></i>
                                        <span >Facturas</span> <i class="las la-caret-down"></i></a>
                                    <ul class="collapse nav flex-column  submenu" id="submenu3" data-bs-parent="#menu">
                                        <li class="w-100">
                                            <a href="{{route('movimientos.salidas')}}" class="nav-link px-2"> Salidas</a>
                                        </li>
                                        <li>
                                            <a href="{{route('movimientos.entradas')}}" class="nav-link px-2"> Entradas</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="{{route('cobranza')}}" class="nav-link px-2 align-middle">
                                        <i class="las la-coins"></i>
                                        <span >Cobranzas</span></a>
                                </li>
                                <li>
                                    <a href="{{route('deuda')}}" class="nav-link px-2 align-middle">
                                        <i class="las la-file-invoice-dollar"></i>
                                        <span >Deudas</span></a>
                                </li>
                                <li>
                                    <a href="{{route('usuario')}}" class="nav-link px-2 align-middle">
                                        <i class="las la-user-cog"></i>
                                        <span >Usuarios</span></a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
            <main class="col-sm-9 col-12 pt-4">
                <div class="border overflow-hidden rounded-3 p-md-4 bg-white ">
                    @yield('contenido')

                </div>
            </main>
        </div>
    </div>
    <script>
        window.addEventListener('load', () => {
            const contenedor = document.querySelector('.contenedor-loader');
            contenedor.style.opacity = 0;
            contenedor.style.visibility = 'hidden';
        });
    </script>
    <script src="{{ asset('js/Menu.js')}}"></script>
    @yield('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>