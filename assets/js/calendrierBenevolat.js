document.addEventListener('DOMContentLoaded', function () {
    const volunteerCalendarElt = document.querySelector("#volunteer-calendar");
    const volunteerData = JSON.parse(volunteerCalendarElt.getAttribute('data-events'));

    const volunteerCalendar = new FullCalendar.Calendar(volunteerCalendarElt, {
        initialView: 'dayGridMonth',
        locale: 'fr',
        headerToolbar: {
            start: 'dayGridMonth,timeGridWeek',
            center: 'title',
            end: 'prev,next today'
        },
        events: volunteerData,
        dateClick: handleDateClick,
        eventClick: handleEventClick
    });

    let dateClicked = null;

    function handleDateClick(info) {
        dateClicked = info.dateStr;

        const startTimeSelect = document.getElementById('heure_debut');
        const endTimeSelect = document.getElementById('heure_fin');

        startTimeSelect.innerHTML = '';
        endTimeSelect.innerHTML = '';

        for (let hour = 8; hour <= 20; hour++) {
            startTimeSelect.innerHTML += `<option value="${hour}:00">${hour}:00</option>`;
            endTimeSelect.innerHTML += `<option value="${hour}:00">${hour}:00</option>`;
        }

        displayTimeSlotModal();
    }

    function handleEventClick(info) {
        const modalBody = '<p>Contenu du créneau disponible</p>';
        document.querySelector('#timeSlotModal .modal-header').innerHTML = `<h5 class="modal-title">Créneaux disponibles</h5>`;
        document.querySelector('#timeSlotModal .modal-body').innerHTML = modalBody;

        displayTimeSlotModal();
    }

    function displayTimeSlotModal() {
        const timeSlotModal = new bootstrap.Modal(document.getElementById('timeSlotModal'), {
            backdrop: 'static',
            keyboard: false
        });
        timeSlotModal.show();

        const btnNextStep = document.getElementById('btnNextStep');
        btnNextStep.onclick = function () {
            const heureDebut = document.getElementById('heure_debut').value;
            const heureFin = document.getElementById('heure_fin').value;
            const nombreParticipants = document.getElementById('nombre_participants').value;

            const url = `/formulaires/benevole/new?heure_debut=${heureDebut}&heure_fin=${heureFin}&nombre_participants=${nombreParticipants}`;
            window.location.href = url;
        };
    }

    volunteerCalendar.render();
});
