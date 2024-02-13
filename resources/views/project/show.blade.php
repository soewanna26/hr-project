@extends('layouts.app')
@section('title', 'Project')
@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="card mb-3">
                <div class="card-body">
                    <h5>{{ $project->title }}</h5>
                    <p class="mb-4">Start Date :<span class="text-muted"> {{ $project->start_date }}</span> , Deadline :
                        <span class="text-muted">{{ $project->deadline }}</span>
                    </p>
                    <p class="mb-3">Priority :
                        @if ($project->priority == 'high')
                            <span class="badge badge-pill badge-danger">High</span>
                        @elseif ($project->priority == 'middle')
                            <span class="badge badge-pill badge-info">Middle</span>
                        @elseif ($project->priority == 'low')
                            <span class="badge badge-pill badge-dark">Dark</span>
                        @endif
                        ,
                        Status : @if ($project->status == 'pending')
                            <span class="badge badge-pill badge-warning">Pending</span>
                        @elseif ($project->status == 'in_progress')
                            <span class="badge badge-pill badge-info">In Progress</span>
                        @elseif ($project->status == 'complete')
                            <span class="badge badge-pill badge-success">Complete</span>
                        @endif
                    </p>
                    <h5>Description</h5>
                    <p class="mb-1">{{ $project->description }}</p>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <h5>Image</h5>
                    <div id="images">
                        @if ($project->images)
                            @foreach ($project->images as $image)
                                <img src="{{ asset('storage/project/' . $image) }}" alt="" class="image-thumbnail">
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <h5>File</h5>
                    @if ($project->files)
                        @foreach ($project->files as $file)
                            <a href="{{ asset('storage/project/' . $file) }}" class="pdf-thumbnail" target="_blank"><i
                                    class="fas fa-file-pdf"></i>
                                <p class="mb-0">File{{ $loop->iteration }}</p>
                            </a>
                        @endforeach

                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card mb-3">
                <div class="card-body">
                    <h5>Leader</h5>
                    @foreach ($project->leaders ?? [] as $leader)
                        <img src="{{ $leader->profile_img_path() }}" alt="" class="profile-thumbnail2">
                    @endforeach
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5>Member</h5>
                    @foreach ($project->members ?? [] as $member)
                        <img src="{{ $member->profile_img_path() }}" alt="" class="profile-thumbnail2">
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            new Viewer(document.getElementById('images'));
        });
    </script>
@endsection
