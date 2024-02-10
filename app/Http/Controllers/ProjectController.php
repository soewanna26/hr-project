<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProject;
use App\Http\Requests\UpdateProject;
use App\Models\Project;
use App\Models\ProjectLeader;
use App\Models\ProjectMember;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ProjectController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('view_project')) {
            abort(403, 'Unauthorized action');
        }

        return view('project.index');
    }


    public function ssd(Request $request)
    {
        if (!auth()->user()->can('view_project')) {
            abort(403, 'Unauthorized action');
        }
        $project = Project::with('leaders');
        return DataTables::of($project)
            ->editColumn('description', function ($each) {
                return Str::limit($each->description, 100);
            })
            ->editColumn('priority', function ($each) {
                if ($each->priority == 'high') {
                    return '<span class="badge badge-pill badge-danger">High</span>';
                } else if ($each->priority == 'middle') {
                    return '<span class="badge badge-pill badge-info">Middle</span>';
                } else if ($each->priority == 'low') {
                    return '<span class="badge badge-pill badge-dark">Low</span>';
                }
            })
            ->editColumn('status', function ($each) {
                if ($each->status == 'pending') {
                    return '<span class="badge badge-pill badge-warning">Pending</span>';
                } else if ($each->status == 'in_progress') {
                    return '<span class="badge badge-pill badge-info">In Progres</span>';
                } else if ($each->status == 'complete') {
                    return '<span class="badge badge-pill badge-success">Complete</span>';
                }
            })
            ->addColumn('leaders', function ($each) {
                $output = '<div style="width:160px">';
                foreach ($each->leaders as $leader) {
                    $output .= '<img src="' . $leader->profile_img_path() . '" alt="" class="profile-thumbnail2"/>';
                }
                return $output . '</div>';
            })
            ->addColumn('members', function ($each) {
                $output = '<div style="width:160px">';
                foreach ($each->members as $member) {
                    $output .= '<img src="' . $member->profile_img_path() . '" alt="" class="profile-thumbnail2"/>';
                }
                return $output . '</div>';
            })
            ->addColumn('action', function ($each) {
                $show_icon = '';
                $edit_icon = '';
                $delete_icon = '';

                if (auth()->user()->can('view_project')) {
                    $show_icon = '<a href="' . route('project.show', $each->id) . '" class="text-primary"><i class="fas fa-info-circle"></i></a>';
                }
                if (auth()->user()->can('edit_project')) {
                    $edit_icon = '<a href="' . route('project.edit', $each->id) . '" class="text-warning"><i class="fas fa-edit"></i></a>';
                }
                if (auth()->user()->can('delete_project')) {

                    $delete_icon = '<a href="#" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="fas fa-trash-alt"></i></a>';
                }

                return '<div class="action-icon">' . $show_icon  . $edit_icon . $delete_icon . '</div>';
            })
            ->editColumn('updated_at', function ($each) {
                return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
            })
            ->addColumn('plus_icon', function ($each) {
                return null;
            })
            ->rawColumns(['priority', 'status', 'action', 'leaders', 'members'])
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('create_project')) {
            abort(403, 'Unauthorized action');
        }
        $employees = User::OrderBy('employee_id')->get();
        return view('project.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProject $request)
    {
        if (!auth()->user()->can('create_project')) {
            abort(403, 'Unauthorized action');
        }
        $image_names = null;
        if ($request->hasFile('images')) {
            $image_names = [];
            $images_file = $request->file('images');
            foreach ($images_file as $image_file) {
                $image_name = uniqid() . '_' . time() . '.' . $image_file->getClientOriginalExtension();
                Storage::disk('public')->put('project/' . $image_name, file_get_contents($image_file));
                $image_names[] = $image_name;
            }
        }
        $file_names = null;
        if ($request->hasFile('files')) {
            $file_names = [];
            $files = $request->file('files');
            foreach ($files as $file) {
                $file_name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                Storage::disk('public')->put('project/' . $file_name, file_get_contents($file));
                $file_names[] = $file_name;
            }
        }
        $project = new Project();
        $project->title = $request->title;
        $project->description = $request->description;
        $project->start_date = $request->start_date;
        $project->deadline = $request->deadline;
        $project->priority = $request->priority;
        $project->status = $request->status;
        $project->images = $image_names;
        $project->files = $file_names;
        $project->save();

        foreach (($request->leaders ?? []) as $leader) {
            ProjectLeader::firstOrCreate(
                [
                    'project_id' => $project->id,
                    'user_id' => $leader,
                ]
            );
        }
        foreach (($request->members ?? []) as $member) {
            ProjectMember::firstOrCreate(
                [
                    'project_id' => $project->id,
                    'user_id' => $member,
                ]
            );
        }
        return redirect()->route('project.index')->with('create', 'Successfully Created project');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (!auth()->user()->can('show_project')) {
            abort(403, 'Unauthorized action');
        }
        $project = Project::findOrFail($id);
        $employees = User::OrderBy('employee_id')->get();
        return view('project.show', compact('project', 'employees'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (!auth()->user()->can('edit_project')) {
            abort(403, 'Unauthorized action');
        }
        $project = Project::findOrFail($id);
        $employees = User::OrderBy('employee_id')->get();
        return view('project.edit', compact('project', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, UpdateProject $request)
    {
        if (!auth()->user()->can('edit_project')) {
            abort(403, 'Unauthorized action');
        }
        $project = Project::findOrFail($id);
        $image_names = $project->images;
        if ($request->hasFile('images')) {
            $image_names = [];
            $images_file = $request->file('images');
            foreach ($images_file as $image_file) {
                $image_name = uniqid() . '_' . time() . '.' . $image_file->getClientOriginalExtension();
                Storage::disk('public')->put('project/' . $image_name, file_get_contents($image_file));
                $image_names[] = $image_name;
            }
        }
        $file_names = $project->files;
        if ($request->hasFile('files')) {
            $file_names = [];
            $files = $request->file('files');
            foreach ($files as $file) {
                $file_name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                Storage::disk('public')->put('project/' . $file_name, file_get_contents($file));
                $file_names[] = $file_name;
            }
        }
        $project->title = $request->title;
        $project->description = $request->description;
        $project->start_date = $request->start_date;
        $project->deadline = $request->deadline;
        $project->priority = $request->priority;
        $project->status = $request->status;
        $project->images = $image_names;
        $project->files = $file_names;
        $project->update();

        foreach (($request->leaders ?? []) as $leader) {
            ProjectLeader::firstOrCreate(
                [
                    'project_id' => $project->id,
                    'user_id' => $leader,
                ]
            );
        }
        foreach (($request->members ?? []) as $member) {
            ProjectMember::firstOrCreate(
                [
                    'project_id' => $project->id,
                    'user_id' => $member,
                ]
            );
        }
        return redirect()->route('project.index')->with('edit', 'Successfully Edit project');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('delete_project')) {
            abort(403, 'Unauthorized action');
        }

        $project = Project::findOrFail($id);

        if ($project->images) {
            foreach ($project->images as $image) {
                $imagePath = public_path('storage/project/' . $image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
        }

        // Delete project files
        if ($project->files) {
            foreach ($project->files as $file) {
                $filePath = public_path('storage/project/' . $file);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }


        // Delete project leaders
        $project_leaders = ProjectLeader::where('project_id', $project->id)->get();
        foreach ($project_leaders as $project_leader) {
            $project_leader->delete();
        }

        // Delete project members
        $project_members = ProjectMember::where('project_id', $project->id)->get();
        foreach ($project_members as $project_member) {
            $project_member->delete();
        }

        // Delete the project itself
        $project->delete();

        return 'success';
    }
}
