@extends('admin.layouts.master')
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Update Service Category</h3>

                            <!-- Page title actions -->
                            <div class="card-actions">
                                <a href="{{ route('admin.service_category.index') }}" class="btn btn-primary btn-3">
                                    <i class="ti ti-arrow-back-up"></i>
                                    Back

                                </a>
                            </div>
                        </div>





                        <form action="{{ route('admin.service_category.update', $category->id) }}" method="POST" class="card"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-12 mb-5">
                                            <label class="form-label required">Display Image</label>
                                            <div class="mb-3">
                                                <img src="{{ asset($category->image) }}" alt=""
                                                    class="img-fluid" style="max-width: 200px;">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label required">Name</label>
                                            <input type="text" class="form-control" name="name"
                                                placeholder="Enter a new category"
                                                value="{{ old('name', $category->name) }}">
                                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label required">Image</label>
                                            <input type="file" class="form-control" name="image">
                                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                                        </div>
                                        
                                        <div class="col-md-12 mt-2">
                                            <label class="form-label required">Description</label>
                                            <textarea class="form-control" name="description" rows="3"
                                                placeholder="Enter a new category description">{{ old('description', $category->description) }}</textarea>
                                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <x-input-toggle-block class="col-md-12 mt-3" name="status" label="Status"
                                                :checked="$category->status" />
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <x-input-toggle-block class="col-md-12 mt-3" name="show_at_trending"
                                                label="Show at trending" :checked="$category->show_at_trending" />
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
