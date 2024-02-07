@extends('layouts.app')
@section('title', 'Attendance Scan')
@section('content')
    <div class="card">
        <div class="card-body text-center">
            <img src="{{asset('image/scan.png')}}" alt="" style="width:220px">
            <p class="text-muted mb-1">Please Scan Attendance QR</p>

            <a href="" class="btn btn-theme btn-sm">Scan</a>
        </div>
    </div>
@endsection
