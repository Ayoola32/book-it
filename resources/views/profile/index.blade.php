@extends('layouts.master')
@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">Overview</div>
                    <h2 class="page-title">Profile</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile text-center">
                            <img class="profile-user-img img-fluid"
                                src="{{ Auth::user()->image ? asset(Auth::user()->image) : asset('uploads/images/avatar.png') }}"
                                alt="User profile picture">
                            <div class="mt-2">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#profileImageModal">Change image</a>
                            </div>
                            <h3 class="profile-username text-center">{{Auth::user()->name}}</h3>
                            <p class="text-muted text-center">{{Auth::user()->email}}</p>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Role Assigned: </b> <span class="">{{ ucfirst(Auth::user()->role) }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link {{ old('active_tab', 'settings') === 'settings' ? 'active' : '' }}" data-bs-toggle="tab" href="#settings" role="tab">Profile</a></li>
                                <li class="nav-item"><a class="nav-link {{ old('active_tab') === 'bio' ? 'active' : '' }}" data-bs-toggle="tab" href="#bio" role="tab">Bio</a></li>
                                @if (Auth::user()->role === 'employee')
                                    <li class="nav-item"><a class="nav-link {{ old('active_tab') === 'employee' ? 'active' : '' }}" data-bs-toggle="tab" href="#availability" role="tab">Availability</a></li>
                                    <li class="nav-item"><a class="nav-link {{ old('active_tab') === 'appointments' ? 'active' : '' }}" data-bs-toggle="tab" href="#appointments" role="tab">Appointments</a></li>
                                @endif
                                <li class="nav-item"><a class="nav-link {{ old('active_tab') === 'password' ? 'active' : '' }}" data-bs-toggle="tab" href="#password" role="tab">Change Password</a></li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <div class="tab-content">
                                <!-- Profile Tab -->
                                <div class="tab-pane fade {{ old('active_tab', 'settings') === 'settings' ? 'show active' : '' }}" id="settings" role="tabpanel">
                                    <form action="{{ route('profile.update') }}" method="post" class="form-horizontal">
                                        @csrf
                                        <input type="hidden" name="active_tab" id="active_tab" value="settings">
                                        <div class="mb-3 row">
                                            <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="name" class="form-control" id="inputName"
                                                    value="{{ $user->name }}">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" name="email" class="form-control"
                                                    style="background-color: rgb(221, 221, 221);" id="inputEmail"
                                                    value="{{ $user->email }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!-- Bio Tab -->
                                <div class="tab-pane fade {{ old('active_tab') === 'bio' ? 'show active' : '' }}" id="bio" role="tabpanel">
                                    <form action="{{ route('employee.bio.update', $user->employee->id ?? 0) }}" method="post" class="form-horizontal">
                                        @csrf
                                        @method('put')
                                        <input type="hidden" name="active_tab" id="active_tab" value="bio">
                                        <div class="mb-3 row">
                                            <label for="inputExperience" class="col-sm-2 col-form-label">Bio</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" id="inputExperience" rows="10" name="bio">{{ old('bio', $user->employee->bio ?? '') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="inputSkills" class="col-sm-2 col-form-label">Facebook</label>
                                            <div class="col-sm-10">
                                                <input type="url" class="form-control" name="social[facebook]"
                                                    value="{{ $user->employee->social['facebook'] ?? ''}}"
                                                    placeholder="www.facebook.com/your-profile">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="inputSkills" class="col-sm-2 col-form-label">Instagram</label>
                                            <div class="col-sm-10">
                                                <input type="url" class="form-control" name="social[instagram]"
                                                    value="{{ $user->employee->social['instagram'] ?? '' }}"
                                                    placeholder="www.instagram.com/your-profile">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="inputSkills" class="col-sm-2 col-form-label">Tiktok</label>
                                            <div class="col-sm-10">
                                                <input type="url" class="form-control" name="social[tiktok]"
                                                    value="{{ $user->employee->social['tiktok'] ?? '' }}"
                                                    placeholder="www.tiktok.com/your-profile">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>


                                @if (Auth::user()->role === 'employee')

                                    <!-- Availability Tab -->
                                    <div class="tab-pane fade {{ old('active_tab') === 'employee' ? 'show active' : '' }}" id="availability" role="tabpanel">
                                        <form action="{{ route('employee.availability.update', $user->employee->id ?? 0) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="row">
                                                <div class="col-md-6 mb-2">
                                                    <label class="form-label">Slot Duration (minutes)</label>
                                                    <select name="slot_duration" class="form-control">
                                                        <option value="">Select Duration</option>
                                                        @foreach (['10', '15', '20', '30', '45', '60'] as $duration)
                                                            <option value="{{ $duration }}"
                                                                {{ old('slot_duration', $employee?->slot_duration) == $duration ? 'selected' : '' }}>
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
                                                                <option value="{{ $break }}"
                                                                    {{ old('break_duration', $employee?->break_duration) == $break ? 'selected' : '' }}>
                                                                    {{ $break }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="mb-3 mt-3">
                                                        <h3 class="mb-0">Set Your Availability - As an Employee</h3>
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
                                                                                    <label class="custom-control-label"
                                                                                        for="{{ $day }}">{{ ucfirst($day) }}</label>
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
                                                                            <div id="{{ $day }}AddMore"
                                                                                class="text-right mt-1 text-primary">Add More</div>
                                                                        @else
                                                                            <div class="text-right text-danger mt-1 remove-field">
                                                                                Remove</div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endfor
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="offset-sm-2 col-sm-10">
                                                    <button type="submit" class="btn btn-primary">Update Availability</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Appointments Tab -->
                                    <div class="tab-pane fade {{ old('active_tab') === 'appointments' ? 'show active' : '' }}" id="appointments" role="tabpanel">
                                        <div class="table-responsive">
                                            <p>No appointments available.</p>
                                        </div>
                                    </div>
                                @endif


                                <!-- Password Tab -->
                                <div class="tab-pane fade {{ old('active_tab') === 'password' ? 'show active' : '' }}" id="password" role="tabpanel">
                                    <form action="{{ route('password.update') }}" method="post">
                                        @csrf
                                        @method('put')
                                        <input type="hidden" name="active_tab" id="active_tab" value="password">
                                        <div class="mb-3 row">
                                            <label class="col-sm-2 col-form-label">Old Password</label>
                                            <div class="col-sm-10">
                                                <input type="password" name="current_password" class="form-control">
                                                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-sm-2 col-form-label">New Password</label>
                                            <div class="col-sm-10">
                                                <input type="password" name="password" class="form-control">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-sm-2 col-form-label">Confirm Password</label>
                                            <div class="col-sm-10">
                                                <input type="password" name="password_confirmation" class="form-control">
                                                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-danger">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div> <!-- .tab-content -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="profileImageModal" tabindex="-1" aria-labelledby="profileImageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('profile.image.update', Auth::user()->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Profile Pic</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <input type="file" name="image" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Handle tab persistence
            document.querySelectorAll('[data-bs-toggle="tab"]').forEach(function (tab) {
                tab.addEventListener('shown.bs.tab', function (e) {
                    const activeTab = e.target.getAttribute('href').substring(1); // strip #
                    document.querySelectorAll('form').forEach(form => {
                        const input = form.querySelector('input[name="active_tab"]');
                        if (input) input.value = activeTab;
                    });
                });
            });

            // Show modal if there is an image error
            @if ($errors->has('image'))
                const profileModal = new bootstrap.Modal(document.getElementById('profileImageModal'));
                profileModal.show();
            @endif
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
