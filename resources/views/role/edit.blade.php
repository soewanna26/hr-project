@extends('layouts.app')
@section('title', 'Edit Role')
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('role.update', $role->id) }}" method="POST" id="edit-form" autocomplete="off">
                @csrf
                @method('PUT')
                <div class="md-form">
                    <label for="">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $role->name }}">
                </div>
                <div class="d-flex justify-content-center mt-5 mb-3">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-theme btn-sm btn-block">Confirm</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    {!! JsValidator::formRequest('App\Http\Requests\UpdateRole', '#edit-form') !!}
    <script>
        $(document).ready(function() {});
    </script>
@endsection
