@extends('layouts.app')
@section('title', 'Home')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="text-center">
                        <img src="{{ $employee->profile_img_path() }}" alt="" class="profile-img">
                        <div class="py-3 px-3">
                            <h3>{{ $employee->name }}</h3>
                            <p class="text-muted mb-2"><span class="text-muted">{{ $employee->employee_id }}</span> | <span class="text-theme">{{$employee->phone}}</span></p>
                            <p class="text-muted mb-2 badge badge-pill badge-light border">{{ $employee->department ? $employee->department->title : '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
