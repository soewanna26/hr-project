@extends('layouts.app_plain')
@section('title', 'Check In - Check Out')
@section('content')
    <div class="card">
        <div class="card-body">
            <input type="text" name="mycode" id="pincode-input1">
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#pincode-input1').pincodeInput({
                inputs: 4
            });
        })
    </script>
