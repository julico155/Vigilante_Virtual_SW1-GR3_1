<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acerca de nosotros</title>
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">
    <x-navbar />

    <!-- Sección "Acerca de Nosotros" -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-blue-900">Acerca de Nosotros</h2>
                <p class="mt-4 text-xl text-gray-600">Conoce más sobre nuestro sistema, misión, visión y valores. Creemos en la integridad y la innovación en la educación.</p>
                <p class="mt-2 text-lg text-gray-500 italic">"La educación es el arma más poderosa que puedes usar para cambiar el mundo." - Nelson Mandela</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-12">
                <div class="bg-white shadow-lg rounded-lg p-8 feature-card transform hover:scale-105 transition-transform duration-300 flex items-center">
                    <i class="fas fa-bullseye text-4xl text-blue-900 mr-4"></i>
                    <div>
                        <h3 class="text-2xl font-bold text-blue-900 mb-4">Misión</h3>
                        <p class="text-gray-600">Proporcionar una solución innovadora y confiable para la supervisión de 
                                            exámenes en entornos virtuales, utilizando tecnologías avanzadas de inteligencia 
                                            artificial. Nos comprometemos a garantizar la integridad académica, facilitar la 
                                            gestión eficiente de evaluaciones y crear un entorno seguro y justo para todos los 
                                            estudiantes.</p>
                    </div>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-8 feature-card transform hover:scale-105 transition-transform duration-300 flex items-center">
                    <i class="fas fa-eye text-4xl text-blue-900 mr-4"></i>
                    <div>
                        <h3 class="text-2xl font-bold text-blue-900 mb-4">Visión</h3>
                        <p class="text-gray-600">Nuestra visión es ser líderes mundiales en soluciones de supervisión 
                            automatizada para exámenes, estableciendo nuevos estándares en la educación virtual. Aspiramos a 
                            innovar continuamente y ofrecer herramientas que no solo aseguren la calidad y transparencia en 
                            las evaluaciones, sino que también mejoren la experiencia educativa global.</p>
                    </div>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-8 feature-card transform hover:scale-105 transition-transform duration-300 flex items-center">
                    <i class="fas fa-handshake text-4xl text-blue-900 mr-4"></i>
                    <div>
                        <h3 class="text-2xl font-bold text-blue-900 mb-4">Valores</h3>
                        <p class="text-gray-600">Compromiso, innovación, accesibilidad y seguridad son los pilares que guían nuestras acciones y decisiones.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('components.footer')
</body>
</html>
