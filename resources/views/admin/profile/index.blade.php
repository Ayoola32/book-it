@extends('admin.layouts.master')
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
                        Profile
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Page body -->
    <div class="page-body">
        <div class="container-l">
            <div class="row row-deck row-cards">
                <div class="content">
                    <div class="container-fluid">

                        <div class="modal fade" id="profileImageModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form action="http://appointment-booking-system-master.test/user/profile-pic/1"
                                    method="post" enctype="multipart/form-data">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Update Profile Pic</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            <input type="hidden" name="_token"
                                                value="id08MSUUMIb1dlZwzbi2z10bDPgg0JIjYmVT6UGY" autocomplete="off"> <input
                                                type="hidden" name="_method" value="PUT"> <input type="file"
                                                name="image" class="form-control" id="">

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <section class="content">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-3">

                                        <div class="card card-primary card-outline">
                                            <div class="card-body box-profile">
                                                <div class="text-center">
                                                    <img class="profile-user-img img-fluid img-circle"
                                                        src="http://appointment-booking-system-master.test/vendor/adminlte/dist/img/gravtar.jpg"
                                                        alt="User profile picture">
                                                </div>
                                                <div class="text-center">
                                                    <a data-toggle="modal" data-target="#profileImageModal"
                                                        href="">Change image</a>
                                                </div>
                                                <h3 class="profile-username text-center">Admin</h3>
                                                <p class="text-muted text-center">admin@example.com</p>
                                                <ul class="list-group list-group-unbordered mb-3">

                                                    <li class="list-group-item">
                                                        <b>Last Logged In</b> <a class="float-right">5 seconds ago</a>
                                                    </li>

                                                    <li class="list-group-item">
                                                        <b>Account Created</b> <a class="float-right">1 day ago</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Role: </b> <a class="float-right">Admin
                                                        </a>
                                                    </li>

                                                </ul>


                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-9">
                                        <div class="card">
                                            <div class="card-header p-2">
                                                <ul class="nav nav-pills">

                                                    <li class="nav-item "><a class="nav-link" href="#settings"
                                                            data-toggle="tab">Profile</a>
                                                    </li>

                                                    <li class="nav-item "><a class="nav-link" href="#logs"
                                                            data-toggle="tab">Logs</a>
                                                    </li>

                                                    <li class="nav-item"><a class="nav-link" href="#bio"
                                                            data-toggle="tab">Bio</a>
                                                    </li>

                                                    <li class="nav-item"><a class="nav-link" href="#appointments"
                                                            data-toggle="tab">Appointments</a>
                                                    </li>

                                                    <li class="nav-item"><a class="nav-link active" href="#password"
                                                            data-toggle="tab">Change
                                                            Password</a>
                                                    </li>

                                                </ul>
                                            </div>
                                            <div class="card-body">
                                                <div class="tab-content">

                                                    <div class="tab-pane show" id="settings">

                                                        <form action="" method="post" class="form-horizontal">
                                                            <div class="form-group row mb-2">
                                                                <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" name="name" class="form-control" id="inputName" placeholder="Name" value="">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row mb-2">
                                                                <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                                                <div class="col-sm-10">
                                                                    <input
                                                                    type="email" name="email" class="form-control " id="inputEmail" placeholder="Email" value="">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <div class="offset-sm-2 col-sm-10">
                                                                    <button
                                                                        onclick="return confirm('Are you sure you want ')"
                                                                        type="submit"
                                                                        class="btn btn-primary">Submit</button>
                                                                </div>
                                                            </div>
                                                        </form>

                                                    </div>

                                                    <div class="tab-pane" id="logs">

                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="card">


                                                                    <div class="card-body table-responsive">
                                                                        <table class="table table-hover text-nowrap">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Login</th>
                                                                                    <th>Logout</th>

                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>

                                                                                    <td>00:29 | 13 Jun 2025
                                                                                    </td>

                                                                                    <td>NA
                                                                                    </td>


                                                                                </tr>
                                                                                <tr>

                                                                                    <td>16:57 | 12 Jun 2025
                                                                                    </td>

                                                                                    <td>NA
                                                                                    </td>


                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="tab-pane" id="bio">

                                                        <form action=""  method="post" class="form-horizontal">
                                                            <div class="form-group row mb-2">
                                                                <label for="inputExperience" class="col-sm-2 col-form-label">Bio</label>
                                                                <div class="col-sm-10">
                                                                    <textarea class="form-control" id="inputExperience" placeholder="Your profile details...." rows="10"
                                                                        name="bio" value=""></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row mb-2">
                                                                <label for="inputSkills" class="col-sm-2 col-form-label">Facebook</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control" id="inputSkills" name="social[facebook]" placeholder="www.facebook.com/your-profile" value="">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="offset-sm-2 col-sm-10">
                                                                    <button
                                                                        onclick="return confirm('Are you sure you want ')"
                                                                        type="submit"
                                                                        class="btn btn-primary">Submit</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>

                                                    <div class="tab-pane" id="appointments">

                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="card">


                                                                    <div class="card-body table-responsive ">
                                                                        <div id="DataTables_Table_0_wrapper"
                                                                            class="dataTables_wrapper dt-bootstrap4 no-footer">
                                                                            {{-- Appointment table --}}
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="tab-pane active" id="password">

                                                        <form action="" method="post">
                                                            <div class="card-body">
                                                                <div class="tab-content">
                                                                    <div class="active tab-pane" id="#password">
                                                                        <!-- Password -->
                                                                        <div class="tab-pane" id="password">
                                                                            <div class="form-group row mb-2">
                                                                                <label for="inputName" class="col-sm-2 col-form-label">Old Password</label>
                                                                                <div class="col-sm-10">
                                                                                    <input type="password" class="form-control" id="inputName"
                                                                                     placeholder="Old Password" name="current_password"  autocomplete="current_password">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row mb-2">
                                                                                <label for="inputEmail" class="col-sm-2 col-form-label">New Password</label>
                                                                                <div class="col-sm-10">
                                                                                    <input type="password" class="form-control" id="inputEmail"
                                                                                        placeholder="New Password" name="password" autocomplete="password_confirmation">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row mb-2">
                                                                                <label for="inputName2" class="col-sm-2 col-form-label">Confirm Password</label>
                                                                                <div class="col-sm-10">
                                                                                    <input type="password" class="form-control"id="inputName2" placeholder="Confirm Password" 
                                                                                        name="password_confirmation"  autocomplete="password_confirmation">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- /.tab-pane -->
                                                                    </div>
                                                                    <!-- /.tab-content -->
                                                                    <div class="form-group row">
                                                                        <div class="offset-sm-2 col-sm-10">
                                                                            <button
                                                                                onclick="return confirm('Are you sure you want to update profile?');"
                                                                                type="submit"
                                                                                class="btn btn-danger">Update</button>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </form>

                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{--  --}}
    <script>
        $(document).ready(function() {
            @if (!$errors->has('image'))
                $('#profileImageModal').modal('show');
            @endif
        });
    </script>
@endpush
