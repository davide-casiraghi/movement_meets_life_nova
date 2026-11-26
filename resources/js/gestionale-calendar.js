// Calendar of the physiotherapy panel (/gestionale/calendario), built on FullCalendar.
// Exposes an Alpine component used by resources/views/filament/pages/calendario.blade.php.
import { Calendar } from '@fullcalendar/core';
import itLocale from '@fullcalendar/core/locales/it';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import interactionPlugin from '@fullcalendar/interaction';

window.gestionaleCalendar = ({ $wire, initialView = 'timeGridWeek' }) => ({
    calendar: null,
    title: '',
    view: initialView,
    professional: '',
    showCancelled: false,

    init() {
        this.calendar = new Calendar(this.$refs.calendar, {
            plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
            locale: itLocale,
            initialView,
            headerToolbar: false,
            height: '100%',
            firstDay: 1,
            nowIndicator: true,
            allDayText: 'Tutto il giorno',
            slotMinTime: '07:00:00',
            slotMaxTime: '21:00:00',
            scrollTime: '08:00:00',
            slotDuration: '00:15:00',
            slotLabelInterval: '01:00',
            slotLabelFormat: { hour: 'numeric' },
            dayHeaderFormat: { weekday: 'short', day: '2-digit', month: '2-digit', omitCommas: true },
            titleFormat: { day: 'numeric', month: 'short', year: 'numeric' },
            titleRangeSeparator: ' - ',
            selectable: true,
            selectMirror: true,
            editable: true,
            eventTimeFormat: { hour: '2-digit', minute: '2-digit' },
            noEventsText: 'Nessun evento in questo periodo',

            events: (info, success, failure) => {
                $wire
                    .getEvents(info.startStr, info.endStr, this.professional ? Number(this.professional) : null, this.showCancelled)
                    .then(success)
                    .catch(failure);
            },

            select: (info) => {
                $wire.mountAction('createEvent', { start: info.startStr, end: info.endStr });
                this.calendar.unselect();
            },

            eventClick: (info) => {
                $wire.mountAction('editEvent', { id: info.event.id });
            },

            eventDrop: (info) => this.move(info),
            eventResize: (info) => this.move(info),

            datesSet: () => {
                this.title = this.calendar.view.title;
                this.view = this.calendar.view.type;
            },
        });

        this.calendar.render();

        window.addEventListener('gestionale-calendar-refresh', () => this.calendar.refetchEvents());
    },

    move(info) {
        $wire
            .moveEvent(Number(info.event.id), info.event.startStr, info.event.endStr ?? info.event.startStr)
            .then((ok) => { if (! ok) info.revert(); })
            .catch(() => info.revert());
    },

    prev() { this.calendar.prev(); },
    next() { this.calendar.next(); },
    today() { this.calendar.today(); },
    changeView(view) { this.calendar.changeView(view); },
    refetch() { this.calendar.refetchEvents(); },
});
