<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/Style.css') }}">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://kit.fontawesome.com/1bc2742cdd.js" crossorigin="anonymous"></script>
    @yield('css')

</head>

<body>
    <div class="contenedor-loader">
        <div class="loader"></div>
    </div>
    <header class="py-3 mb-4 border-bottom shadow" id="fondo-encabezado">
        <div class="container">
            <div class="row">
                <div class="col-auto me-auto ">
                    <a href="#" class="d-flex align-items-center col-lg-4 mb-2 mb-lg-0 link-dark text-decoration-none">
                        <i class="bi bi-bootstrap text-dark"></i>
                    </a>
                    <p class="h5" id="Autoplast">Autoplast<span class="h6">Urbina</span></p>
                </div>
                <div class="col-auto">
                    <div class="dropdown text-end user-bg boder rounded-3 px-3">
                        <a href="#" class="d-block text-light text-decoration-none dropdown-toggle " id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }} <img src="http://localhost/CI4/assets/Nick_img/malware.jpg" alt="mdo" width="32" height="32" class="rounded-circle">
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
            </div>
        </div>
    </header>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3 col-12 pb-sm-0 pb-3">
                <div class="bg-white border rounded-3 p-md-1 h-100 ">
                    <nav class="py-0 px-md-3 navbar navbar-expand-lg  text-center text-md-start">
                        <button class="navbar-toggler w-100 h-25 responsive-btn" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="fa fa-bars" aria-hidden="true"></i>
                        </button>
                        <div class="flex-column collapse navbar-collapse mt-1 mt-md-0 " id="navbarNavAltMarkup">
                            <div class="d-none d-md-block p-3 text-center">
                                <img src="{{ asset('img/Nueva-logo.png') }}" alt="mdo" width="180" height="auto" >
                                
                                <h5 class="text-muted h6 mt-2"> {{ Auth::user()->username }}</h5>
                            </div>
                            <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start w-100 nav-menu " id="menu">
                                <li>
                                    <a href="{{ route('home')}}" class="nav-link align-middle px-2">
                                        <i class="fa fa-home" aria-hidden="true"></i> <span class=" d-sm-inline">Inicio</span>
                                    </a>
                                </li>
                                <li class="w-100">
                                    <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-2 align-middle">
                                        <i class="fa fa-address-book" aria-hidden="true"></i>
                                        <span class="ms-1  d-sm-inline">Clientes</span> </a>
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
                                    <a href="#submenu11" data-bs-toggle="collapse" class="nav-link px-2 align-middle">
                                        <i class="fa fa-address-book" aria-hidden="true"></i>
                                        <span class="ms-1  d-sm-inline">proveedores</span> </a>
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
                                    <a href="{{route('categorias')}}" class="nav-link px-2 align-middle">
                                        <i class="fa fa-bookmark" aria-hidden="true"></i>
                                        <span class="ms-1  d-sm-inline">Categorias</span></a>
                                </li>
                                <li class="w-100">
                                    <a href="#submenu2" data-bs-toggle="collapse" class="nav-link px-2 align-middle ">
                                        <i class="fa fa-cubes" aria-hidden="true"></i>
                                        <span class="ms-1  d-sm-inline">roductos</span></a>
                                    <ul class="collapse nav flex-column submenu" id="submenu2" data-bs-parent="#menu">
                                        <li class="w-100">
                                            <a href="{{route('agregar-productos-vista')}}" class="nav-link px-2">Agregar roductos</a>
                                        </li>
                                        <li>
                                            <a href="{{route('productos')}}" class="nav-link px-2">Listar</a>
                                        </li>
                                        <li>
                                            <a href="{{route('productos.Minimo')}}" class="nav-link px-2">Stock Minimo</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="{{ route('pedidos')}}" class="nav-link align-middle px-2">
                                        <i class="fa fa-home" aria-hidden="true"></i> <span class=" d-sm-inline">Pedidos</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('salida')}}" class="nav-link px-2 align-middle">
                                        <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                                        <span class="ms-1  d-sm-inline">Ventas</span></a>
                                </li>
                                <li>
                                    <a href="{{route('entrada')}}" class="nav-link px-2 align-middle">
                                        <i class="fa fa-bus" aria-hidden="true"></i>
                                        <span class="ms-1  d-sm-inline">Compras</span></a>
                                </li>
                                <li class="w-100">
                                    <a href="#submenu3" data-bs-toggle="collapse" class="nav-link px-2 align-middle">
                                        <i class="fa fa-exchange" aria-hidden="true"></i>
                                        <span class="ms-1 d-sm-inline">Facturas</span> </a>
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
                                        <i class="fa fa-university" aria-hidden="true"></i>
                                        <span class="ms-1  d-sm-inline">Cobranzas</span></a>
                                </li>
                                <li>
                                    <a href="{{route('deuda')}}" class="nav-link px-2 align-middle">
                                        <i class="fa fa-balance-scale" aria-hidden="true"></i>
                                        <span class="ms-1  d-sm-inline">Deudas</span></a>
                                </li>
                                <li>
                                    <a href="{{route('usuario')}}" class="nav-link px-2 align-middle">
                                        <i class="fa fa-balance-scale" aria-hidden="true"></i>
                                        <span class="ms-1  d-sm-inline">Usuarios</span></a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
            <main class=" col-sm-9 col-12 ">
                <div class="border overflow-hidden rounded-3 p-3 bg-white ">
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