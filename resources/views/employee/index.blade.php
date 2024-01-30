@extends('layouts.app')
@section('title', 'Employee')
@section('content')
    <div>
        <a href="{{ route('employee.create') }}" class="btn btn-theme btn-sm"><i class="fas fa-plus-circle"></i> Create
            Employee</a>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered Datatable" style="width: 100%">
                <thead>
                    <th class="text-center no-sort no-search"></th>
                    <th class="text-center">Employee Id</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Phone</th>
                    <th class="text-center">Department</th>
                    <th class="text-center">Is Present</th>
                    <th class="text-center no-sort">Action</th>
                    <th class="text-center hidden no-sort no-search">Updated At</th>
                </thead>
            </table>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('.Datatable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: '/employee/datatable/ssd',
                columns: [{
                        data: 'plus_icon',
                        name: 'plus_icon',
                        class: 'text-center'
                    },
                    {
                        data: 'employee_id',
                        name: 'employee_id',
                        class: 'text-center'
                    },
                    {
                        data: 'name',
                        name: 'name',
                        class: 'text-center'
                    },
                    {
                        data: 'email',
                        name: 'email',
                        class: 'text-center'
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                        class: 'text-center'
                    },
                    {
                        data: 'department_name',
                        name: 'department_name',
                        class: 'text-center'
                    },
                    {
                        data: 'is_present',
                        name: 'is_present',
                        class: 'text-center'
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
                    [8, 'desc']
                ],
                columnDefs: [{
                        target: 6,
                        visible: false
                    },
                    {
                        target: 0,
                        class: "control"
                    },
                    {
                        target: "no-sort",
                        orderable: false
                    },
                    {
                        target: "no-search",
                        searchable: false
                    },
                    {
                        target: "hidden",
                        visible: false
                    },
                ],
                language: {
                    "paginate": {
                        "previous": "<i class='far fa-arrow-alt-circle-left'></i>",
                        "next": "<i class='far fa-arrow-alt-circle-right'></i>"
                    },
                    "processing": "<img src='/image/loading.gif' style='width:50%'/>"
                },

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
                                    url: `/employee/${id}`,
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
