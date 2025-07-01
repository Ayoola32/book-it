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
                                <div class="tab-pane fade {{ old('active_tab', 'settings') === 'settings' ? 'show active' : '' }}" id="settings" role="tabpanel">
                                    <form action="" method="post" class="form-horizontal">
                                        @csrf
                                        <input type="hidden" name="active_tab" id="active_tab" value="settings">
                                        <div class="mb-3 row">
                                            <label for="inputName" class="col-sm-2 col-form-label">Business Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="bname" class="form-control" id="inputName" value="" placeholder="Business Name">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="inputCurrency" class="col-sm-2 col-form-label">Currency</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="currency" class="form-control" id="inputCurrency" value="" placeholder="GBP">
                                                <small class="text-muted">Example: USD, GBP, EUR (use only abbreviation) </small>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="inputLogo" class="col-sm-2 col-form-label">Logo</label>
                                            <div class="col-sm-10">
                                                <input type="file" name="logo" class="form-control" id="inputLogo" value="">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="inputFavicon" class="col-sm-2 col-form-label">Favicon</label>
                                            <div class="col-sm-10">
                                                <input type="file" name="favicon" class="form-control" id="inputFavicon" value="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-danger">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!-- Contact Tab -->
                                <div class="tab-pane fade {{ old('active_tab') === 'contact' ? 'show active' : '' }}"
                                    id="contact" role="tabpanel">
                                    <form action="" method="post" class="form-horizontal">
                                        @csrf
                                        <input type="hidden" name="active_tab" id="active_tab" value="contact">
                                        <div class="mb-3 row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" name="email" class="form-control" id="inputEmail" value="" placeholder="Email Address">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="inputPhone" class="col-sm-2 col-form-label">Phone</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="phone" class="form-control" id="inputPhone" value="" placeholder="Contact Number">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="inputAddress" class="col-sm-2 col-form-label">Address</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="address" class="form-control" id="inputAddress" value="" placeholder="Address">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="inputMap" class="col-sm-2 col-form-label">Google Map</label>
                                            <div class="col-sm-10">
                                                <textarea name="map" class="form-control" id="inputMap" cols="30" rows="8" placeholder="Put google map iframe code, keep in mind website contact page map section height and width;"></textarea>
                                                <small>Put google map iframe code, keep in mind website contact page map section height and width;</small>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-danger">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!-- Social Tab -->
                                <div class="tab-pane fade {{ old('active_tab') === 'social' ? 'show active' : '' }}"
                                    id="social" role="tabpanel">
                                    <form action="" method="post" class="form-horizontal">
                                        @csrf
                                        <input type="hidden" name="active_tab" id="active_tab" value="social">
                                        <div class="mb-3 row">
                                            <label for="inputFacebook" class="col-sm-2 col-form-label">Facebook</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="social[facebook]" class="form-control" id="inputFacebook" value="" placeholder="Facebook URL">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="inputInstagram" class="col-sm-2 col-form-label">Instagram</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="social[instagram]" class="form-control" id="inputInstagram" value="" placeholder="Instagram URL">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="inputTiktok" class="col-sm-2 col-form-label">TikTok</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="social[tiktok]" class="form-control" id="inputTiktok" value="" placeholder="TikTok URL">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="inputtwitter" class="col-sm-2 col-form-label">Twitter (X)</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="social[twitter]" class="form-control" id="inputtwitter" value="" placeholder="TikTok URL">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-danger">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>


                                <!-- Footer Tab -->
                                <div class="tab-pane fade {{ old('active_tab') === 'footer' ? 'show active' : '' }}"
                                    id="footer" role="tabpanel">
                                    <form action="" method="post" class="form-horizontal">
                                        @csrf
                                        <input type="hidden" name="active_tab" id="active_tab" value="footer">
                                        <div class="mb-3 row">
                                            <label for="inputInfo" class="col-sm-2 col-form-label">Footer Info</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="footer_info" id="" cols="30" rows="5" id="inputInfo"></textarea>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="inputCopyright" class="col-sm-2 col-form-label">Copyright</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="copyright" class="form-control" id="inputCopyright" value="" placeholder="Copyright Text">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="inputPoweredBy" class="col-sm-2 col-form-label">Powered By</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="powered_by" class="form-control" id="inputPoweredBy" value="" placeholder="Powered By">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-danger">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!-- SEO Tab -->
                                <div class="tab-pane fade {{ old('active_tab') === 'seo' ? 'show active' : '' }}"
                                    id="seo" role="tabpanel">
                                    <form action="" method="post" class="form-horizontal">
                                        @csrf
                                        <input type="hidden" name="active_tab" id="active_tab" value="seo">
                                        <div class="mb-3 row">
                                            <label for="inputSeoTitle" class="col-sm-2 col-form-label">SEO Title</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="seo_title" class="form-control" id="inputSeoTitle" value="" placeholder="SEO Title">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="inputSeoDescription" class="col-sm-2 col-form-label">SEO Description</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="seo_description" id="" cols="30" rows="5" id="inputSeoDescription"></textarea>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="inputSeoKeywords" class="col-sm-2 col-form-label">SEO Keywords</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="seo_keywords" id="" cols="30" rows="5" id="inputSeoKeywords"></textarea>
                                                <small>Keywords are comma seperated.</small>

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
        });
    </script>
@endpush
