@extends('Panza')
@section('Panza')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="col-span-2">
            <div id='calendar2' class="w-full h-full"></div>
        </div>
    <div class="col-span-1">
        <div id='calendar' class="w-full h-full"></div>
    </div>


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


@endsection