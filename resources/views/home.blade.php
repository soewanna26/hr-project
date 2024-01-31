@extends('layouts.app')
@section('title', 'Profile')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-start">
                        <img src="{{ $employee->profile_img_path() }}" alt="" class="profile-img">
                        <div class="py-3 px-2">
                            <h3>{{ $employee->name }}</h3>
                            <p class="text-muted mb-1">{{ $employee->employee_id }}</p>
                            <p class="text-muted mb-1 badge badge-pill badge-dark">{{ $employee->department ? $employee->department->title : '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
