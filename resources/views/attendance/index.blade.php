@extends('layouts.app')
@section('title', 'Attendance')
@section('content')
    <div>
        @can('create_attendance')
        @endcan
        <a href="{{ route('attendance.create') }}" class="btn btn-theme btn-sm"><i class="fas fa-plus-circle"></i> Create
            Attendance</a>
        <a href="{{url('/attendance-downloadpdf')}}" target="_blank" class="btn btn-dark bg-dark text-white btn-sm"><i class="fas fa-file-pdf"></i> PDF Download</a>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered Datatable" style="width: 100%">
                <thead>
                    <th class="text-center no-sort no-search"></th>
                    <th class="text-center">Employee</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Checkin Time</th>
                    <th class="text-center">Checkout Time</th>
                    <th class="text-center no-sort">Action</th>
                    <th class="text-center hidden no-search">Updated At</th>
                </thead>
            </table>
        </div>
    </div>
@endsection
@section('script')
    <script>
        var table;
        $(document).ready(function() {
            table = $('.Datatable').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'pdfHtml5',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        title: "Attendance",
                        orientation: 'portrait',
                        pageSize: 'A4',
                        className: "btn btn-dark bg-dark text-white btn-sm",
                        exportOptions: {
                            columns: [1, 2, 3, 4],
                        },
                        customize: function(doc) {
                            //Remove the title created by datatTables
                            doc.content.splice(0, 1);
                            var now = new Date();
                            var jsDate = now.getDate() + '-' + (now.getMonth() + 1) + '-' + now
                                .getFullYear();
                            var dateTime = "Last Sync: " + now.getDate() + "/" +
                                (now.getMonth() + 1) + "/" +
                                now.getFullYear() + " @ " +
                                now.getHours() + ":" +
                                now.getMinutes() + ":" +
                                now.getSeconds();
                            doc.pageMargins = [20, 40, 20, 30];
                            doc.defaultStyle.fontSize = 8;
                            doc.styles.tableHeader.fontSize = 8;
                            doc.styles.tableBodyEven.alignment = "center";
                            doc.styles.tableBodyOdd.alignment = "center";

                            doc['header'] = (function() {
                                return {
                                    columns: [

                                        {
                                            alignment: 'left',
                                            text: 'Attendance ',
                                            fontSize: 12,
                                        },
                                        {
                                            alignment: 'right',
                                            fontSize: 8,
                                            text: 'Report Time ' + dateTime,
                                        }
                                    ],
                                    margin: [20, 20, 20, 0]
                                }
                            });

                            doc['footer'] = (function(page, pages) {
                                return {
                                    columns: [{
                                            alignment: 'left',
                                            text: "",
                                        },
                                        {
                                            alignment: 'right',
                                            text: ['page ', {
                                                text: page.toString()
                                            }, ' of ', {
                                                text: pages.toString()
                                            }]
                                        }
                                    ],
                                    margin: [20, 0, 20, 20]
                                }
                            });

                            var objLayout = {};
                            objLayout['hLineWidth'] = function(i) {
                                return .5;
                            };
                            objLayout['vLineWidth'] = function(i) {
                                return .5;
                            };
                            objLayout['hLineColor'] = function(i) {
                                return '#aaa';
                            };
                            objLayout['vLineColor'] = function(i) {
                                return '#aaa';
                            };
                            objLayout['paddingLeft'] = function(i) {
                                return 4;
                            };
                            objLayout['paddingRight'] = function(i) {
                                return 4;
                            };
                            doc.content[0].layout = objLayout;
                            doc.content[0].table.widths = ['30%', '10%', '30%', '30%'];
                        }
                    },
                    {
                        text: "<span><i class='fas fa-sync'> Refresh</span>",
                        className: "btn btn-success bg-success text-white btn-sm",
                        action: function(e, dt, node, config) {
                            dt.ajax.reload(null, false);
                        }
                    },
                    {
                        extend: 'pageLength',
                    },
                ],
                lengthMenu: [
                    [10, 25, 50, 100, 500],
                    ["10 rows", "25 rows", "50 rows", "100 rows"]
                ],
                ajax: '/attendance/datatable/ssd',
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
                    {
                        data: 'action',
                        name: 'action',
                        class: 'text-center'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at',
                        class: 'text-center'
                    },
                ],
                order: [
                    [3, 'desc']
                ],
            });
            $(document).on("click", ".delete-btn", function(e) {
                e.preventDefault();
                var id = $(this).data("id");
                swal({
                        title: "Are you sure want to delete?",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {

                            $.ajax({
                                    method: "DELETE",
                                    url: `/attendance/${id}`,
                                })
                                .done(function(res) {
                                    table.ajax.reload();
                                });
                        }
                    });
            })
        });
    </script>
@endsection
