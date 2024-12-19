<x-filament-widgets::widget>
    <x-filament::section>
        <div id="calendar"></div>
    </x-filament::section>
</x-filament-widgets::widget>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: '{{ $calendarView }}',
            events: @json($events),
            editable: true,
            selectable: true,
            eventClick: function(info) {
                alert('Event: ' + info.event.title);
            },
            select: function(info) {
                var title = prompt('Event Title:');
                if (title) {
                    fetch('/events', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            title: title,
                            start: info.start.toISOString(),
                            end: info.end.toISOString()
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        calendar.addEvent({
                            id: data.id,
                            title: data.title,
                            start: data.start,
                            end: data.end,
                            allDay: true
                        });
                    })
                    .catch(error => alert('There was a problem creating the event: ' + error.message));
                }
            }
        });

        calendar.render();
    });
</script>
@endpush
