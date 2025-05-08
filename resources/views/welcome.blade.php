<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        .item {
            display: block;
            width: 100%;
            height: 500px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark navbar-expand-lg bg-dark">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand mx-4 text-uppercase fw-bold" href="/">{{ env('APP_NAME') }}</a>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link fw-bold active" aria-current="page" href="/">Hogar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="#servicios">Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="#contacto">Contacto</a>
                    </li>
                </ul>
            </div>
            <div>
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link fw-bold" href="{{ route('filament.admin.auth.login') }}">{{ __('Login') }}</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div>
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                <img src="{{ asset('img/Banner.png') }}" class="d-block item img-fluid" alt="...">
                </div>            
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bg-dark" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon bg-dark" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <div class="text-center border-bottom" id="servicios">
        <h1 class="display-4 fw-bold text-uppercase">Nuestros Servicios</h1>
        <div class="col-lg-6 mx-auto container">
            <p class="mt-4 text-secondary fs-5">
                Venta de repuestos de motos, contamos con una alta gama de productos, variedad de marcas y excelentes precios.
                Taller mecánico, donde realizamos mantenimientos y reparaciones a su moto.
                Tambien Moto lavado, dejamos su moto como nueva.
            </p>
            <p class="mt-4 text-secondary fs-5">Trabajamos de Lunes - Sabado a partir de las 8:00am hasta las 6:00pm</p>

        </div>
        <div class="overflow-hidden" style="max-height: 30vh;">
            <div class="container px-5">
                <img src="{{ asset('img/2.png') }}" class="img-fluid border rounded-3 shadow-lg mb-4" alt="Example image" width="700" height="500" loading="lazy">
            </div>
        </div>
    </div>

    <div class="px-5 py-0" id="contacto">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 py-5">
            <div class="col d-flex align-items-start">
                <svg class="bi text-muted flex-shrink-0 me-3" width="1.75em" height="1.75em"><use xlink:href="#home"/></svg>
                <div>
                    <h3 class="fw-bold mb-2 fs-4 text-uppercase">¿Quienes somos?</h3>
                    <p class="text-secondary text-lowercase fs-5"> <span class="text-uppercase">{{ env('APP_NAME') }}</span> Una tienda enfocada a ofrecer un servicio completo a su moto, desde venta de repuesto, taller mecánico y moto lavado.</p>
                </div>
            </div>
            <div class="col d-flex align-items-start">
                <svg class="bi text-muted flex-shrink-0 me-3" width="1.75em" height="1.75em"><use xlink:href="#cpu-fill"/></svg>
                <div>
                    <h3 class="fw-bold mb-2 fs-4 text-uppercase">Dirección</h3>
                    <p class="text-secondary text-lowercase fs-5">{{ $store->address }}</p>
                </div>
            </div>      
            <div class="col d-flex align-items-start">
                <svg class="bi text-muted flex-shrink-0 me-3" width="1.75em" height="1.75em"><use xlink:href="#calendar3"/></svg>
                <div>
                    <h3 class="fw-bold mb-2 fs-4 text-uppercase">Email</h3>
                    <p class="text-secondary text-lowercase fs-5">{{ $store->email }}</p>
                </div>
            </div>
            <div class="col d-flex align-items-start">
                <svg class="bi text-muted flex-shrink-0 me-3" width="1.75em" height="1.75em"><use xlink:href="#calendar3"/></svg>
                <div>
                    <h3 class="fw-bold mb-2 fs-4 text-uppercase">Teléfono</h3>
                    <p class="text-secondary text-lowercase fs-5">{{ $store->whatsapp }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="">
        <footer class="text-center">
            <div class="">
            </div>
        </footer>
    </div>

    <div class="">
        <footer class="text-center">
            <div class="">
            <p class="text-muted text-uppercase">&copy; 2025 {{ env('APP_NAME') }}</p>
            </div>
        </footer>
    </div>

</body>
</html>