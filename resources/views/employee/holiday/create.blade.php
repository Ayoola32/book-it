@extends('layouts.master')
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Book Holiday</h3>

                            <!-- Page title actions -->
                            <div class="card-actions">
                                <a href="{{ route('employee.holiday.index')}}" class="btn btn-primary btn-3">
                                    <i class="ti ti-arrow-back-up"></i>
                                    Back

                                </a>
                            </div>
                        </div>


                        <form action="" method="POST" class="card" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label required">Start Date</label>
                                            <input type="date" name="start_date" class="form-control" required>
                                            <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label required">End Date</label>
                                            <input type="date" name="end_date" class="form-control" required>
                                            <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                                        </div>

                                        <div class="col-md-12 mt-3">
                                            <label class="form-label required">State Reason</label>
                                            <textarea name="reason" class="form-control" placeholder="Optional reason"></textarea>
                                            <x-input-error :messages="$errors->get('reason')" class="mt-2" />
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
