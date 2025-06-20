@extends('admin.layouts.master')
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Update User:  <span class="text-blue">{{$user->name}}</span></h3>

                            <!-- Page title actions -->
                            <div class="card-actions">
                                <a href="{{ route('admin.user.index') }}" class="btn btn-primary btn-3">
                                    <i class="ti ti-arrow-back-up"></i>
                                    Back

                                </a>
                            </div>
                        </div>

                        <form action="{{route('admin.user.update', $user->id)}}" method="POST" class="card" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label required">Name</label>
                                            <input type="text" class="form-control" name="name"
                                                placeholder="Full Name" value="{{ $user->name }}">
                                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label required">Role</label>
                                            <select id="role-select" class="form-select" name="role">
                                                <option value="">Select Role</option>
                                                <option @selected($user->role == 'user') value="user">User</option>
                                                <option @selected($user->role == 'employee') value="employee">Employee</option>
                                                <option @selected($user->role == 'moderator') value="moderator">Moderator</option>
                                            </select>
                                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label required">Email</label>
                                            <input type="email" class="form-control" name="email"
                                                placeholder="email" value="{{ $user->email }}">
                                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label required">Phone Number</label>
                                            <input type="tel" class="form-control" name="phone"
                                                placeholder="Phone" value="{{ $user->phone }}">
                                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                        </div>
                                        <div class="col-md-1 mt-2">
                                            <x-input-toggle-block class="col-md-12 mt-3" name="status" label="Status" :checked="$user->status"/>
                                        </div>
                                    </div>
                                </div>


                                <div id="employee-fields" class="row" style="{{ $user->role === 'employee' ? '' : 'display: none;' }}">
                                    

                                    <div class="col-md-12">
                                        <hr>
                                        <h4>Employee Details</h4>

                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <label class="form-label">Service</label>
                                                <select id="service" name="service[]" data-placeholder="Select Service" multiple data-multi-select>
                                                    @foreach ($services as $service)
                                                        <option value="{{ $service->id }}" {{ in_array($service->id, old('service', $selectedServices)) ? 'selected' : '' }}>
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
                                                        <option value="{{ $duration }}" {{ old('slot_duration', $employee?->slot_duration) == $duration ? 'selected' : '' }}>
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
                                                            <option value="{{ $break }}" {{ old('break_duration', $employee?->break_duration) == $break ? 'selected' : '' }}>
                                                                {{ $break }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>



                                            <div class="row">
                                                <div class="mb-3 mt-3">
                                                    <h3 class="mb-0">Set Availability - For Employee</h3>
                                                    <small class="text-muted">
                                                        Select days and timings, with the option to add multiple time slots in a
                                                        day, e.g., 9 AM–12 PM and 4 PM–8 PM.
                                                    </small>
                                                </div>

                                                <div class="col-md-12">
                                                    @foreach ($days as $day)
                                                        @php
                                                            $daySlots = old("days.$day", $employeeDays[$day] ?? []);
                                                            // Ensure at least one empty slot is shown
                                                            if (count($daySlots) < 2) {
                                                                $daySlots = array_pad($daySlots, 2, '');
                                                            }
                                                        @endphp

                                                        @for ($i = 0; $i < count($daySlots); $i += 2)
                                                            <div class="row mb-3 {{ $i >= 2 ? 'additional-' . $day : '' }}">
                                                                @if ($i === 0)
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <div class="custom-control custom-switch">
                                                                                <input type="checkbox"
                                                                                    class="custom-control-input"
                                                                                    id="{{ $day }}"
                                                                                    name="days_enabled[]"
                                                                                    value="{{ $day }}"
                                                                                    {{ !empty(array_filter($daySlots)) ? 'checked' : '' }}>
                                                                                <label class="custom-control-label" for="{{ $day }}">{{ ucfirst($day) }}</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div class="col-md-2"></div>
                                                                @endif

                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <strong>From:</strong>
                                                                        <input type="time"
                                                                            class="form-control from time-input-{{ $day }}"
                                                                            name="days[{{ $day }}][]"
                                                                            value="{{ $daySlots[$i] ?? '' }}">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <strong>To:</strong>
                                                                        <input type="time"
                                                                            class="form-control to time-input-{{ $day }}"
                                                                            name="days[{{ $day }}][]"
                                                                            value="{{ $daySlots[$i + 1] ?? '' }}">
                                                                    </div>

                                                                    @if ($i === 0)
                                                                        <div id="{{ $day }}AddMore" class="text-right mt-1 text-primary">Add More</div>
                                                                    @else
                                                                        <div class="text-right text-danger mt-1 remove-field">Remove</div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endfor
                                                    @endforeach
                                                </div>
                                            </div>



                                        </div>
                                    </div>
                                </div>


                                <div class="text-start">
                                    <button type="submit" class="btn btn-primary">Update</button>
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

    {{-- Availability Days Logic --}}
    <script>
        $(document).ready(function() {
            function toggleDayFields(dayId) {
                var isChecked = $('#' + dayId).prop('checked');
                $('.time-input-' + dayId).prop('disabled', !isChecked);

                // Show or hide the "Add More" button based on the checkbox state
                if (isChecked) {
                    $('#' + dayId + 'AddMore').removeClass('d-none');
                } else {
                    $('#' + dayId + 'AddMore').addClass('d-none');
                    // Remove all additional fields for the day if unchecked
                    $('.additional-' + dayId).remove();
                }
            }

            function addMoreFields(dayId) {
                // Clone the original row for the specific day
                var originalRow = $('#' + dayId + 'AddMore').closest('.row');
                var clonedRow = originalRow.clone();

                // Reset the values in the cloned row (but don't enable the fields yet)
                clonedRow.find('input').each(function() {
                    $(this).val(''); // Clear the value
                });

                // Replace the col-md-2 section with a blank div for the cloned row
                clonedRow.find('.col-md-2').replaceWith('<div class="col-md-2"></div>');

                // Update "Add More" to "Remove" for the cloned row
                clonedRow.find(`#${dayId}AddMore`).text('Remove').attr('id', '').addClass(
                    'remove-field text-danger');

                // Add a unique class to the cloned row for targeting specific day rows
                clonedRow.addClass('additional-' + dayId);

                // Append the cloned row after the original row or the last cloned row
                if (originalRow.closest('.row').siblings('.additional-' + dayId).length === 0) {
                    originalRow.after(clonedRow);
                } else {
                    originalRow.closest('.row').siblings('.additional-' + dayId).last().after(clonedRow);
                }
            }

            // Remove cloned rows
            $(document).on('click', '.remove-field', function() {
                $(this).closest('.row').remove();
            });

            // Bind change and add-more events to all days
            ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'].forEach(function(day) {
                $('#' + day).on('change', function() {
                    toggleDayFields(day);
                }).trigger('change');

                $('#' + day + 'AddMore').on('click', function() {
                    addMoreFields(day);
                });
            });
        });
    </script>

@endpush
