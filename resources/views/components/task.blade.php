<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <i class="fas fa-tasks"></i> Pending
            </div>
            <div class="card-body alert-warning">
                <div id="pendingTashBoard">
                    @foreach (collect($project->tasks)->sortBy('serial_number')->where('status', 'pending') as $task)
                        <div class="task-item" data-id="{{ $task->id }}">
                            <div class="d-flex justify-content-between">
                                <h5>{{ $task->title }}</h5>
                                <div class="text-action">
                                    <a href="#" class="edit-test_btn text-warning"
                                        data-task="{{ base64_encode(json_encode($task)) }}"
                                        data-task-members="{{ base64_encode(json_encode(collect($task->members)->pluck('id')->toArray())) }}"><i
                                            class="far fa-edit"></i></a>
                                    <a href="#" class="delete-text-btn text-danger"
                                        data-id="{{ $task->id }}"><i class="far fa-trash-alt"></i></a>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="mb-0"><i class="fas fa-clock"></i>
                                        {{ Carbon\Carbon::parse($task->start_date)->format('M d') }}</p>
                                    @if ($task->priority == 'high')
                                        <span class="badge badge-pill badge-danger">High</span>
                                    @elseif($task->priority == 'middle')
                                        <span class="badge badge-pill badge-info">Middle</span>
                                    @elseif($task->priority == 'low')
                                        <span class="badge badge-pill badge-dark">Low</span>
                                    @endif
                                </div>
                                <div>
                                    @foreach ($task->members as $member)
                                        <img src="{{ $member->profile_img_path() }}" alt=""
                                            class="profile-thumbnail3">
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center my-3">
                    <a href="" class="add_pending_task_btn add_task_btn"><i class="fas fa-plus-circle"></i> Add
                        Task</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-info text-white">
                <i class="fas fa-tasks"></i> In Progress
            </div>
            <div class="card-body alert-info">
                <div id="inProgressTashBoard">
                    @foreach (collect($project->tasks)->sortBy('serial_number')->where('status', 'in_progress') as $task)
                        <div class="task-item" data-id="{{ $task->id }}">
                            <div class="d-flex justify-content-between">
                                <h5>{{ $task->title }}</h5>
                                <div class="text-action">
                                    <a href="#" class="edit-test_btn text-warning"
                                        data-task="{{ base64_encode(json_encode($task)) }}"
                                        data-task-members="{{ base64_encode(json_encode(collect($task->members)->pluck('id')->toArray())) }}"><i
                                            class="far fa-edit"></i></a>
                                    <a href="#" class="delete-test_btn text-danger"
                                        data-id="{{ $task->id }}"><i class="far fa-trash-alt"></i></a>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="mb-0"><i class="fas fa-clock"></i>
                                        {{ Carbon\Carbon::parse($task->start_date)->format('M d') }}</p>
                                    @if ($task->priority == 'high')
                                        <span class="badge badge-pill badge-danger">High</span>
                                    @elseif($task->priority == 'middle')
                                        <span class="badge badge-pill badge-info">Middle</span>
                                    @elseif($task->priority == 'low')
                                        <span class="badge badge-pill badge-dark">Low</span>
                                    @endif
                                </div>
                                <div>
                                    @foreach ($task->members as $member)
                                        <img src="{{ $member->profile_img_path() }}" alt=""
                                            class="profile-thumbnail3">
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center my-3">

                    <a href="" class="add_in_progress_task_btn add_task_btn"><i class="fas fa-plus-circle"></i>
                        Add Task</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <i class="fas fa-tasks"></i> Complete
            </div>
            <div class="card-body alert-success">
                <div id="completeTashBoard">
                    @foreach (collect($project->tasks)->sortBy('serial_number')->where('status', 'complete') as $task)
                        <div class="task-item" data-id="{{ $task->id }}">
                            <div class="d-flex justify-content-between">
                                <h5>{{ $task->title }}</h5>
                                <div class="text-action">
                                    <a href="#" class="edit-test_btn text-warning"
                                        data-task="{{ base64_encode(json_encode($task)) }}"
                                        data-task-members="{{ base64_encode(json_encode(collect($task->members)->pluck('id')->toArray())) }}"><i
                                            class="far fa-edit"></i></a>
                                    <a href="#" class="delete-test_btn text-danger"
                                        data-id="{{ $task->id }}"><i class="far fa-trash-alt"></i></a>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="mb-0"><i class="fas fa-clock"></i>
                                        {{ Carbon\Carbon::parse($task->start_date)->format('M d') }}</p>
                                    @if ($task->priority == 'high')
                                        <span class="badge badge-pill badge-danger">High</span>
                                    @elseif($task->priority == 'middle')
                                        <span class="badge badge-pill badge-info">Middle</span>
                                    @elseif($task->priority == 'low')
                                        <span class="badge badge-pill badge-dark">Low</span>
                                    @endif
                                </div>
                                <div>
                                    @foreach ($task->members as $member)
                                        <img src="{{ $member->profile_img_path() }}" alt=""
                                            class="profile-thumbnail3">
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center my-3">
                    <a href="" class="add_complete_task_btn add_task_btn"><i class="fas fa-plus-circle"></i>
                        Add Task</a>
                </div>
            </div>
        </div>
    </div>
</div>
