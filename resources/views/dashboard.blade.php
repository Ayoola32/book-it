@extends('layouts.master')
@section('content')

    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Overview
                    </div>
                    <h2 class="page-title">
                        Dashboard
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Page body -->
    <div class="page-body">
        <div class="container-fluid">
            <div id="calendar"></div>
        </div>
    </div>

    <!-- Appointment Modal -->
    <form id="appointmentStatusForm" method="POST" action="{{ route('appointment.update-status')}}">
        @csrf
        <input type="hidden" name="appointment_id" id="modalAppointmentId">

        <div class="modal fade" id="appointmentModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Appointment Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <p><strong>Client:</strong> <span id="modalAppointmentName">N/A</span></p>
                        <p><strong>Service:</strong> <span id="modalService">N/A</span></p>
                        <p><strong>Email:</strong> <span id="modalEmail">N/A</span></p>
                        <p><strong>Phone:</strong> <span id="modalPhone">N/A</span></p>
                        <p><strong>Staff:</strong> <span id="modalStaff">N/A</span></p>
                        <p><strong>Start:</strong> <span id="modalStartTime">N/A</span></p>
                        <p><strong>Amount:</strong> <span id="modalAmount">N/A</span></p>
                        <p><strong>Notes:</strong> <span id="modalNotes">N/A</span></p>
                        <p><strong>Current Status:</strong> <span id="modalStatusBadge">N/A</span></p>

                        <div class="form-group">
                            <label><strong>Status:</strong></label>
                            <select name="status" class="form-control" id="modalStatusSelect">
                                <option value="Pending">Pending</option>
                                <option value="Processing">Processing</option>
                                <option value="Confirmed">Confirmed</option>
                                <option value="Cancelled">Cancelled</option>
                                <option value="Completed">Completed</option>
                                <option value="On Hold">On Hold</option>
                                <option value="No Show">No Show</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-12 text-end">
                                <p class="text-danger mt-2 d-none" id="statusLockedMessage">
                                    You cannot change the status of a Cancelled / Completed Appointment.
                                </p>
                                <p class="text-secondary mt-2" id="statusNotifyMessage">
                                    <strong>Note:</strong> Changing the status will notify the client via email.
                                </p>
                                <button type="submit"
                                        id="updateStatusButton"
                                        class="btn btn-danger me-2">Update Status</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet" />

    <style>
        #calendar {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100% !important;
        }
        #calendar {
            min-height: 600px;
            height: auto;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

    <script>
        // Initialize FullCalendar
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: @json($appointments ?? []),
                dateClick: function(info) {
                    // When clicking a date in month view, navigate to day view for that date
                    if (calendar.view.type === 'dayGridMonth') {
                        calendar.changeView('timeGridDay', info.dateStr);
                    }
                },
                eventClick: function(info) {
                    var calEvent = info.event;

                    $('#modalAppointmentId').val(calEvent.id);
                    $('#modalAppointmentName').text(calEvent.extendedProps.name || calEvent.title.split(' - ')[0] || 'N/A');
                    $('#modalService').text(calEvent.extendedProps.service_title || calEvent.title.split(' - ')[1] || 'N/A');
                    $('#modalEmail').text(calEvent.extendedProps.email || 'N/A');
                    $('#modalPhone').text(calEvent.extendedProps.phone || 'N/A');
                    $('#modalStaff').text(calEvent.extendedProps.staff || 'N/A');
                    $('#modalAmount').text(calEvent.extendedProps.amount || 'N/A');
                    $('#modalNotes').text(calEvent.extendedProps.notes || 'N/A');
                    $('#modalStartTime').text(moment(calEvent.start).format('MMMM D, YYYY h:mm A'));

                    var status = calEvent.extendedProps.status || 'Pending';
                    $('#modalStatusSelect').val(status);

                    var statusColors = {
                        'Pending': '#f39c12',
                        'Processing': '#3498db',
                        'Confirmed': '#2ecc71',
                        'Cancelled': '#ff0000',
                        'Completed': '#008000',
                        'On Hold': '#95a5a6',
                        'No Show': '#e67e22',
                    };
                    var badgeColor = statusColors[status] || '#7f8c8d';
                    $('#modalStatusBadge').html(
                        `<span class="badge px-2 py-1" style="background-color: ${badgeColor}; color: white;">${status}</span>`
                    );

                    if (status === 'Cancelled' || status === 'Completed') {
                        $('#updateStatusButton').prop('disabled', true);
                        $('#statusLockedMessage').removeClass('d-none');
                        $('#statusNotifyMessage').addClass('d-none');
                    } else {
                        $('#updateStatusButton').prop('disabled', false);
                        $('#statusLockedMessage').addClass('d-none');
                        $('#statusNotifyMessage').removeClass('d-none');
                    }

                    var modal = new bootstrap.Modal(document.getElementById('appointmentModal'));
                    modal.show();
                }
            });
            calendar.render();
        });

    </script>



@endpush
