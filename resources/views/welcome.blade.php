{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Sistema</title>
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    {{-- Puedes incluir navbar/sidebar si ya los tienes --}}
    <div class="content-wrapper p-3">
        @yield('content')
    </div>
</div>
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('js/adminlte.min.js') }}"></script>
</body>
</html>
