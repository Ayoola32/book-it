@extends('admin.layouts.master')
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Add New User</h3>

                            <!-- Page title actions -->
                            <div class="card-actions">
                                <a href="" class="btn btn-primary btn-3">
                                    <i class="ti ti-arrow-back-up"></i>
                                    Back

                                </a>
                            </div>
                        </div>

                        <form action="{{ route('admin.user.store') }}" method="POST" class="card" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label required">Name</label>
                                            <input type="text" class="form-control" name="name"
                                                placeholder="Full Name" value="{{ old('name') }}">
                                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label required">Role</label>
                                            <select id="role-select" class="form-select" name="role">
                                                <option value="">Select Role</option>
                                                <option value="user">User</option>
                                                <option value="employee">Employee</option>
                                                <option value="moderator">Moderator</option>
                                            </select>
                                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label required">Email</label>
                                            <input type="email" class="form-control" name="email"
                                                placeholder="email" value="{{ old('email') }}">
                                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label required">Phone Number</label>
                                            <input type="tel" class="form-control" name="phone"
                                                placeholder="Phone" value="{{ old('phone') }}">
                                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                        </div>
                                        <div class="col-md-1 mt-2">
                                            <x-input-toggle-block class="col-md-12 mt-3" name="status" label="Status" />
                                        </div>
                                    </div>
                                </div>




                                <div id="employee-fields" class="row" style="{{ old('role') === 'employee' ? '' : 'display: none;' }}">
                                    <div class="col-md-12">
                                        <hr>
                                        <h4>Employee Details</h4>

                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <label class="form-label">Service</label>
                                                <select id="service" name="service[]" data-placeholder="Select Service" multiple data-multi-select>
                                                    @foreach ($services as $service)
                                                        <option value="{{ $service->id }}" {{ in_array($service->id, old('service', [])) ? 'selected' : '' }}>
                                                            {{ $service->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-2">
                                                <label class="form-label">Slot Duration (minutes)</label>
                                                <select name="slot_duration" class="form-control">
                                                    <option value="">Select Duration</option>
                                                    @foreach (['10', '15', '20', '30', '45', '60'] as $duration)
                                                        <option value="{{ $duration }}" {{ old('slot_duration') == $duration ? 'selected' : '' }}>
                                                            {{ $duration }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-2">
                                                <div class="form-group">
                                                    <label class="form-label">Break Duration (minutes)</label>
                                                    <select name="break_duration" class="form-control">
                                                        <option value="">No Break</option>
                                                        @foreach (['5', '10', '15', '20', '25', '30'] as $break)
                                                            <option value="{{ $break }}" {{ old('break_duration') == $break ? 'selected' : '' }}>
                                                                {{ $break }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>




                                <div class="text-start">
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    {{-- Display Employee Field if Role == 'employee' --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roleSelect = document.getElementById('role-select');
            const employeeFields = document.getElementById('employee-fields');

            function toggleEmployeeFields() {
                if (roleSelect.value === 'employee') {
                    employeeFields.style.display = 'block';
                } else {
                    employeeFields.style.display = 'none';
                }
            }

            // Initial check (e.g. after page reload with old input)
            toggleEmployeeFields();

            // Listen to change event
            roleSelect.addEventListener('change', toggleEmployeeFields);
        });
    </script>

@endpush
