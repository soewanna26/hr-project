@extends('layouts.app')
@section('title', 'Role')
@section('content')
    @can('create_role')
        <div>
            <a href="{{ route('role.create') }}" class="btn btn-theme btn-sm"><i class="fas fa-plus-circle"></i> Create
                Role</a>
        </div>
    @endcan
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered Datatable" style="width: 100%">
                <thead>
                    <th class="text-center no-sort no-search"></th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Permissions</th>
                    <th class="text-center no-sort">Action</th>
                    <th class="text-center hidden no-sort no-search">Updated At</th>
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
                ajax: '/role/datatable/ssd',
                columns: [{
                        data: 'plus_icon',
                        title: 'plus_icon',
                        class: 'text-center',
                    },
                    {
                        data: 'name',
                        name: 'name',
                        class: 'text-center',
                    },
                    {
                        data: 'permissions',
                        name: 'permissions',
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
                    [4, 'desc']
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
                                    url: `/role/${id}`,
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
