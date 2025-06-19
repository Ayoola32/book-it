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
                                        <div class="col-md-12 mb-2">
                                            <label class="form-label required">Name</label>
                                            <input type="text" class="form-control" name="name"
                                                placeholder="Full Name" value="{{ $user->name }}">
                                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
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
