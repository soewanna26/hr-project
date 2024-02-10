@extends('layouts.app')
@section('title', 'Create Project')
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('project.store') }}" method="POST" id="create-form" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="md-form">
                    <label for="">Title</label>
                    <input type="text" name="title" class="form-control">
                </div>
                <div class="md-form">
                    <label for="">Description</label>
                    <textarea name="description" class="md-textarea form-control p-3" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <label for="">Images (Only PNG,JPG,JPEG)</label>
                    <input type="file" name="images[]" class="form-control p-1" id="images" multiple
                        accept="images/.gif, .jpg, .png, .doc">

                    <div class="preview_img my-2">

                    </div>
                </div>
                <div class="form-group">
                    <label for="">FIles (Only PDF)</label>
                    <input type="file" name="files[]" class="form-control p-1" id="files" multiple accept="application/pdf">
                </div>
                <div class="md-form">
                    <label for="">Start Date</label>
                    <input type="text" name="start_date" class="form-control datepicker">
                </div>
                <div class="md-form">
                    <label for="">Deadline</label>
                    <input type="text" name="deadline" class="form-control datepicker">
                </div>
                <div class="form-group">
                    <label for="">Leader</label>
                    <select name="leaders[]" class="form-control select-customize" multiple>
                        <option value="">--Please Choose--</option>
                        @foreach ($employees as $employee)
                            <option value="{{$employee->id}}">{{$employee->employee_id}} ({{$employee->name}})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Member</label>
                    <select name="members[]" class="form-control select-customize" multiple>
                        <option value="">--Please Choose--</option>
                        @foreach ($employees as $employee)
                            <option value="{{$employee->id}}">{{$employee->employee_id}} ({{$employee->name}})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Priority</label>
                    <select name="priority" class="form-control select-customize">
                        <option value="">--Please Choose--</option>
                        <option value="high">High</option>
                        <option value="middle">Middle</option>
                        <option value="low">Low</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Status</label>
                    <select name="status" class="form-control select-customize">
                        <option value="">--Please Choose--</option>
                        <option value="pending">Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="complete">Complete</option>
                    </select>

                </div>
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
    {!! JsValidator::formRequest('App\Http\Requests\StoreProject', '#create-form') !!}
    <script>
        $(document).ready(function() {
            $('#images').on('change', function() {
                var file_length = document.getElementById('images').files.length;
                $('.preview_img').html('');
                for (var i = 0; i < file_length; i++) {
                    $('.preview_img').append(`<img src="${URL.createObjectURL(event.target.files[i])}"/>`)
                }
            })
            $('.datepicker').daterangepicker({
                singleDatePicker: true,
                "showDropdowns": true,
                "autoApply": true,
                "locale": {
                    "format": "YYYY/MM/DD",
                }
            });
        });
    </script>
@endsection
