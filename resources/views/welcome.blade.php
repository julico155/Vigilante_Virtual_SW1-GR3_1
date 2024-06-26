<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clases Virtuales con Detección de IA</title>
    @vite('resources/css/app.css')
    <style>
        .hero-bg {
            background: url('https://previews.123rf.com/images/annyart/annyart1607/annyart160700054/61053969-la-ilustraci%C3%B3n-de-fondo-hermoso-cient%C3%ADfica-negro-con-la-escritura-de-tiza-pizarra-de-la-clase.jpg') no-repeat center center;
            background-size: cover;
            height: 90vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
        }

        .feature-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .cta-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #2563EB;
            color: #fff;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .cta-button:hover {
            background-color: #1E40AF;
        }

        .bg-gradient-to-r {
            background: linear-gradient(to right, #2563EB, #1E40AF);
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .btn-primary {
            background-color: #2563EB;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #1E40AF;
        }

        .btn-secondary {
            background-color: #FBBF24;
            color: #fff;
        }

        .btn-secondary:hover {
            background-color: #F59E0B;
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-900">

    <x-navbar />
    <header class="hero-bg">
        <div class="container mx-auto">
            <h1 class="text-6xl font-bold text-white">Bienvenido a Clases Virtuales con Detección de IA</h1>
            <p class="mt-4 text-2xl text-white">Únete a tus clases desde cualquier lugar, en cualquier momento, con
                seguridad avanzada.</p>
            <div class="mt-8 space-x-4">
                <a href="#" class="cta-button">Comienza ya</a>
            </div>
        </div>
    </header>
    <main class="container mx-auto px-4 py-16">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-blue-900">¿Por qué elegir nuestras clases?</h2>
            <p class="mt-4 text-xl text-gray-600">Descubre las ventajas de nuestras clases virtuales y mejora tu
                aprendizaje.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12">
            <div class="bg-white shadow-lg rounded-lg p-8 feature-card">
                <h3 class="text-2xl font-bold text-blue-900">Planes Asequibles</h3>
                <p class="mt-4 text-gray-600">Elige entre una variedad de planes asequibles para satisfacer tus
                    necesidades de aprendizaje.</p>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-8 feature-card">
                <h3 class="text-2xl font-bold text-blue-900">Detección de Rostro con IA</h3>
                <p class="mt-4 text-gray-600">Nuestra tecnología avanzada detecta comportamientos sospechosos para
                    garantizar la integridad académica.</p>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-8 feature-card">
                <h3 class="text-2xl font-bold text-blue-900">Reportes en Tiempo Real</h3>
                <p class="mt-4 text-gray-600">Los docentes reciben reportes en tiempo real sobre actividades sospechosas
                    durante las clases.</p>
            </div>
        </div>
        <div class="text-center mt-16">
            <a href="#" class="cta-button">Comenzar Ahora</a>
        </div>
    </main>

    @include('components.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            mobileMenuButton.addEventListener('click', function() {
                const expanded = mobileMenuButton.getAttribute('aria-expanded') === 'true' || false;
                mobileMenuButton.setAttribute('aria-expanded', !expanded);
                mobileMenu.style.display = expanded ? 'none' : 'block';
            });
        });
    </script>



</body>

</html>
