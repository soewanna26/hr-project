@extends('layouts.app_plain')
@section('title', 'Check In - Check Out')
@section('content')

    <div class="d-flex justify-content-center align-items-center" style="height:100vh">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="my-5 text-center">
                        <h5>QR COde</h5>
                        <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate('Make me into an QrCode!')) !!} ">
                        <p class="text-muted">Please scan QR to Check In Or Checkout</p>
                    </div>
                    <hr>

                    <div class="my-5 text-center">
                        <h5>Pin Code</h5>
                        <div class="mb-3">
                            <input type="text" name="mycode" id="pincode-input1">
                        </div>
                        <p class="text-muted">Please enter your pin code to check in or checkout</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#pincode-input1').pincodeInput({
                inputs: 6,
                complete: function(value, e, errorElement) {
                    console.log("code entered: " + value);

                    $.ajax({
                        url: "/checkin-checkout/store",
                        type: "POST",
                        data: {
                            "pin_code": value
                        },
                        success: function(res) {
                            if (res.status == 'success') {
                                Toast.fire({
                                    icon: "success",
                                    title: res.message,
                                });
                            } else {
                                Toast.fire({
                                    icon: "error",
                                    title: res.message,
                                });
                            }
                            $('.pincode-input-container .pincode-input-text').val("");
                            $('.pincode-input-text').first().select().focus();

                        }

                    })

                }
            });
            $('.pincode-input-text').first().select().focus();
        });
    </script>
