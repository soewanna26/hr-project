@extends('layouts.app')
@section('title', 'Department')
@section('content')
    <div>
        <a href="{{ route('department.create') }}" class="btn btn-theme btn-sm"><i class="fas fa-plus-circle"></i> Create
            Department</a>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered Datatable" style="width: 100%">
                <thead>
                    <th class="text-center no-sort no-search"></th>
                    <th class="text-center">Title</th>
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
                ajax: '/department/datatable/ssd',
                columns: [{
                        data: 'plus_icon',
                        title: 'plus_icon',
                        class: 'text-center',
                    },
                    {
                        data: 'title',
                        name: 'title',
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
                                    url: `/department/${id}`,
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
