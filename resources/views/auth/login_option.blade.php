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
                        <ul class="nav nav-pills nav-justified mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-password-tab" data-toggle="pill" href="#pills-password"
                                    role="tab" aria-controls="pills-password" aria-selected="true">Password</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-biometric-tab" data-toggle="pill" href="#pills-biometric"
                                    role="tab" aria-controls="pills-biometric" aria-selected="false">Biometric</a>
                            </li>
                        </ul>
                        <div class="tab-content pt-2 pl-1" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-password" role="tabpanel"
                                aria-labelledby="pills-password-tab">

                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                                        {{ $error }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endforeach

                                <form action="{{ route('login') }}" method="POST" autocomplete="off">
                                    @csrf
                                    <input type="hidden" name="phone" value="{{ request()->phone }}">
                                    <div class="md-form">
                                        <input type="password" name="password" class="form-control text-center" autofocus
                                            placeholder="Password">
                                    </div>
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <button type="submit" class="btn btn-theme btn-block">Confirm</button>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="pills-biometric" role="tabpanel"
                                aria-labelledby="pills-biometric-tab">
                                <input type="hidden" id="phone" value="{{ request()->phone }}">
                                <div class="text-center">
                                    <a href="#" class="btn biometric-login-btn">
                                        <i class="fas fa-fingerprint"></i>
                                    </a>
                                </div>
                                <p class="text-center text-muted mb-0">Device Authenticator</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        const login = event => {
            event.preventDefault();
            console.log("Login function triggered"); // Check if this message appears in the console
            new WebAuthn().login({
                phone: document.getElementById('phone').value,
            }).then(function(response) {
                window.location.replace('/');
            }).catch(function(error) {
                console.log(error);
            });
        };

        $(document).ready(function() {
            $('.biometric-login-btn').on('click', function(event) {
                login(event);
            });
        });
    </script>
@endsection
