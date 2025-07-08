@php
    $employee = auth()->user()->employee;
@endphp

@extends('layouts.master')
@section('content')

    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">My Holiday: {{ $employee->used_holiday_days }} / {{ $employee->total_holiday_days }} used,  ({{ $employee->remaining_holiday_days }} left)</h3>

                            <div class="card-actions">
                                <a href="{{ route('employee.holiday.create')}}" class="btn btn-primary btn-3">
                                    <i class="ti ti-plus"></i> 
                                    Book New
                                </a>
                            </div>
                        </div>


                        <div class="card-body border-bottom py-3">
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush
