@extends('admin.layouts.master')
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Holidays For Staffs</h3>
                        </div>


                        <div class="card-body border-bottom py-3">
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Feedback Modal -->
    <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="feedbackForm">
                @csrf
                <input type="hidden" name="holiday_id" id="holidayId">
                <input type="hidden" name="status" value="rejected">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Rejection Feedback</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label for="feedbackText" class="form-label">Feedback (required)</label>
                        <textarea name="feedback" id="feedbackText" class="form-control" required rows="4"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Submit Rejection</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    {{ $dataTable->scripts() }}

        <script>
        // Initialize Notyf
        const notyf = new Notyf({
            duration: 4000, 
            position: { x: 'right', y: 'top' },
            dismissible: true 
        });


        $(document).on('change', '.status-select', function () {
            var id = $(this).data('id');
            var status = $(this).val();

            if (status === 'rejected') {
                // Store the selected holiday ID in the modal
                $('#holidayId').val(id);
                $('#feedbackText').val(''); // clear previous
                $('#feedbackModal').modal('show');
                return;
            }

            // For other statuses, submit directly
            updateHolidayStatus(id, status);
        });

        function updateHolidayStatus(id, status) {
            $.ajax({
                url: '{{ route('admin.holidays.update', ':id') }}'.replace(':id', id),
                type: 'POST',
                data: {
                    status: status,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    notyf.success('Status updated successfully');
                    $('#holiday-table').DataTable().ajax.reload(); // Reload the datatable
                },
               error: function (xhr) {
                    const response = xhr.responseJSON;
                    const message = response?.error || 'Failed to update status';
                    notyf.error(message);
                }
            });
        }


        $('#feedbackForm').on('submit', function (e) {
            e.preventDefault();

            var id = $('#holidayId').val();
            var feedback = $('#feedbackText').val().trim();

            if (!feedback) {
                notyf.error('Feedback is required.');
                return;
            }

            $.ajax({
                url: '{{ route('admin.holidays.update', ':id') }}'.replace(':id', id),
                type: 'POST',
                data: {
                    status: 'rejected',
                    feedback: feedback,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $('#feedbackModal').modal('hide');
                    notyf.success('Status updated successfully');
                    $('#holiday-table').DataTable().ajax.reload(); // reload table
                },
                error: function (xhr) {
                    notyf.error('Failed to update status');
                }
            });
        });


    </script>
@endpush
