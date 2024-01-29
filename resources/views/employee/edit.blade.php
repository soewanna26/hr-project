@extends('layouts.app')
@section('title', 'Edit Employee')
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('employee.update', $employee->id) }}" method="POST" id="edit-form" autocomplete="off">
                @csrf
                @method('PUT')
                <div class="md-form">
                    <label for="employee_id">Employee Id</label>
                    <input type="text" name="employee_id" class="form-control" value="{{ $employee->id }}">
                </div>
                <div class="md-form">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $employee->name }}">
                </div>
                <div class="md-form">
                    <label for="phone">Phone</label>
                    <input type="number" name="phone" class="form-control" value="{{ $employee->phone }}">
                </div>
                <div class="md-form">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $employee->email }}">
                </div>
                {{-- <div class="md-form">
                    <label for="">Password</label>
                    <input type="password" name="password" class="form-control">
                </div> --}}
                <div class="md-form">
                    <label for="nrc_number">Nrc Number</label>
                    <input type="text" name="nrc_number" class="form-control" value="{{ $employee->nrc_number }}">
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select name="gender" class="form-control">
                        <option value="" disabled selected>Selected</option>
                        <option value="male" {{ $employee->gender == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ $employee->gender == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>
                <div class="md-form">
                    <label for="birthday">Birthday</label>
                    <input type="text" name="birthday" class="form-control birthday" value="{{ $employee->birthday }}">
                </div>
                <div class="md-form">
                    <label for="">Address</label>
                    <textarea type="address" name="address" class="md-textarea form-control">{{ $employee->address }}</textarea>
                </div>
                <div class="form-group">
                    <label for="">Department</label>
                    <select name="department_id" class="form-control">
                        <option value="" disabled selected>Selected</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}"
                            @if ($employee->department_id == $department->id)
                                selected
                            @endif>
                                {{ $department->title }}</option>
                        @endforeach

                    </select>
                </div>
                <div class="md-form">
                    <label for="">Birthday</label>
                    <input type="text" name="date_of_join" class="form-control date_of_join"
                        value="{{ $employee->date_of_join }}">
                </div>
                <div class="form-group">
                    <label for="">Is Present</label>
                    <select name="is_present" class="form-control">
                        <option value="" disabled selected>Selected</option>
                        <option value="1" {{ $employee->is_present == 1 ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ $employee->is_present == 0 ? 'selected' : '' }}>No</option>
                    </select>
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
    {!! JsValidator::formRequest('App\Http\Requests\UpdateEmployee', '#edit-form') !!}
    <script>
        $(document).ready(function() {
            $('.birthday').daterangepicker({
                singleDatePicker: true,
                "showDropdowns": true,
                "autoApply": true,
                "maxDate": moment(),
                "locale": {
                    "format": "YYYY/MM/DD",
                }
            });
            $('.date_of_join').daterangepicker({
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
