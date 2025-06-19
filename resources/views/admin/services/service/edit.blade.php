@extends('admin.layouts.master')
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Edit Service for {{ $category->name }} Category</h3>
                            <div class="card-actions">
                                <a href="{{ route('admin.service.index', $category->slug) }}" class="btn btn-primary btn-3">
                                    <i class="ti ti-arrow-back-up"></i> Back
                                </a>
                            </div>
                        </div>
                        <form action="{{ route('admin.service.update', [$category->slug, $service->id]) }}" method="POST" class="card" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label required">Name</label>
                                            <input type="text" class="form-control" name="name" value="{{ old('name', $service->name) }}">
                                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label required">Image</label>
                                            <input type="file" class="form-control" name="image">
                                            @if($service->image)
                                                <img src="{{ asset($service->image) }}" alt="" class="img-fluid" style="max-width: 200px;">
                                            @endif
                                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                                        </div>
                                        <div class="col-md-2 mt-2">
                                            <x-input-toggle-block class="col-md-12 mt-3" name="status" label="Status" />
                                        </div>
                                        <div class="col-md-5 mt-2">
                                            <label class="form-label required">Price</label>
                                            <input type="number" class="form-control" name="price" value="{{ old('price', $service->price) }}" step="0.01">
                                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                        </div>
                                        <div class="col-md-5 mt-2">
                                            <label class="form-label">Sale Price</label>
                                            <input type="number" class="form-control" name="sale_price" value="{{ old('sale_price', $service->sale_price) }}" step="0.01">
                                            <x-input-error :messages="$errors->get('sale_price')" class="mt-2" />
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