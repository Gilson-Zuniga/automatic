<<<<<<< HEAD
=======
<!DOCTYPE html>
<!-- {{-- resources/views/layouts/app.blade.php --}} -->
<!-- esto estaba en la primera linea del documento -->
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Mi Sistema</title>
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

</head>

<body class="hold-transition sidebar-mini bg-dark">
    <nav class="navbar navbar-expand-sm navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">AutomatiControl</a>
            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" aria-current="page">Sobre nosotros
                            <span class="visually-hidden">(current)</span></a>
                    </li>

                    <div class="dropdown-menu" aria-labelledby="dropdownId">
                        <a class="dropdown-item" href="#">Action 1</a>
                        <a class="dropdown-item" href="#">Action 2</a>
                    </div>
                    </li>
                </ul>

                <a href="auth/login.blade.php" class="btn btn-outline-success my-2 my-sm-0" type="submit">Iniciar
                    Sesion</a>
                </form>
            </div>
        </div>
    </nav>

    <!------------------------------------------------------------------------------------->

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center text-white">Bienvenido a AutomatiControl</h1>
                <p class="text-center text-white">Tu sistema de gestión automatizado.</p>
            </div>

            <div id="miCarrusel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
                <div class="carousel-inner" style="height: 400px;">
                    <div class="carousel-item active">
                        <img src="img/img1.jpg" class="d-block w-100 h-100 object-fit-cover" alt="Imagen 1">
                    </div>
                    <div class="carousel-item">
                        <img src="img/img2.jpg" class="d-block w-100 h-100 object-fit-cover" alt="Imagen 2">
                    </div>
                    <div class="carousel-item">
                        <img src="img/img3.jpg" class="d-block w-100 h-100 object-fit-cover" alt="Imagen 3">
                    </div>
                </div>
            </div>



        </div>




        <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('js/adminlte.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
            crossorigin="anonymous"></script>

</body>

</html>
>>>>>>> ff0027ae73abfe336bc6442ec124713a6e68792a
