<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ wp_get_document_title() }}</title>
    <?php wp_head(); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 20px;
            padding-bottom: 20px;
        }
        .header {
            padding-bottom: 20px;
            margin-bottom: 30px;
            border-bottom: 1px solid #e5e5e5;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h3 class="text-muted">Gestión de Personas</h3>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('person.index') }}">Listado</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('person.create') }}">Crear Nuevo</a>
                            </li>
                        </ul>
                        <div class="d-flex">
                            @if(Auth::check())
                                <span class="navbar-text me-3">Hola, {{ Auth::user()->display_name }}</span>
                                <a href="{{ wp_logout_url(home_url()) }}" class="btn btn-outline-danger btn-sm">Cerrar sesión</a>
                            @else
                                <a href="{{ wp_login_url() }}" class="btn btn-outline-primary btn-sm">Iniciar sesión</a>
                            @endif
                        </div>
                    </div>
                </div>
            </nav>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
        
        <footer class="pt-4 my-md-5 pt-md-5 border-top">
            <div class="row">
                <div class="col-12 col-md">
                    <small class="d-block mb-3 text-muted">&copy; {{ date('Y') }} - Themosis CRUD App</small>
                </div>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Script para validación de RUT en tiempo real -->
    <script>
    $(document).ready(function() {
        function validarRut(rut) {
            // Eliminar puntos y guión
            var valor = rut.replace(/\./g, '').replace('-', '');
            
            // Validar formato
            if (!/^[0-9]{7,8}[0-9K]$/i.test(valor)) {
                return false;
            }
            
            var suma = 0;
            var multiplo = 2;
            
            // Para cada dígito del RUT
            for (var i = valor.length - 2; i >= 0; i--) {
                suma += valor.charAt(i) * multiplo;
                multiplo = multiplo < 7 ? multiplo + 1 : 2;
            }
            
            var dv = 11 - (suma % 11);
            if (dv === 11) dv = 0;
            if (dv === 10) dv = 'K';
            
            // Comparar con el dígito verificador
            return dv.toString().toUpperCase() === valor.charAt(valor.length - 1).toUpperCase();
        }
        
        // Formatear RUT mientras se escribe
        $("#rut").on('input', function() {
            var rut = $(this).val().replace(/\./g, '').replace('-', '');
            
            // Formatear con puntos y guión
            if (rut.length > 1) {
                var dv = rut.charAt(rut.length - 1);
                var rutSinDV = rut.substring(0, rut.length - 1);
                
                // Insertar puntos
                var rutFormateado = '';
                for (var i = rutSinDV.length - 1, j = 0; i >= 0; i--, j++) {
                    rutFormateado = rutSinDV.charAt(i) + rutFormateado;
                    if ((j + 1) % 3 === 0 && i !== 0) {
                        rutFormateado = '.' + rutFormateado;
                    }
                }
                
                $(this).val(rutFormateado + '-' + dv);
            }
            
            // Validar RUT
            if ($(this).val().length > 8) {
                if (validarRut($(this).val())) {
                    $(this).removeClass('is-invalid').addClass('is-valid');
                    $("#rut-error").hide();
                } else {
                    $(this).removeClass('is-valid').addClass('is-invalid');
                    $("#rut-error").show().text("RUT inválido");
                }
            } else {
                $(this).removeClass('is-valid is-invalid');
                $("#rut-error").hide();
            }
        });
    });
    </script>
    
    <?php wp_footer(); ?>
</body>
</html>