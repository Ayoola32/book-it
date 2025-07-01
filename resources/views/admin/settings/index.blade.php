@extends('admin.layouts.master')
@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">Overview</div>
                    <h2 class="page-title">Settings</h2>
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
                            <h3>
                                <span class="text-muted text-center text-dark">Abusidiq Digitals</span> <br>
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a
                                        class="nav-link {{ old('active_tab', 'settings') === 'settings' ? 'active' : '' }}"
                                        data-bs-toggle="tab" href="#settings" role="tab">Website Settings</a></li>
                                <li class="nav-item"><a
                                        class="nav-link {{ old('active_tab') === 'contact' ? 'active' : '' }}"
                                        data-bs-toggle="tab" href="#contact" role="tab">Contact Info</a></li>
                                <li class="nav-item"><a
                                        class="nav-link {{ old('active_tab') === 'social' ? 'active' : '' }}"
                                        data-bs-toggle="tab" href="#social" role="tab">Social Links</a></li>
                                <li class="nav-item"><a
                                        class="nav-link {{ old('active_tab') === 'footer' ? 'active' : '' }}"
                                        data-bs-toggle="tab" href="#footer" role="tab">Footer</a></li>
                                <li class="nav-item"><a class="nav-link {{ old('active_tab') === 'seo' ? 'active' : '' }}"
                                        data-bs-toggle="tab" href="#seo" role="tab">SEO</a></li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <div class="tab-content">
                                <!-- Settings Tab -->
                                <div class="tab-pane fade {{ old('active_tab', 'settings') === 'settings' ? 'show active' : '' }}"
                                    id="settings" role="tabpanel">
                                    <h4>Website Settings</h4>
                                </div>

                                <!-- Contact Tab -->
                                <div class="tab-pane fade {{ old('active_tab') === 'contact' ? 'show active' : '' }}"
                                    id="contact" role="tabpanel">
                                    <div class="table-responsive">
                                        <p>No contact available.</p>
                                    </div>
                                </div>

                                <!-- Social Tab -->
                                <div class="tab-pane fade {{ old('active_tab') === 'social' ? 'show active' : '' }}"
                                    id="social" role="tabpanel">

                                </div>


                                <!-- Footer Tab -->
                                <div class="tab-pane fade {{ old('active_tab') === 'footer' ? 'show active' : '' }}"
                                    id="footer" role="tabpanel">

                                </div>

                                <!-- SEO Tab -->
                                <div class="tab-pane fade {{ old('active_tab') === 'seo' ? 'show active' : '' }}"
                                    id="seo" role="tabpanel">

                                </div>
                            </div> <!-- .tab-content -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
