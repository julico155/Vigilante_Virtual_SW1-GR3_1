<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vigilante virtual</title>
  @vite('resources/css/app.css')
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
    .bg-blue-gradient {
      background: linear-gradient(to right, #1E40AF, #2563EB);
    }
    .nav-link {
      transition: background-color 0.3s ease, color 0.3s ease;
      font-weight: 500;
    }
    .nav-link:hover {
      background-color: rgba(255, 255, 255, 0.2);
      color: #fff;
    }
    .btn-primary {
      background-color: #2563EB;
      color: #fff;
      font-weight: 600;
      transition: background-color 0.3s ease;
    }
    .btn-primary:hover {
      background-color: #1E40AF;
    }
    .btn-secondary {
      background-color: #FBBF24;
      color: #fff;
      font-weight: 600;
      transition: background-color 0.3s ease;
    }
    .btn-secondary:hover {
      background-color: #F59E0B;
    }
    .mobile-menu-button {
      background-color: #1E40AF;
      transition: background-color 0.3s ease;
    }
    .mobile-menu-button:hover {
      background-color: #2563EB;
    }
    .mobile-menu {
      display: none;
    }
    .mobile-menu.active {
      display: block;
    }
    .dropdown-button {
        @apply ml-4 flex items-center md:ml-6 focus:outline-none;
    }

    .dropdown-menu {
        @apply absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-md overflow-hidden z-10 hidden;
    }

    .dropdown-menu a {
        @apply block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100;
    }

    .dropdown-menu button {
        @apply block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100;
    }
  </style>
  <!-- Import Inter Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100">

  <nav class="bg-blue-gradient shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg" alt="Workflow">
          </div>
          <div class="hidden md:block">
            <div class="ml-10 flex items-baseline space-x-4">
                @guest
                    <a href="/" class="text-white hover:text-blue-900 hover:bg-white px-3 py-2 rounded-md text-sm font-medium nav-link"><b>Inicio</b></a>
                    <a href="{{ route('acerca') }}" class="text-white hover:text-blue-900 hover:bg-white px-3 py-2 rounded-md text-sm font-medium nav-link"><b>Acerca de</b></a>
                    <a href="{{ route('contacto') }}" class="text-white hover:text-blue-900 hover:bg-white px-3 py-2 rounded-md text-sm font-medium nav-link"><b>Contacto</b></a>
                @else
                  <a href="{{ route('Estudiante.calendar') }}" class="text-white hover:text-blue-900 hover:bg-white px-3 py-2 rounded-md text-sm font-medium nav-link"><b>Inicio</b></a>
                  <a href="{{ route('Estudiante.index') }}" class="text-white hover:text-blue-900 hover:bg-white px-3 py-2 rounded-md text-sm font-medium nav-link"><b>Mis Materias</b></a>
                  <a href="{{ route('Estudiante.calificaciones') }}" class="text-white hover:text-blue-900 hover:bg-white px-3 py-2 rounded-md text-sm font-medium nav-link"><b>Mis Notas</b></a>
                @endguest
            </div>
          </div>
        </div>
        <div class="hidden md:block relative">
          <div>
              <button id="userDropdown" class="ml-4 flex items-center md:ml-6 focus:outline-none">
                  @auth
                      <span class="mr-2 text-white text-sm font-medium">{{ auth()->user()->name }}</span>
                      @if(auth()->user()->profile_photo_path)
                        <img class="h-8 w-8 rounded-full" src="{{ asset( auth()->user()->profile_photo_path) }}" alt="Foto de perfil">
                      @else
                          <span class="h-8 w-8 rounded-full bg-gray-300 inline-block"></span>
                      @endif
                  @else
                      <a href="{{ route('login') }}" class="bg-white px-3 py-2 rounded-md text-sm font-medium ml-2"><b>Iniciar Sesión</b></a>
                      <a href="{{ route('planes') }}" class="btn-secondary px-3 py-2 rounded-md text-sm font-medium ml-2"><b>Adquirir Plan</b></a>
                  @endauth
              </button>
          </div>
          <!-- Menú desplegable -->
          @auth
              <div id="userDropdownMenu" class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-md overflow-hidden z-10 hidden">
                  <a href="{{ route('Estudiante.perfil') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mi Perfil</a>
                  <form method="POST" action="{{ route('logout') }}">
                      @csrf
                      <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Cerrar Sesión</button>
                  </form>
              </div>
          @endauth
      </div>
      
      </div>
        <div class="flex md:hidden">
          <button type="button" class="mobile-menu-button inline-flex items-center justify-center p-2 rounded-md text-white hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-blue-800 focus:ring-white" aria-controls="mobile-menu" aria-expanded="false" id="mobile-menu-button">
            <span class="sr-only">Abrir menú principal</span>
            <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>
      </div>
    </div>

    <div class="mobile-menu md:hidden" id="mobile-menu">
      <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
        <a href="/" class="text-white hover:text-gray-300 block px-3 py-2 rounded-md text-base font-medium nav-link">Inicio</a>
        <a href="{{ route('acerca') }}" class="text-white hover:text-gray-300 block px-3 py-2 rounded-md text-base font-medium nav-link">Acerca de</a>
        <a href="{{ route('contacto') }}" class="text-white hover:text-gray-300 block px-3 py-2 rounded-md text-base font-medium nav-link">Contacto</a>
        <a href="{{ route('login') }}" class="btn-primary block text-center px-3 py-2 rounded-md text-base font-medium">Iniciar Sesión</a>
        <a href="{{ route('planes') }}" class="btn-secondary block text-center px-3 py-2 rounded-md text-base font-medium">Adquirir Plan</a>
      </div>
    </div>
  </nav>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const mobileMenuButton = document.getElementById('mobile-menu-button');
      const mobileMenu = document.getElementById('mobile-menu');
      const menuIconOpen = mobileMenuButton.querySelector('svg:first-of-type');
      const menuIconClose = mobileMenuButton.querySelector('svg:last-of-type');
  
      mobileMenuButton.addEventListener('click', function() {
        const expanded = mobileMenuButton.getAttribute('aria-expanded') === 'true' || false;
        mobileMenuButton.setAttribute('aria-expanded', !expanded);
        mobileMenu.classList.toggle('active');
        menuIconOpen.classList.toggle('hidden');
        menuIconClose.classList.toggle('hidden');
      });
    });


    // JavaScript para mostrar y ocultar el menú desplegable
    document.addEventListener('DOMContentLoaded', function() {
        const dropdownButton = document.getElementById('userDropdown');
        const dropdownMenu = document.getElementById('userDropdownMenu');

        if (dropdownButton) {
            dropdownButton.addEventListener('click', function() {
                if (dropdownMenu) {
                    dropdownMenu.classList.toggle('hidden');
                }
            });
        }

        // Ocultar el menú desplegable si se hace clic fuera de él
        document.addEventListener('click', function(event) {
            if (!dropdownButton.contains(event.target) && dropdownMenu && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });
    });
  </script>

</body>
</html>
