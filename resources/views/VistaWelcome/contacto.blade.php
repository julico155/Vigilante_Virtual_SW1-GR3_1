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

    <!-- Sección "Contacto" -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="flex flex-col items-center">
                    <i class="fas fa-phone-alt text-6xl text-blue-900 mb-4"></i>
                    <h2 class="text-4xl font-bold text-blue-900">Contacto</h2>
                    <p class="mt-4 text-xl text-gray-600 max-w-2xl">Nuestro equipo está aquí para ayudarte. Si tienes alguna pregunta o necesitas asistencia, no dudes en contactarnos a través de los detalles proporcionados a continuación.</p>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-12">
                <!--MABO-->
                <div class="flex flex-col sm:flex-row items-center bg-gray-50 shadow-lg rounded-lg p-8 transform hover:scale-105 transition-transform duration-300">
                    <img class="w-32 h-32 rounded-full mb-4 sm:mb-0 sm:mr-4" src="{{ asset('images/user/MABINHO.jpg') }}" alt="Ballivian Ocampo Miguel Angel">
                    <div class="text-center sm:text-left">
                        <h4 class="text-xl font-bold text-blue-900">Ballivian Ocampo Miguel Angel</h4>
                        <p class="text-gray-600">Estudiante de Ing. en Sistemas</p>
                        <div class="flex flex-col sm:flex-row items-center mt-2">
                            <i class="fas fa-envelope text-blue-900 mr-2"></i>
                            <a href="mailto:ballivian.miguel@ficct.uagrm.edu.bo" class="text-blue-500 hover:text-blue-700">ballivian.miguel@ficct.uagrm.edu.bo</a>
                        </div>
                        <div class="flex flex-col sm:flex-row items-center mt-2">
                            <i class="fas fa-phone text-blue-900 mr-2"></i>
                            <a href="https://wa.me/+59178198215" class="text-blue-500 hover:text-blue-700">+591 78198215</a>
                        </div>
                        <div class="flex flex-col sm:flex-row items-center mt-2">
                            <i class="fab fa-github text-blue-900 mr-2"></i>
                            <a href="https://github.com/MABO262001" class="text-blue-500 hover:text-blue-700" target="_blank">github.com/MABO262001</a>
                        </div>
                    </div>
                </div>
                <!--ELIO-->
                <div class="flex flex-col sm:flex-row items-center bg-gray-50 shadow-lg rounded-lg p-8 transform hover:scale-105 transition-transform duration-300">
                    <img class="w-32 h-32 rounded-full mb-4 sm:mb-0 sm:mr-4" src="{{ asset('images/user/papita.jpeg') }}" alt="Ballivian Ocampo Miguel Angel">
                    <div class="text-center sm:text-left">
                        <h4 class="text-xl font-bold text-blue-900">Osinaga Elio Andres</h4>
                        <p class="text-gray-600">Estudiante de Ing. en Sistemas</p>
                        <div class="flex flex-col sm:flex-row items-center mt-2">
                            <i class="fas fa-envelope text-blue-900 mr-2"></i>
                            <a href="mailto:osinagax10@gmail.com" class="text-blue-500 hover:text-blue-700">osinagax10@gmail.com</a>
                        </div>
                        <div class="flex flex-col sm:flex-row items-center mt-2">
                            <i class="fas fa-phone text-blue-900 mr-2"></i>
                            <a href="https://wa.me/+59177816186" class="text-blue-500 hover:text-blue-700">+591 77816186</a>
                        </div>
                        <div class="flex flex-col sm:flex-row items-center mt-2">
                            <i class="fab fa-github text-blue-900 mr-2"></i>
                            <a href="https://github.com/IngePapitas" class="text-blue-500 hover:text-blue-700" target="_blank">github.com/IngePapitas</a>
                        </div>
                    </div>
                </div>
                <!--CHALAR-->
                <div class="flex flex-col sm:flex-row items-center bg-gray-50 shadow-lg rounded-lg p-8 transform hover:scale-105 transition-transform duration-300">
                    <img class="w-32 h-32 rounded-full mb-4 sm:mb-0 sm:mr-4" src="{{ asset('images/user/david.jpg') }}" alt="Ballivian Ocampo Miguel Angel">
                    <div class="text-center sm:text-left">
                        <h4 class="text-xl font-bold text-blue-900">Chalar Quiroz David Arturo</h4>
                        <p class="text-gray-600">Estudiante de Ing. en Sistemas</p>
                        <div class="flex flex-col sm:flex-row items-center mt-2">
                            <i class="fas fa-envelope text-blue-900 mr-2"></i>
                            <a href="mailto:davidchalarq@gmail.com" class="text-blue-500 hover:text-blue-700">davidchalarq@gmail.com</a>
                        </div>
                        <div class="flex flex-col sm:flex-row items-center mt-2">
                            <i class="fas fa-phone text-blue-900 mr-2"></i>
                            <a href="https://wa.me/+59176078873" class="text-blue-500 hover:text-blue-700">+591 76078873</a>
                        </div>
                        <div class="flex flex-col sm:flex-row items-center mt-2">
                            <i class="fab fa-github text-blue-900 mr-2"></i>
                            <a href="https://github.com/dabidsillo" class="text-blue-500 hover:text-blue-700" target="_blank">github.com/dabidsillo</a>
                        </div>
                    </div>
                </div>
                <!--JULIO-->
                <div class="flex flex-col sm:flex-row items-center bg-gray-50 shadow-lg rounded-lg p-8 transform hover:scale-105 transition-transform duration-300">
                    <img class="w-32 h-32 rounded-full mb-4 sm:mb-0 sm:mr-4" src="{{ asset('images/user/juli.png') }}" alt="Gutierrez Velasco Julio Alejandro">
                    <div class="text-center sm:text-left">
                        <h4 class="text-xl font-bold text-blue-900">Gutierrez Velasco Julio Alejandro</h4>
                        <p class="text-gray-600">Estudiante de Ing. en Sistemas</p>
                        <div class="flex flex-col sm:flex-row items-center mt-2">
                            <i class="fas fa-envelope text-blue-900 mr-2"></i>
                            <a href="mailto:juliogutierrezv15@gmail.com" class="text-blue-500 hover:text-blue-700">juliogutierrezv15@gmail.com</a>
                        </div>
                        <div class="flex flex-col sm:flex-row items-center mt-2">
                            <i class="fas fa-phone text-blue-900 mr-2"></i>
                            <a href="https://wa.me/+59178198215" class="text-blue-500 hover:text-blue-700">+591 78198215</a>
                        </div>
                        <div class="flex flex-col sm:flex-row items-center mt-2">
                            <i class="fab fa-github text-blue-900 mr-2"></i>
                            <a href="https://github.com/MABO262001" class="text-blue-500 hover:text-blue-700" target="_blank">github.com/MABO262001</a>
                        </div>
                    </div>
                </div>
                <!--MICAELA-->
                <div class="flex flex-col sm:flex-row items-center bg-gray-50 shadow-lg rounded-lg p-8 transform hover:scale-105 transition-transform duration-300">
                    <img class="w-32 h-32 rounded-full mb-4 sm:mb-0 sm:mr-4" src="{{ asset('images/user/Micakes.jpg') }}" alt="Roca Garnica Micaela Olga">
                    <div class="text-center sm:text-left">
                        <h4 class="text-xl font-bold text-blue-900">Roca Garnica Micaela Olga</h4>
                        <p class="text-gray-600">Estudiante de Ing. en Sistemas</p>
                        <div class="flex flex-col sm:flex-row items-center mt-2">
                            <i class="fas fa-envelope text-blue-900 mr-2"></i>
                            <a href="mailto:micaelaorocag@gmail.com" class="text-blue-500 hover:text-blue-700">micaelaorocag@gmail.com</a>
                        </div>
                        <div class="flex flex-col sm:flex-row items-center mt-2">
                            <i class="fas fa-phone text-blue-900 mr-2"></i>
                            <a href="https://wa.me/+59173666238" class="text-blue-500 hover:text-blue-700">+591 73666238</a>
                        </div>
                        <div class="flex flex-col sm:flex-row items-center mt-2">
                            <i class="fab fa-github text-blue-900 mr-2"></i>
                            <a href="https://github.com/MiCa-ke" class="text-blue-500 hover:text-blue-700" target="_blank">github.com/MiCa-ke</a>
                        </div>
                    </div>
                </div>
                <!--Rene-->
                <div class="flex flex-col sm:flex-row items-center bg-gray-50 shadow-lg rounded-lg p-8 transform hover:scale-105 transition-transform duration-300">
                    <img class="w-32 h-32 rounded-full mb-4 sm:mb-0 sm:mr-4" src="{{ asset('images/user/rene.jpeg') }}" alt="Chungara Martinez Rene Eduardo">
                    <div class="text-center sm:text-left">
                        <h4 class="text-xl font-bold text-blue-900">Chungara Martinez Rene Eduardo</h4>
                        <p class="text-gray-600">Estudiante de Ing. en Sistemas</p>
                        <div class="flex flex-col sm:flex-row items-center mt-2">
                            <i class="fas fa-envelope text-blue-900 mr-2"></i>
                            <a href="mailto:renechungara03@gmail.com" class="text-blue-500 hover:text-blue-700">renechungara03@gmail.com</a>
                        </div>
                        <div class="flex flex-col sm:flex-row items-center mt-2">
                            <i class="fas fa-phone text-blue-900 mr-2"></i>
                            <a href="https://wa.me/+59179903434" class="text-blue-500 hover:text-blue-700">+591 79903434</a>
                        </div>
                        <div class="flex flex-col sm:flex-row items-center mt-2">
                            <i class="fab fa-github text-blue-900 mr-2"></i>
                            <a href="https://github.com/Rene-Chungara" class="text-blue-500 hover:text-blue-700" target="_blank">github.com/Rene-Chungara</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mb-16">
                <div class="flex flex-col items-center">
                    <p class="mt-2 text-lg text-gray-500 italic">"La comunicación - la conexión humana - es la clave para el éxito personal y profesional." - Paul J. Meyer</p>
                </div>
            </div>
        </div>
    </section>

    @include('components.footer')
</body>
</html>
