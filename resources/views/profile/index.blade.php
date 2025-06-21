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
                                src="{{ Auth::user()->image ? asset(Auth::user()->image) : asset('admin/assets/static/avatars/000m.jpg') }}"
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
                                <li class="nav-item"><a class="nav-link {{ old('active_tab') === 'appointments' ? 'active' : '' }}" data-bs-toggle="tab" href="#appointments" role="tab">Appointments</a></li>
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
                                                <input type="text" name="name" class="form-control" id="inputName" value="{{ $user->name }}">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" name="email" class="form-control" style="background-color: rgb(221, 221, 221);" id="inputEmail" value="{{ $user->email }}">
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
                                    <form action="" method="post" class="form-horizontal">
                                        @csrf
                                        <input type="hidden" name="active_tab" id="active_tab" value="bio">
                                        <div class="mb-3 row">
                                            <label for="inputExperience" class="col-sm-2 col-form-label">Bio</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" id="inputExperience" rows="10" name="bio"></textarea>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="inputSkills" class="col-sm-2 col-form-label">Facebook</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="social[facebook]" placeholder="www.facebook.com/your-profile">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-primary">Submit</button>
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
            <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Profile Pic</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
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
@endpush
