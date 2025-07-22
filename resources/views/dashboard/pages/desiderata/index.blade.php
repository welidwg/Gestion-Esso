@extends('dashboard/base')
@section('title')
    Calendrier
@endsection
@section('content')
    <style>
        #reportTable {
            font-size: 0.9rem;
        }

        #reportTable th {
            background-color: #f8f9fa;
            position: sticky;
            top: 0;
        }

        #reportTable td {
            vertical-align: middle;
            min-width: 120px;
        }

        #reportTable tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        #calendar {
            /*max-width: 1000px;*/
            margin: 40px auto;
        }

        .shift-select {
            margin-top: 20px;
        }

        #shiftModal {
            display: none;
            position: fixed;
            top: 20%;


            padding: 20px;
            z-index: 9999;
            /* 🟢 Critical */
            /*box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);*/
            /* Optional */
        }

        .fc-holiday {
            background-color: rgba(255, 0, 0, 0.1) !important;
        }

        /* Optional: Style for holiday text */
        .fc-day[data-date^="2024-"] .fc-daygrid-day-top {
            position: relative;
        }

        .fc-day[data-date^="2024-"] .fc-daygrid-day-top::after {
            content: attr(data-holiday);
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #d50000;
        }

        .fc-event-taken {
            background-color: #ffcccc !important;
            border-color: #ff9999 !important;
        }

        .fc-event-own {
            background-color: #ccffcc !important;
            border-color: #99ff99 !important;
        }

        .fc-day-completely-booked {
            background-color: #a5a5a58a !important;
            position: relative;
        }

        .fc-day-completely-booked::after {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 0.8em;
            color: #6c757d;
            font-weight: bold;
        }
    </style>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Calendrier des Créneaux</h2>
        @if (auth()->user()->role == 0)
            <button id="generateReportBtn" class="btn btn-primary">
                <i class="fas fa-file-excel me-2"></i>Générer Rapport
            </button>
        @endif
    </div>
    <div id='calendar'></div>

    <!-- Modal/Popup UI -->
    <div class="modal fade" id="shiftModal" tabindex="-1" aria-labelledby="shiftModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="shiftForm" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shiftModalLabel">Choisissez votre poste</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="modalDateText"></p>
                    <input type="hidden" name="choosen_date" id="selectedDate">

                    <!-- Add user selection for admin -->
                    @if (Auth::user()->role == 0)
                        <div class="mb-3">
                            <label for="userSelect" class="form-label">Utilisateur</label>
                            <select class="form-select" id="userSelect" name="user_id">
                                @foreach ($users as $user)
                                    <option value="{{ $user['id'] }}">
                                        {{ $user['nom'] }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                        @if ($users->isEmpty())
                            <small class="text-danger">Aucun utilisateur disponible</small>
                        @endif
                    @else
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    @endif

                    <div id="shiftOptions" class="form-check">

                        <!-- Shift radio buttons will go here -->
                    </div>
                    <div class="form-check col mb-2">
                        <input type="checkbox" class="form-check-input" name="isAbsent" id="isAbsent">
                        <label class="form-check-label text-size-md" for="isAbsent">
                            Absent ce jour?
                        </label>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="reportModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Rapport des Créneaux - <span id="reportMonthTitle"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="reportTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <!-- User headers will be added dynamically -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be added dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button id="exportExcelBtn" type="button" class="btn btn-success">
                        <i class="fas fa-file-excel me-2"></i>Exporter Excel
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const modal = new bootstrap.Modal(document.getElementById('shiftModal'));
            const modalDateText = document.getElementById('modalDateText');
            const selectedDateInput = document.getElementById('selectedDate');
            const shiftOptions = document.getElementById('shiftOptions');

            function isFrenchHoliday(dateStr, holidays) {
                return holidays.some(holiday => holiday.start === dateStr);
            }

            function getFrenchHolidays(year) {
                const holidays = [];

                // Fixed date holidays
                holidays.push({
                    title: 'Jour de l\'an',
                    start: `${year}-01-01`,
                    color: '#ff0000',
                    display: 'background'
                });

                holidays.push({
                    title: 'Fête du travail',
                    start: `${year}-05-01`,
                    color: '#ff0000',
                    display: 'background'
                });

                holidays.push({
                    title: 'Victoire 1945',
                    start: `${year}-05-08`,
                    color: '#ff0000',
                    display: 'background'
                });

                holidays.push({
                    title: 'Fête nationale',
                    start: `${year}-07-14`,
                    color: '#ff0000',
                    display: 'background'
                });

                holidays.push({
                    title: 'Assomption',
                    start: `${year}-08-15`,
                    color: '#ff0000',
                    display: 'background'
                });

                holidays.push({
                    title: 'Toussaint',
                    start: `${year}-11-01`,
                    color: '#ff0000',
                    display: 'background'
                });

                holidays.push({
                    title: 'Armistice 1918',
                    start: `${year}-11-11`,
                    color: '#ff0000',
                    display: 'background'
                });

                holidays.push({
                    title: 'Noël',
                    start: `${year}-12-25`,
                    color: '#ff0000',
                    display: 'background'
                });

                // Variable date holidays (Easter based)
                const easter = getEasterDate(year);

                holidays.push({
                    title: 'Lundi de Pâques',
                    start: dateFns.addDays(easter, 1),
                    color: '#ff0000',
                    display: 'background'
                });

                holidays.push({
                    title: 'Ascension',
                    start: dateFns.addDays(easter, 39),
                    color: '#ff0000',
                    display: 'background'
                });

                holidays.push({
                    title: 'Lundi de Pentecôte',
                    start: dateFns.addDays(easter, 50),
                    color: '#ff0000',
                    display: 'background'
                });

                return holidays;
            }

            // Function to calculate Easter date
            function getEasterDate(year) {
                const a = year % 19;
                const b = Math.floor(year / 100);
                const c = year % 100;
                const d = Math.floor(b / 4);
                const e = b % 4;
                const f = Math.floor((b + 8) / 25);
                const g = Math.floor((b - f + 1) / 3);
                const h = (19 * a + b - d - g + 15) % 30;
                const i = Math.floor(c / 4);
                const k = c % 4;
                const l = (32 + 2 * e + 2 * i - h - k) % 7;
                const m = Math.floor((a + 11 * h + 22 * l) / 451);
                const month = Math.floor((h + l - 7 * m + 114) / 31);
                const day = ((h + l - 7 * m + 114) % 31) + 1;

                return new Date(year, month - 1, day);
            }

            // Initialize calendar with holidays
            const currentYear = new Date().getFullYear();
            const frenchHolidays = getFrenchHolidays(currentYear);

            const calendar = new FullCalendar.Calendar(calendarEl, {
                // ... existing configuration ...
                locale: 'fr',
                validRange: function(nowDate) {
                    // Only show current month and future months
                    return {
                        start: nowDate
                    };
                },
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth'
                },
                buttonText: {
                    today: 'Aujourd\'hui',
                    month: 'Mois',

                },
                firstDay: 1,
                initialView: 'dayGridMonth',
                eventSources: [{
                        url: '{{ route('desiderata.events') }}',
                        method: 'GET',
                        failure: () => alert('There was an error while fetching events.')
                    },
                    {
                        events: frenchHolidays.map(holiday => ({
                            ...holiday,
                            editable: false,
                            startEditable: false,
                            durationEditable: false,
                            resourceEditable: false,
                            overlap: false,
                            display: '',
                            className: 'fc-holiday'
                        }))
                    }
                ],
                eventClick: function(info) {
                    var eventDate = moment(info.event.start).format("YYYY-MM-DD");
                    console.log(eventDate);
                    const isHoliday = info.event.display === 'background' ||
                        info.event.backgroundColor === '#ff0000' ||
                        info.event.classNames.includes('fc-holiday') ||
                        info.event.title.includes('Jour férié');
                    if (isHoliday) {
                        return;
                    }

                    const currentUserId = {{ auth()->id() ?? 'null' }};
                    const isAdmin = '{{ Auth::user()->role == 0 }}';


                    if (currentUserId !== info.event.extendedProps.userId && !isAdmin) {
                        alert("Vous ne pouvez supprimer que vos propres créneaux");
                        return;
                    }

                    if (confirm("Êtes-vous sûr de vouloir supprimer ce créneau?")) {
                        const eventId = info.event.id;

                        fetch(`/desiderata/${eventId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                }
                            })
                            .then(async response => {
                                if (response.ok) {
                                    info.event.remove();


                                    await checkDateAvailability(`${eventDate}`);
                                    alert("Créneau supprimé avec succès");
                                } else {
                                    throw new Error("Échec de la suppression du créneau");
                                }
                            })
                            .catch(error => {
                                alert(error.message);
                            });
                    }
                },
                datesSet: async function(info) {
                    const start = info.startStr;
                    const end = info.endStr;

                    try {
                        // First remove all existing "completely booked" classes
                        document.querySelectorAll('.fc-day').forEach(dayEl => {
                            dayEl.classList.remove('fc-day-completely-booked');
                        });

                        // Check each visible date
                        const days = document.querySelectorAll('.fc-day');
                        for (const dayEl of days) {
                            const dateStr = dayEl.getAttribute('data-date');
                            if (!dateStr) continue;

                            const date = new Date(dateStr);
                            const day = date.getDay();
                            const isWeekend = (day === 0 || day === 6);
                            const isHoliday = isFrenchHoliday(dateStr, frenchHolidays);

                            // Skip weekends and holidays
                            // if (isWeekend || isHoliday) continue;

                            // Get shifts for this date (using the same logic as your modal)
                            let existingShifts = [];
                            try {
                                const response = await fetch(
                                    `{{ route('desiderata.shifts') }}?date=${dateStr}`
                                );
                                if (response.ok) {
                                    const data = await response.json();
                                    existingShifts = data.assigned_shifts || [];
                                }
                            } catch (error) {
                                console.error('Error fetching shifts:', error);
                            }

                            // Determine available shifts (same logic as your modal)
                            const allShifts = isHoliday ? [{
                                    start: '09:00',
                                    end: '15:00'
                                },
                                {
                                    start: '15:00',
                                    end: '21:00'
                                }
                            ] : isWeekend ? [{
                                    start: '06:30',
                                    end: '14:00'
                                },
                                {
                                    start: '14:00',
                                    end: '21:00'
                                }
                            ] : [{
                                    start: '06:30',
                                    end: '11:00'
                                },
                                {
                                    start: '11:00',
                                    end: '15:00'
                                },
                                {
                                    start: '15:00',
                                    end: '21:00'
                                },
                                {
                                    start: '06:30',
                                    end: '14:00'
                                },
                                {
                                    start: '14:00',
                                    end: '21:00'
                                }
                            ];

                            const availableShifts = allShifts.filter(shift => {
                                const shiftStart = timeToMinutes(shift.start);
                                const shiftEnd = timeToMinutes(shift.end);

                                return !existingShifts.some(existing => {
                                    const existingStart = timeToMinutes(existing
                                        .shift_start);
                                    const existingEnd = timeToMinutes(existing
                                        .shift_end);
                                    return (shiftStart < existingEnd && shiftEnd >
                                        existingStart);
                                });
                            });

                            // If no shifts available, mark as completely booked
                            if (availableShifts.length === 0) {
                                dayEl.classList.add('fc-day-completely-booked');
                            }
                        }
                    } catch (error) {
                        console.error('Error checking booked dates:', error);
                    }
                },

                dateClick: async function(info) {
                    const isAdmin = {{ Auth::user()->role == 0 ? 'true' : 'false' }};


                    const date = info.dateStr;
                    const day = new Date(date).getDay();
                    const isWeekend = (day === 0 || day === 6);
                    const isHoliday = isFrenchHoliday(info.dateStr, frenchHolidays);
                    const currentUserId = {{ auth()->id() ?? 'null' }};

                    if (isHoliday) {
                        const holiday = frenchHolidays.find(h => h.start === info.dateStr);
                        // return;
                    }

                    // Fetch existing shifts for this date (excluding current user's shifts)
                    let existingShifts = [];
                    try {
                        const response = await fetch(
                            `{{ route('desiderata.shifts') }}?date=${date}&exclude_user=${currentUserId}`
                        );
                        if (response.ok) {
                            existingShifts = await response.json();
                            console.log('Existing shifts (excluding current user):', existingShifts);
                        }
                    } catch (error) {
                        console.error('Error fetching shifts:', error);
                    }

                    modalDateText.textContent = `Sélectionnez votre créneau pour le ${date}`;
                    selectedDateInput.value = date;

                    shiftOptions.innerHTML = '';

                    // Define all possible shifts
                    const allShifts = isHoliday ? [{
                            start: '09:00',
                            end: '15:00',
                            label: '09:00 - 15:00'
                        },
                        {
                            start: '15:00',
                            end: '21:00',
                            label: '15:00 - 21:00'
                        }
                    ] : isWeekend ? [{
                            start: '06:30',
                            end: '14:00',
                            label: '06:30 - 14:00'
                        },
                        {
                            start: '14:00',
                            end: '21:00',
                            label: '14:00 - 21:00'
                        },
                    ] : [{
                            start: '06:30',
                            end: '11:00',
                            label: '06:30 - 11:00'
                        },
                        {
                            start: '11:00',
                            end: '15:00',
                            label: '11:00 - 15:00'
                        },
                        {
                            start: '15:00',
                            end: '21:00',
                            label: '15:00 - 21:00'
                        }, {
                            start: '06:30',
                            end: '14:00',
                            label: '06:30 - 14:00 (1ère moitié)'
                        },
                        {
                            start: '14:00',
                            end: '21:00',
                            label: '14:00 - 21:00 (2ème moitié)'
                        },
                    ];

                    // Filter out taken shifts
                    const availableShifts = allShifts.filter(shift => {
                        // Convert to minutes for easier comparison
                        const shiftStart = timeToMinutes(shift.start);
                        const shiftEnd = timeToMinutes(shift.end);

                        // Check if this shift overlaps with any existing shift
                        return !existingShifts["assigned_shifts"].some(existing => {
                            const existingStart = timeToMinutes(existing.shift_start);
                            const existingEnd = timeToMinutes(existing.shift_end);

                            // Check for time overlap
                            return (shiftStart < existingEnd && shiftEnd >
                                existingStart);
                        });
                    });

                    // Helper function to convert time string to minutes
                    function timeToMinutes(timeStr) {
                        if (timeStr != null) {
                            const [hours, minutes] = timeStr.split(':').map(Number);
                            return hours * 60 + minutes;
                        }

                    }

                    if (availableShifts.length === 0) {
                        shiftOptions.innerHTML = `
            <div class="alert alert-warning">
                Tous les créneaux sont déjà pris pour cette date
            </div>
        `;
                    } else {
                        availableShifts.forEach((shift, index) => {
                            shiftOptions.innerHTML += `
                <div class="form-check">
                    <input class="form-check-input" type="radio" 
                           name="shift" id="shift${index}" 
                           value="${shift.start},${shift.end}" >
                    <label class="form-check-label" for="shift${index}">
                        ${shift.label}
                    </label>
                </div>
            `;
                        });
                    }

                    modal.show();
                },
                // ... rest of your configuration ...
            });

            calendar.render();

            document.getElementById('shiftForm').addEventListener('submit', async function(e) {
                e.preventDefault();
                const isAdmin = {{ auth()->user()->role == 0 ? 'true' : 'false' }};
                const formData = new FormData(this);
                const eventId = this.dataset.eventId;
                if (eventId) {
                    formData.append('shift_id', eventId);
                }
                // Get the selected shift value (start,end)*
                console.log(formData.get('shift'));

                if (formData.get('shift') != null) {
                    const shiftValue = formData.get('shift').split(',');

                    // Add the start and end times to the form data
                    formData.append('shift_start', shiftValue[0]);
                    formData.append('shift_end', shiftValue[1]);
                }


                // For admin, use selected user_id, for others use their own ID
                if (!isAdmin) {
                    formData.append('user_id', {{ auth()->id() }});
                }

                const res = await fetch("{{ route('desiderata.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                if (res.ok) {
                    calendar.refetchEvents();
                    await checkDateAvailability(formData.get('choosen_date'));
                    modal.hide();
                } else {
                    const error = await res.json();
                    console.log(error);

                    alert("Erreur: " + (error.message || "Impossible d'enregistrer le créneau"));
                }
            });
            document.getElementById('generateReportBtn').addEventListener('click', async function() {
                const currentDate = calendar.getDate();
                const year = currentDate.getFullYear();
                const month = currentDate.getMonth() + 1; // Months are 0-indexed

                try {
                    // Show loading state
                    this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Chargement...';

                    // Fetch report data
                    const response = await fetch(
                        `{{ route('desiderata.report') }}?year=${year}&month=${month}`);
                    const reportData = await response.json();


                    // Generate the report table
                    generateReportTable(reportData, year, month);

                    // Show the modal
                    const reportModal = new bootstrap.Modal(document.getElementById('reportModal'));
                    reportModal.show();

                } catch (error) {
                    console.error('Error generating report:', error);
                    alert('Erreur lors de la génération du rapport');
                } finally {
                    this.innerHTML = '<i class="fas fa-file-excel me-2"></i>Générer Rapport';
                }
            });

            // Export to Excel
            document.getElementById('exportExcelBtn').addEventListener('click', function() {
                exportToExcel();
            });

            function generateReportTable(data, year, month) {
                const monthNames = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin",
                    "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"
                ];

                // Set month title
                document.getElementById('reportMonthTitle').textContent = `${monthNames[month-1]} ${year}`;

                const table = document.getElementById('reportTable');
                const thead = table.querySelector('thead');
                const tbody = table.querySelector('tbody');

                // Clear existing content
                thead.innerHTML = '<tr><th>Date</th></tr>';
                tbody.innerHTML = '';

                // Add user columns to header
                data.users.forEach(user => {
                    const th = document.createElement('th');
                    th.textContent = user.nom;
                    thead.querySelector('tr').appendChild(th);
                });

                // Add rows for each date
                data.dates.forEach(dateData => {
                    const row = document.createElement('tr');

                    // Date cell
                    const dateCell = document.createElement('td');
                    dateCell.textContent = dateData.date;
                    row.appendChild(dateCell);

                    // User cells
                    data.users.forEach(user => {
                        const userCell = document.createElement('td');
                        const userShift = dateData.shifts.find(shift => shift.user_id === user.id);
                        userCell.textContent = userShift ? userShift.shift_start == null ?
                            'Absent' :
                            `${userShift.shift_start} - ${userShift.shift_end}` :
                            '-';
                        row.appendChild(userCell);
                    });

                    tbody.appendChild(row);
                });
            }

            function exportToExcel() {
                // You can use a library like SheetJS (xlsx) for proper Excel export
                // This is a simple CSV export alternative
                const table = document.getElementById('reportTable');
                let csv = [];

                // Get headers
                const headers = [];
                table.querySelectorAll('thead th').forEach(th => {
                    headers.push(th.textContent);
                });
                csv.push(headers.join(','));

                // Get rows
                table.querySelectorAll('tbody tr').forEach(tr => {
                    const row = [];
                    tr.querySelectorAll('td').forEach(td => {
                        row.push(td.textContent);
                    });
                    csv.push(row.join(','));
                });

                // Download CSV
                const csvContent = csv.join('\n');
                const blob = new Blob([csvContent], {
                    type: 'text/csv;charset=utf-8;'
                });
                const link = document.createElement('a');
                const url = URL.createObjectURL(blob);

                link.setAttribute('href', url);
                link.setAttribute('download',
                    `creneaux_${document.getElementById('reportMonthTitle').textContent}.csv`);
                link.style.visibility = 'hidden';

                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }

            function timeToMinutes(timeStr) {
                if (!timeStr) return 0;
                const [hours, minutes] = timeStr.split(':').map(Number);
                return hours * 60 + minutes;
            }
            async function checkDateAvailability(dateStr) {
                const date = new Date(dateStr);
                const day = date.getDay();
                const isWeekend = (day === 0 || day === 6);
                const isHoliday = isFrenchHoliday(dateStr, frenchHolidays);

                // Skip weekends and holidays
                //if (isWeekend || isHoliday) return;

                const dayEl = document.querySelector(`.fc-day[data-date="${dateStr}"]`);
                if (!dayEl) return;

                // Get shifts for this date
                let existingShifts = [];
                try {
                    const response = await fetch(
                        `{{ route('desiderata.shifts') }}?date=${dateStr}`
                    );
                    if (response.ok) {
                        const data = await response.json();
                        existingShifts = data.assigned_shifts || [];
                    }
                } catch (error) {
                    console.error('Error fetching shifts:', error);
                }

                // Determine available shifts
                const allShifts = isHoliday ? [{
                        start: '09:00',
                        end: '15:00'
                    },
                    {
                        start: '15:00',
                        end: '21:00'
                    }
                ] : isWeekend ? [{
                        start: '06:30',
                        end: '14:00'
                    },
                    {
                        start: '14:00',
                        end: '21:00'
                    }
                ] : [{
                        start: '06:30',
                        end: '11:00'
                    },
                    {
                        start: '11:00',
                        end: '15:00'
                    },
                    {
                        start: '15:00',
                        end: '21:00'
                    },
                    {
                        start: '06:30',
                        end: '14:00'
                    },
                    {
                        start: '14:00',
                        end: '21:00'
                    }
                ];

                const availableShifts = allShifts.filter(shift => {
                    const shiftStart = timeToMinutes(shift.start);
                    const shiftEnd = timeToMinutes(shift.end);

                    return !existingShifts.some(existing => {
                        const existingStart = timeToMinutes(existing.shift_start);
                        const existingEnd = timeToMinutes(existing.shift_end);
                        return (shiftStart < existingEnd && shiftEnd > existingStart);
                    });
                });

                // Toggle the completely-booked class
                if (availableShifts.length === 0) {
                    dayEl.classList.add('fc-day-completely-booked');
                } else {
                    dayEl.classList.remove('fc-day-completely-booked');
                }
            }
        });
    </script>
@endsection
