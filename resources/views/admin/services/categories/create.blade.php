@extends('admin.layouts.master')
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Create Service Category</h3>

                            <!-- Page title actions -->
                            <div class="card-actions">
                                <a href="" class="btn btn-primary btn-3">
                                    <i class="ti ti-arrow-back-up"></i>
                                    Back

                                </a>
                            </div>
                        </div>

                        <form action="{{route('admin.service_category.store')}}" method="POST" class="card" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label required">Name</label>
                                            <input type="text" class="form-control" name="name"
                                                placeholder="Enter a new category" value="{{ old('name') }}">
                                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label required">Image</label>
                                            <input type="file" class="form-control" name="image">
                                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <x-input-toggle-block class="col-md-12 mt-3" name="status" label="Status" />
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <x-input-toggle-block class="col-md-12 mt-3" name="show_at_trending"
                                                label="Show at trending" />
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
