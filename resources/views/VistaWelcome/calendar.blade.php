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
        <main class="w-full max-w-6xl mx-auto px-4 py-8 md:px-6 md:py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="col-span-2">
                    <div id='calendar2' class="w-full h-full bg-white p-4 rounded-lg shadow-md"></div>
                </div>
                <div class="col-span-1">
                    <div id='calendar' class="w-full h-full bg-white p-4 rounded-lg shadow-md"></div>
                </div>
            </div>
        </main>
    @include('components.footer')


    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet">

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'es',
            initialView: 'listWeek',
            themeSystem: 'bootstrap',
            events: @json($events),
        });
        calendar.render();
    });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar2');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'es',
            initialView: 'dayGridMonth',
            events: @json($events)
        });
        calendar.render();
    });
    </script>

</body>
</html>
