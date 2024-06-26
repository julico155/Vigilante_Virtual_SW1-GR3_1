<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar Sesión</title>
  @vite('resources/css/app.css')
  <style>
    body {
      background-color: #f3f4f6;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .login-container {
      display: flex;
      flex-direction: column;
      background-color: #ffffff;
      border-radius: 0.5rem;
      box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      max-width: 900px;
      width: 100%;
    }
    .login-image {
      display: none;
      background: url('https://img.freepik.com/fotos-premium/fotografia-fondo-negro-elegante-salon-clases_960396-117963.jpg') no-repeat center center;
      background-size: cover;
      width: 100%;
      height: 200px;
    }
    .login-box {
      padding: 2rem;
      width: 100%;
    }
    .alert {
      background-color: #f8d7da;
      color: #721c24;
      padding: 0.75rem;
      border-radius: 0.375rem;
      margin-bottom: 1rem;
      text-align: center;
      animation: fadeIn 0.5s ease-in-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
    @media (min-width: 768px) {
      .login-container {
        flex-direction: row;
      }
      .login-image {
        display: block;
        width: 50%;
        height: auto;
      }
      .login-box {
        width: 50%;
      }
    }
  </style>
</head>
<body>

  <div class="login-container">
    <div class="login-image"></div>
    <div class="login-box">
      <div class="text-center mb-6">
        <img class="mx-auto h-12 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg" alt="Workflow">
        <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Iniciar Sesión</h2>
      </div>

      @if ($errors->any())
        <div class="alert">
          {{ $errors->first() }}
        </div>
      @endif

      <form action="{{ route('login') }}" method="POST">
        @csrf

        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico:</label>
          <input type="email" id="email" name="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required autofocus autocomplete="username" :value="old('email')">
        </div>

        <div class="mt-4">
          <label for="password" class="block text-sm font-medium text-gray-700">Contraseña:</label>
          <input type="password" id="password" name="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required autocomplete="current-password">
        </div>

        <div class="block mt-4">
          <label for="remember_me" class="flex items-center">
            <input type="checkbox" id="remember_me" name="remember" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
            <span class="ml-2 text-sm text-gray-600">Recuérdame</span>
          </label>
        </div>

        <div class="flex items-center justify-between mt-4">
          @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-500">¿Olvidaste tu contraseña?</a>
          @endif
          <button type="submit" class="ml-3 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Iniciar Sesión
          </button>
        </div>
      </form>

    </div>
  </div>

</body>
</html>
