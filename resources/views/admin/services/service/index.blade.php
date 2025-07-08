@extends('admin.layouts.master')
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List of Service for <span class="text-blue"><a href="{{ route('admin.service_category.index')}}">{{ $category->name}}</a></span></h3>


                            <!-- Page title actions -->
                            <div class="card-actions">
                                <a href="{{ route('admin.service.create', $category->slug)}}" class="btn btn-primary btn-3">
                                    <i class="ti ti-plus"></i> 
                                    Add new
                                </a>
                            </div>
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
        const notyf = new Notyf({
            duration: 4000,
            position: { x: 'right', y: 'top' },
            dismissible: true
        });

        $(document).on('change', '.status-select', function() {
            var id = $(this).data('id');
            var category_slug = $(this).data('category-id');
            var status = $(this).val();

            $.ajax({
                url: '{{ route("admin.service.update-status", ["category" => ":category", "service" => ":id"]) }}'.replace(':category', category_slug).replace(':id', id),
                type: 'POST',
                data: {
                    status: status,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    notyf.success(response.message || 'Status updated successfully');

                },
                error: function(xhr) {
                    notyf.error('Failed to update status');
                }
            });
        });
    </script>
@endpush
