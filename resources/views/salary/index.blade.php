@extends('layouts.app')
@section('title', 'Salary')
@section('content')
    @can('create_salary')
        <div>
            <a href="{{ route('salary.create') }}" class="btn btn-theme btn-sm"><i class="fas fa-plus-circle"></i> Create
                Salary</a>
        </div>
    @endcan

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered Datatable" style="width: 100%">
                <thead>
                    <th class="text-center no-sort no-search"></th>
                    <th class="text-center">Employee Name</th>
                    <th class="text-center">Month</th>
                    <th class="text-center">Year</th>
                    <th class="text-center">Amount</th>
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
                ajax: '/salary/datatable/ssd',
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
                        data: 'month',
                        name: 'month',
                        class: 'text-center',
                    },
                    {
                        data: 'year',
                        name: 'year',
                        class: 'text-center',
                    },
                    {
                        data: 'amount',
                        name: 'amount',
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
                    [6, 'desc']
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
                                    url: `/salary/${id}`,
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
