@extends('layouts.app_plain')
@section('title', 'Login Option')
@section('content')
    <div class="container">
        <div class="row justify-content-center align-content-center" style="height: 100vh">
            <div class="col-md-6">
                <div class="text-center mb-3">
                    <img src="{{ asset('image/logo.jpg') }}" alt="Hr Photo" style="width: 80px; border-radius: 50%">
                </div>
                <div class="card" style="height: 40vh">
                    <div class="card-body">
                        <h5 class="text-center">Login Option</h5>
                        <p class="text-muted text-center">Please Choose the login option</p>
                        <form method="GET" action="{{route('login-option')}}" autocomplete="off">
                            <div class="md-form mb-5">
                                <input type="number" class="form-control text-center @error('phone') is-invalid @enderror"
                                    name="phone" value="{{ old('phone') }}" autofocus placeholder="Enter Phone">
                                @error('phone')
                                    <p class="text-danger text-center">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-theme mt-4 btn-block">
                                Continue
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
