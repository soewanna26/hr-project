@extends('layouts.app')
@section('title', 'Attendance Scan')
@section('content')
    <div class="card mb-3">
        <div class="card-body text-center">
            <img src="{{ asset('image/scan.png') }}" alt="" style="width:220px">
            <p class="text-muted mb-1">Please Scan Attendance QR</p>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-theme btn-sm" data-toggle="modal" data-target="#scanModel">
                Scan
            </button>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="form-group">
                        <select name="" class="form-control select-month">
                            <option value="">-- Please Choose --</option>
                            <option value="01"@if (now()->format('m') == '01') selected @endif>Jan</option>
                            <option value="02"@if (now()->format('m') == '02') selected @endif>Feb</option>
                            <option value="03"@if (now()->format('m') == '03') selected @endif>Mar</option>
                            <option value="04"@if (now()->format('m') == '04') selected @endif>Apr</option>
                            <option value="05"@if (now()->format('m') == '05') selected @endif>May</option>
                            <option value="06"@if (now()->format('m') == '06') selected @endif>Jun</option>
                            <option value="07"@if (now()->format('m') == '07') selected @endif>July</option>
                            <option value="08"@if (now()->format('m') == '08') selected @endif>Aug</option>
                            <option value="09"@if (now()->format('m') == '09') selected @endif>Sep</option>
                            <option value="10"@if (now()->format('m') == '10') selected @endif>Oct</option>
                            <option value="11"@if (now()->format('m') == '11') selected @endif>Nov</option>
                            <option value="12"@if (now()->format('m') == '12') selected @endif>Dec</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <select name="" class="form-control select-year">
                            <option value="">-- Please Choose --</option>
                            @for ($i = 0; $i < 5; $i++)
                                <option
                                    value="{{ now()->subYears($i)->format('Y') }}"@if (now()->format('Y') == now()->subYears($i)->format('Y')) selected @endif>
                                    {{ now()->subYears($i)->format('Y') }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <button class="btn btn-theme btn-sm btn-block search-btn"><i
                                class="fas fa-search"></i>Search</button>
                    </div>
                </div>
            </div>
            <h5 class="mt-3">Payroll</h5>
            <div class="payroll_table"></div>

            <h5 class="mt-3">Attendance Overview</h5>
            <div class="attendance_overview_table mb-3"></div>
            <h5 class="mt-3">Attendance Record</h5>
            <table class="table table-bordered Datatable" style="width: 100%">
                <thead>
                    <th class="text-center no-sort no-search"></th>
                    <th class="text-center no-sort">Employee</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Checkin Time</th>
                    <th class="text-center">Checkout Time</th>
                </thead>
            </table>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="scanModel" tabindex="-1" role="dialog" aria-labelledby="scanModelLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scanModelLabel">Scan Attendance QR</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <video id="video" width = "100%" height="300px"></video>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark brn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/qr-scanner.umd.min.js') }}"></script>
    <script>
        var table;
        $(document).ready(function() {
            var videoElem = document.getElementById('video');
            const qrScanner = new QrScanner(
                videoElem,
                function(result) {
                    if (result) {
                        console.log('QR code scanned successfully:', result);
                        hideModal(); // Call function to hide modal
                        qrScanner.stop();

                        $.ajax({
                            url: "/attendance-scan/store",
                            type: "POST",
                            data: {
                                "hash_value": result
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
                            }

                        })
                    }
                });

            $('#scanModel').on('shown.bs.modal', function(e) {
                console.log('Modal shown');
                qrScanner.start(); // Attempt to start scanner
            });

            $('#scanModel').on('hidden.bs.modal', function(e) {
                console.log('Modal hidden');
                qrScanner.stop(); // Attempt to stop scanner
            });

            // Function to manually hide the modal
            function hideModal() {
                $('#scanModel').removeClass('show');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            }
            table = $('.Datatable').DataTable({
                ajax: '/my-attendance/datatable/ssd',
                columns: [{
                        data: 'plus_icon',
                        title: 'plus_icon',
                        class: 'text-center',
                    },
                    {
                        data: 'employee_name',
                        name: 'employee_name',
                        class: 'text-center',
                    },
                    {
                        data: 'date',
                        name: 'date',
                        class: 'text-center',
                    },
                    {
                        data: 'checkin_time',
                        name: 'checkin_time',
                        class: 'text-center',
                    },
                    {
                        data: 'checkout_time',
                        name: 'checkout_time',
                        class: 'text-center',
                    },
                ],
                order: [
                    [3, 'desc']
                ],
            });

            $('.select-month').select2({
                placeholder: '--Please Choose(Month)--',
                allowClear: true,
                theme: 'bootstrap4',
            });
            $('.select-year').select2({
                placeholder: '--Please Choose(Year)--',
                allowClear: true,
                theme: 'bootstrap4',
            });
            attendanceOverviewTable()

            function attendanceOverviewTable(month, year) {
                var month = $('.select-month').val();
                var year = $('.select-year').val();
                $.ajax({
                    url: `/my-attendance-overview-table?&month=${month}&year=${year}`,
                    type: "GET",
                    success: function(res) {
                        // console.log(res);
                        $('.attendance_overview_table').html(res);
                    }
                });
                table.ajax.url(`/my-attendance/datatable/ssd?month=${month}&year=${year}`).load();
            }

            payrollTable()

            function payrollTable(month, year) {
                var month = $('.select-month').val();
                var year = $('.select-year').val();
                $.ajax({
                    url: `/mypayroll-table?month=${month}&year=${year}`,
                    type: "GET",
                    success: function(res) {
                        $('.payroll_table').html(res);
                    }
                });
            }
            $('.search-btn').on('click', function(event) {
                event.preventDefault();
                attendanceOverviewTable();
                payrollTable();
            })
        });
    </script>
@endsection
