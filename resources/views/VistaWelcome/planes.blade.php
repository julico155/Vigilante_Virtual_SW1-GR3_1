<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planes y Precios</title>
    @vite('resources/css/app.css')
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .plan-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .plan-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        .plan-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #2563EB;
            color: #fff;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s ease;
        }
        .plan-button:hover {
            background-color: #1E40AF;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">

    <x-navbar />

    <main class="container mx-auto px-4 py-16">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-blue-900">Nuestros Planes y Precios</h2>
            <p class="mt-4 text-xl text-gray-600">Elige el plan que mejor se adapte a tus necesidades de aprendizaje.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12">
            <div class="bg-white shadow-lg rounded-lg p-8 plan-card">
                <h3 class="text-2xl font-bold text-blue-900">Plan Básico</h3>
                <p class="mt-4 text-gray-600">Acceso a todas las clases en vivo y grabadas. Sin soporte adicional.</p>
                <p class="mt-4 text-4xl font-bold text-blue-900">$9.99/mes</p>
                <div class="text-center mt-6">
                    <a href="#" class="plan-button">Seleccionar</a>
                </div>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-8 plan-card">
                <h3 class="text-2xl font-bold text-blue-900">Plan Estándar</h3>
                <p class="mt-4 text-gray-600">Incluye soporte por correo electrónico y acceso a material adicional.</p>
                <p class="mt-4 text-4xl font-bold text-blue-900">$19.99/mes</p>
                <div class="text-center mt-6">
                    <a href="#" class="plan-button">Seleccionar</a>
                </div>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-8 plan-card">
                <h3 class="text-2xl font-bold text-blue-900">Plan Premium</h3>
                <p class="mt-4 text-gray-600">Soporte completo, sesiones 1 a 1 y acceso a todos los recursos exclusivos.</p>
                <p class="mt-4 text-4xl font-bold text-blue-900">$29.99/mes</p>
                <div class="text-center mt-6">
                    <a href="#" class="plan-button">Seleccionar</a>
                </div>
            </div>
        </div>
    </main>

    <x-footer />

</body>
</html>
