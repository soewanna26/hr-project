<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class MyProjectController extends Controller
{
    public function index()
    {
        return view('my_project');
    }


    public function ssd(Request $request)
    {
        $project = Project::with('leaders', 'members')->whereHas('leaders', function ($query) {
            $query->where('user_id', auth()->user()->id);
        })->orWhereHas('members', function ($query) {
            $query->where('user_id', auth()->user()->id);
        });
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

                $show_icon = '<a href="' . route('myproject.show', $each->id) . '" class="text-primary"><i class="fas fa-info-circle"></i></a>';

                return '<div class="action-icon">' . $show_icon . '</div>';
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

    public function show($id)
    {
        $project = Project::with('leaders', 'members','tasks')->where('id', $id)->where(function ($query) {
            $query->whereHas('leaders', function ($ql) {
                $ql->where('user_id', auth()->user()->id);
            })->orWhereHas('members', function ($ql) {
                $ql->where('user_id', auth()->user()->id);
            });
        })
            ->findOrFail($id);

        $employees = User::OrderBy('employee_id')->get();
        return view('my_project_show', compact('project', 'employees'));
    }
}
