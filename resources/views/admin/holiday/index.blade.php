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

        $(document).on('change', '.status-select', function() {
            var id = $(this).data('id');
            var status = $(this).val();


            $.ajax({
                url: '{{ route('admin.holidays.update', ':id') }}'.replace(':id', id),
                type: 'POST',
                data: {
                    status: status,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    notyf.success('Holida Status updated successfully');
                    $('#holiday-table').DataTable().ajax.reload(null, false); // ✅ Good: Reloads table
                },
                error: function(xhr) {
                    notyf.error('Failed to update status');
                }
            });
        });
    </script>
@endpush
