@extends('adminlte::master')

@section('title', 'Inicio')


@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\PreloaderHelper')

@section('adminlte_css')
    @stack('css')
    @yield('css')
@stop

@section('classes_body', $layoutHelper->makeBodyClasses())

@section('body_data', $layoutHelper->makeBodyData())

@section('body')

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Gestión de Inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/custom.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="javascript:void(0)">
                <img src="https://cdn.pixabay.com/photo/2017/01/31/13/14/animal-2023924_640.png" alt="InventSys Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#servicios">Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contacto">Contacto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-light ms-2" href="/login" style="border-radius: 5px; padding: 0.5rem 1rem; border: 1px solid white;">Inicio de Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Gestión de Inventario Eficiente</h1>
            <p>Optimiza tus operaciones con nuestro sistema integral de gestión de inventario diseñado para maximizar la eficiencia y minimizar costos</p>
            <a href="#contacto" class="btn btn-primary btn-lg">Solicitar Demostración</a>
        </div>
    </section>


<!-- Services Section -->
<section id="servicios" class="py-5 bg-light">
    <div class="container">
        <div class="text-justify mb-5">
            <h2 class="display-4 font-weight-bold">Nuestros Servicios</h2>
        </div>
        
        <div class="row">
            <!-- Gestión de Stock -->
            <div class="col-12 col-sm-6 col-lg-3 mb-4">
                <div class="card h-100 border-0 shadow-sm hover-shadow transition">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-boxes text-primary mb-3" style="font-size: 2.5rem;"></i>
                        <h3 class="h4 font-weight-bold">Gestión de Stock</h3>
                        <p class="text-muted text-justify">Control en tiempo real de todos tus productos. Seguimiento detallado de entradas, salidas y niveles de stock para evitar quiebres y excesos.</p>
                    </div>
                </div>
            </div>
            
            <!-- Análisis y Reportes -->
            <div class="col-12 col-sm-6 col-lg-3 mb-4">
                <div class="card h-100 border-0 shadow-sm hover-shadow transition">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-chart-line text-primary mb-3" style="font-size: 2.5rem;"></i>
                        <h3 class="h4 font-weight-bold">Análisis y Reportes</h3>
                        <p class="text-muted">Informes detallados sobre el rendimiento del inventario. Identifica patrones, optimiza compras y reduce costos operativos.</p>
                    </div>
                </div>
            </div>
            
            <!-- Acceso Móvil -->
            <div class="col-12 col-sm-6 col-lg-3 mb-4">
                <div class="card h-100 border-0 shadow-sm hover-shadow transition">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-mobile-alt text-primary mb-3" style="font-size: 2.5rem;"></i>
                        <h3 class="h4 font-weight-bold">Acceso Móvil</h3>
                        <p class="text-muted">Gestiona tu inventario desde cualquier lugar con nuestra aplicación móvil. Perfecta para realizar conteos y ajustes en movimiento.</p>
                    </div>
                </div>
            </div>
            
            <!-- Nuestros clientes -->
            <div class="col-12 col-sm-6 col-lg-3 mb-4">
                <a href="/ecommerce" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm hover-shadow transition">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-users text-primary mb-3" style="font-size: 2.5rem;"></i>
                            <h3 class="h4 font-weight-bold">Nuestros clientes</h3>
                            <p class="text-muted">Conoce de primera mano a uno de nuestros clientes: 'El software de gestión de inventario de <strong>AutomatiControl</strong> revolucionó nuestro negocio.</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

    <!-- Contact Section -->
    <section id="contacto" class="contact">
        <div class="container">
            <div class="section-title">
                <h2>Contáctanos</h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="contact-form">
                        <form id="contactForm">
                            <div class="mb-3">
                                <input type="text" class="form-control" id="name" placeholder="Nombre" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" class="form-control" id="email" placeholder="Correo Electrónico" required>
                            </div>
                            <div class="mb-3">
                                <input type="tel" class="form-control" id="phone" placeholder="Teléfono" required>
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" id="message" rows="5" placeholder="Mensaje" required></textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg">Enviar Mensaje</button>
                            </div>
                        </form>
                        <div class="loading-spinner" id="loadingSpinner">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                            <p class="mt-2">Enviando mensaje...</p>
                        </div>
                        <div class="form-response success-message" id="successMessage">
                            <i class="fas fa-check-circle fa-2x mb-2"></i>
                            <p>¡Gracias por contactarnos! Nos pondremos en contacto contigo pronto.</p>
                        </div>
                        <div class="form-response error-message" id="errorMessage">
                            <i class="fas fa-exclamation-circle fa-2x mb-2"></i>
                            <p>Ha ocurrido un error. Por favor, intenta nuevamente más tarde.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <img src="https://cdn.pixabay.com/photo/2017/01/31/13/14/animal-2023924_640.png" alt="InventSys Logo" class="footer-logo">
                    <p>Soluciones innovadoras para la gestión eficiente de inventario.</p>
                </div>
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5>Contacto</h5>
                    <p><i class="fas fa-map-marker-alt me-2"></i> Av. Principal 123, Ciudad</p>
                    <p><i class="fas fa-phone me-2"></i> +123 456 7890</p>
                    <p><i class="fas fa-envelope me-2"></i> info@inventsys.com</p>
                </div>
                <div class="col-lg-4">
                    <h5>Síguenos</h5>
                    <div class="social-icons">
                        <a href="javascript:void(0)"><i class="fab fa-facebook"></i></a>
                        <a href="javascript:void(0)"><i class="fab fa-twitter"></i></a>
                        <a href="javascript:void(0)"><i class="fab fa-linkedin"></i></a>
                        <a href="javascript:void(0)"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <p class="mb-0">&copy; 2025 AutomatiControl</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script id="app-script" src="../assets/js/custom.js"></script>
</body>
</html>

    
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
@stop
