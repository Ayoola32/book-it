@extends('admin.layouts.master')
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Create Service for <span class="text-blue">{{ $category->name}}</span> Category</h3>

                            <!-- Page title actions -->
                            <div class="card-actions">
                                <a href="{{ route('admin.service.index', $category->slug)}}" class="btn btn-primary btn-3">
                                    <i class="ti ti-arrow-back-up"></i>
                                    Back

                                </a>
                            </div>
                        </div>


                        <form action="{{ route('admin.service.store', $category->slug)}}" method="POST" class="card" enctype="multipart/form-data">
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
                                        <div class="col-md-12 mt-2 mb-2">
                                            <label class="form-label required">Description</label>
                                            <textarea class="form-control" name="description" rows="3"
                                                placeholder="Enter a description">{{ old('description') }}</textarea>
                                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                        </div>
                                        <div class="col-md-2 mt-2">
                                            <x-input-toggle-block class="col-md-12 mt-3" name="status" label="Status" />
                                        </div>
                                        <div class="col-md-5 mt-2">
                                            <label class="form-label required">Price</label>
                                            <input type="number" class="form-control" name="price"
                                                placeholder="Enter a price" value="{{ old('price') }}">
                                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                        </div>
                                        <div class="col-md-5 mt-2">
                                            <label class="form-label required">Sale Price</label>
                                            <input type="number" class="form-control" name="sale_price"
                                                placeholder="Sale Price" value="{{ old('sale_price') }}">
                                            <x-input-error :messages="$errors->get('sale_price')" class="mt-2" />
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
