<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer Mejorado</title>
    @vite('resources/css/app.css')
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .footer-bg {
            background-color: #1E40AF;
            color: white;
        }
        .footer-link, .footer-icon {
            transition: color 0.3s ease;
        }
        .footer-link:hover, .footer-icon:hover {
            color: #FFFFFF;
        }
        .footer-link {
            color: #B0B7C3;
        }
        .contact-info {
            color: #B0B7C3;
        }
        .footer-container {
            max-width: 1200px;
            margin: auto;
            padding: 2rem;
        }
        .footer-section {
            margin-bottom: 1rem;
        }
        .footer-logo {
            max-width: 150px;
        }
        .footer-heading {
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }
        .social-icons a {
            margin-right: 0.5rem;
            font-size: 1.5rem;
        }
        .subscribe-form input {
            padding: 0.5rem;
            border: none;
            border-radius: 4px;
            margin-right: 0.5rem;
            width: calc(100% - 140px);
        }
        .subscribe-form button {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            background-color: #FBBF24;
            color: white;
            cursor: pointer;
        }
        .subscribe-form button:hover {
            background-color: #F59E0B;
        }
    </style>
    <!-- Import Inter Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Import FontAwesome for Icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-100 text-gray-900">

    <!-- Footer -->
    <footer class="footer-bg py-8">
        <div class="footer-container">
            <div class="flex flex-wrap justify-between">
                <div class="footer-section w-full md:w-1/4 mb-6 md:mb-0">
                    <p class="text-gray-300">Únete a tus clases desde cualquier lugar, en cualquier momento, con seguridad avanzada.</p>
                </div>
                <div class="footer-section w-full md:w-1/4 mb-6 md:mb-0">
                    <h3 class="footer-heading font-bold">Navegación</h3>
                    <ul>
                        <li><a href="/" class="footer-link hover:text-white">Inicio</a></li>
                        <li><a href="{{ route('acerca') }}" class="footer-link hover:text-white">Acerca de</a></li>
                        <li><a href="{{ route('contacto') }}" class="footer-link hover:text-white">Contacto</a></li>
                    </ul>
                </div>
                <div class="footer-section w-full md:w-1/4 mb-6 md:mb-0">
                    <h3 class="footer-heading font-bold">Contacto</h3>
                    <ul>
                        <li class="contact-info">Email: vigilantevirtual@gmail.com</li>
                        <li class="contact-info">Tel: +591 70605040</li>
                        <li class="mt-4">
                            <div class="social-icons">
                                <a href="#" class="footer-icon hover:text-white"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" class="footer-icon hover:text-white"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="footer-icon hover:text-white"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#" class="footer-icon hover:text-white"><i class="fab fa-instagram"></i></a>
                                <a href="#" class="footer-icon hover:text-white"><i class="fab fa-youtube"></i></a>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="footer-section w-full md:w-1/4">
                    <h3 class="footer-heading font-bold">Suscríbete</h3>
                    <form action="#" method="POST" class="subscribe-form flex">
                        <input type="email" placeholder="Correo Electronico" class="text-gray-900">
                        <button type="submit">Suscribirse</button>
                    </form>
                </div>
            </div>
            <div class="mt-8 text-center">
                <small>&copy; 2024 Clases Virtuales con Detección de IA grupo N°3. Todos los derechos reservados.</small>
            </div>
        </div>
    </footer>

</body>
</html>
