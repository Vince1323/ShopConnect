// script.js

    // Initialisation du calendrier FullCalendar
    var calendarEl = document.getElementById('calendar');
    if (calendarEl) {
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'timeGridWeek,timeGridDay'
            },
            nowIndicator: true,
            slotMinTime: '08:00:00',
            slotMaxTime: '20:00:00',
            expandRows: true,
            height: 'auto',
            businessHours: {
                daysOfWeek: [1, 2, 3, 4, 5], // Lundi - Vendredi
                startTime: '08:00',
                endTime: '18:00',
            },
            events: [
                { title: 'Meeting', start: new Date(), end: new Date(new Date().setHours(new Date().getHours() + 1)) }
            ]
        });
        calendar.render();
    }
});
