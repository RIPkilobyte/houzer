<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Project;
use Auth;
use Redirect;
use App\Models\User;
use App\Models\Property;
use App\Models\Log;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Laravel\Fortify\Rules\Password;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function user_create(Request $request)
    {
        //view create user
        if(!User::isadmin()) {
            $request->session()->flash('error', 'You dont nave access to this action');
            return back();
        }
        return view('admin.create_user',[
            'title' => 'Create user',
        ]);
    }

    public function user_store(Request $request)
    {
        if(!User::isadmin()) {
            $request->session()->flash('error', 'You dont nave access to this action');
            return back();
        }
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'role' => ['required'],
            'email' => ['required', 'unique:users'],
            'password' => ['required', 'string', new Password],
            'phone' => ['nullable', 'string', 'max:255'],
        ]);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = new User();
        $user->first_name = $input['first_name'];
        $user->last_name = $input['last_name'];
        $user->email = $input['email'];
        $user->role = $input['role'];
        $user->attention = 1;
        $user->password = Hash::make($input['password']);
        $user->phone = $input['phone'];
        $user->save();

        $log = new Log();
        $log->user_id = $user->id;
        $log->action_user_id = Auth::user()->id;
        $log->user_type = Auth::user()->role;
        $log->user_name = Auth::user()->first_name.' '.Auth::user()->last_name;
        $log->action = 'Profile registration';
        $log->save();

        $request->session()->flash('status', 'User successfully created');

        return redirect()->route('admin.user', $user->id);
    }

    public function user(Request $request, $id)
    {
        if(!User::isadmin()) {
            $request->session()->flash('error', 'You dont nave access to this action');
            return back();
        }
        $user = User::where('id', $id)->firstOrFail();

        $active_projects = Project::where('active', 1)->get();
        $projects = Project::get();
        $projects_selected = [];
        foreach($user->projects as $project) {
            $projects_selected[] = $project->id;
        }
        $locations = Location::get();
        $locations_selected = [];
        foreach($user->locations as $location) {
            $locations_selected[] = $location->id;
        }

        $logs = Log::where('user_id', $id)->orderBy('created_at', 'desc')->get();
        foreach($logs as $k=>$v) {
            $logs[$k]->username = '';
            $action_user = User::where('id', $v->action_user_id)->first();
            if($action_user) {
                $logs[$k]->username = $action_user->first_name.' '.$action_user->last_name;
            }
            $logs[$k]->date = date('d-m-Y', strtotime($v->created_at));
        }

        return view('admin.user',[
            'title' => 'Edit user #'.$id,
            'user' => $user,
            'projects' => $projects,
            'projects_selected' => $projects_selected,
            'active_projects' => $active_projects,
            'locations' => $locations,
            'locations_selected' => $locations_selected,
            'logs' => $logs,
        ]);
    }

    public function user_update(Request $request, $id)
    {
        if(!User::isadmin()) {
            $request->session()->flash('error', 'You dont nave access to this action');
            return back();
        }
        $user = User::where('id', $id)->firstOrFail();
        $input = $request->all();

        $rules = [
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'email' => ['required', 'unique:users,email,'.$user->id],
            'phone' => ['nullable', 'string', 'max:255'],
        ];
        if($input['password']) {
            $rules['password'] = ['required', 'string', new Password];
        }

        if($user->role == 'Admin') {
            $request->session()->flash('error', __('Administrator profile cannot be changed'));
            return back();
        }

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user->first_name = $input['first_name'];
        $user->last_name = $input['last_name'];
        $user->email = $input['email'];
        $user->phone = $input['phone'];
        if($input['password']) {
            $user->password = Hash::make($input['password']);
        }
        $user->save();

        $log = new Log();
        $log->user_id = $user->id;
        $log->action_user_id = Auth::user()->id;
        $log->user_type = Auth::user()->role;
        $log->user_name = Auth::user()->first_name.' '.Auth::user()->last_name;
        $log->action = 'Profile uplate';
        $log->save();

        $request->session()->flash('status', 'User successfully updated');
        return back();
    }

    public function user_update_notes(Request $request, $id)
    {
        if(!User::isadmin()) {
            $request->session()->flash('error', 'You dont nave access to this action');
            return back();
        }
        $user = User::where('id', $id)->firstOrFail();
        $input = $request->all();

        if($user->role == 'Admin') {
            $request->session()->flash('error', __('Administrator profile cannot be changed'));
            return back();
        }

        $user->notes = $input['notes'];
        $user->save();

        $log = new Log();
        $log->user_id = $user->id;
        $log->action_user_id = Auth::user()->id;
        $log->user_type = Auth::user()->role;
        $log->user_name = Auth::user()->first_name.' '.Auth::user()->last_name;
        $log->action = 'Profile uplate notes';
        $log->save();

        $request->session()->flash('status', 'User successfully updated');
        return back();
    }

    public function user_update_other(Request $request, $id)
    {
        if(!User::isadmin()) {
            $request->session()->flash('error', 'You dont nave access to this action');
            return back();
        }
        $user = User::where('id', $id)->firstOrFail();
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'locations' => ['required'],
            'home' => ['required'],
        ],
        [
            'required' => 'You must select at leas one'
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if($user->role == 'Admin') {
            $request->session()->flash('error', __('Administrator profile cannot be changed'));
            return back();
        }

        $user->locations()->detach();
        foreach ($input['locations'] as $selected) {
            $location = Location::find($selected);
            $user->locations()->attach($location);
        }
        $user->project = $input['project'];
        $user->house = isset($input['home']['house']) ? 1:0;
        $user->apartments = isset($input['home']['apartments']) ? 1:0;
        $user->homeowner = $user->bedrooms1 = $user->bedrooms2 = $user->bedrooms3 = $user->bedrooms4 = 0;
        if (!empty($input['bedrooms1'])) {
            $user->bedrooms1 = $input['bedrooms1'];
        }
        if (!empty($input['bedrooms2'])) {
            $user->bedrooms2 = $input['bedrooms2'];
        }
        if (!empty($input['bedrooms3'])) {
            $user->bedrooms3 = $input['bedrooms3'];
        }
        if (!empty($input['bedrooms4'])) {
            $user->bedrooms4 = $input['bedrooms4'];
        }
        if (!empty($input['homeowner']) && isset($input['homeowner'][0])) {
            $user->homeowner = $input['homeowner'][0] ? 1:0;
        }
        $user->projects()->detach();
        if (isset($input['joined'])) {
            foreach ($input['joined'] as $joined) {
                $project = Project::find($joined);
                $user->projects()->attach($project);
            }
        }
        $user->save();

        $log = new Log();
        $log->user_id = $user->id;
        $log->action_user_id = Auth::user()->id;
        $log->user_type = Auth::user()->role;
        $log->user_name = Auth::user()->first_name.' '.Auth::user()->last_name;
        $log->action = 'Update User by Admin';
        $log->save();

        $request->session()->flash('status', 'User successfully updated');
        return back();
    }

    public function user_activate_attention(Request $request, $id)
    {
        if(!User::isadmin()) {
            $request->session()->flash('error', 'You dont nave access to this action');
            return back();
        }
        $user = User::where('id', $id)->firstOrFail();
        if($user->attention) {
            $user->attention = 0;
        }
        else {
            $user->attention = 1;
        }
        $user->save();

        $log = new Log();
        $log->user_id = $user->id;
        $log->action_user_id = Auth::user()->id;
        $log->user_type = Auth::user()->role;
        $log->user_name = Auth::user()->first_name.' '.Auth::user()->last_name;
        $log->action = 'Profile change attention';
        $log->save();

        $request->session()->flash('status', 'User successfully updated');
        return back();
    }

    public function manager(Request $request)
    {
        if(!User::isadmin()) {
            $request->session()->flash('error', 'You dont nave access to this action');
            return back();
        }
        $projects = Project::get();

        return view('admin.project_manager',[
            'title' => 'Project Manager',
            'projects' => $projects,
        ]);
    }

    public function project_store(Request $request)
    {
        $user = Auth::user();
        if(!User::isadmin()) {
            $request->session()->flash('error', 'You dont nave access to this action');
            return back();
        }

        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'number' => ['required', 'max:255'],
            'name' => ['required', 'max:255'],
            'description' => ['required'],
            'link' => ['required'],
        ]);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $project = new Project();
        $project->number = $input['number'];
        $project->name = $input['name'];
        $project->description = $input['description'];
        $project->link = $input['link'];
        $project->active = isset($input['active']) ? 1:0;
        $project->save();

        $log = new Log();
        $log->user_id = $user->id;
        $log->action_user_id = Auth::user()->id;
        $log->user_type = Auth::user()->role;
        $log->user_name = Auth::user()->first_name.' '.Auth::user()->last_name;
        $log->action = 'Project '.$input['name'].' create';
        $log->save();

        $request->session()->flash('status', 'Project successfully created');

        return redirect()->route('manager');
    }

    public function project_update(Request $request, $id)
    {
        $user = Auth::user();
        if(!User::isadmin()) {
            $request->session()->flash('error', 'You dont nave access to this action');

            return back();
        }
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'number' => ['required', 'max:255'],
            'name' => ['required', 'max:255'],
            'description' => ['required'],
            'link' => ['required'],
        ]);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        $project = Project::where('id', $id)->firstOrFail();
        $project->number = $input['number'];
        $project->name = $input['name'];
        $project->description = $input['description'];
        $project->link = $input['link'];
        $project->active = isset($input['active']) ? 1:0;

        $project->save();


        $log = new Log();
        $log->user_id = $user->id;
        $log->action_user_id = Auth::user()->id;
        $log->user_type = Auth::user()->role;
        $log->user_name = Auth::user()->first_name.' '.Auth::user()->last_name;
        $log->action = 'Project '.$input['name'].' update';
        $log->save();

        $request->session()->flash('status', 'Project successfully updated');

        return back();
    }

    public function project_destroy(Request $request, $id)
    {
        if(!User::isadmin()) {
            $request->session()->flash('error', 'You dont nave access to this action');
            return back();
        }
        $project = Project::where('id', $id)->firstOrFail();
        $project->users()->detach();

        $users = User::where('project', $project->id)->get();
        if ($users) {
            foreach ($users as $user) {
                $user->project = 0;
                $user->save();
            }
        }
        $project->delete();
        $request->session()->flash('status', 'Project successfully deleted');
        return back();
    }

    public function user_destroy(Request $request, $id)
    {
        if(!User::isadmin()) {
            $request->session()->flash('error', 'You dont nave access to this action');
            return back();
        }
        $user = User::where('id', $id)->firstOrFail();
        if($user->role != 'Admin') {
            $user->locations()->detach();
            $user->projects()->detach();
            User::find($id)->delete();

            $log = new Log();
            $log->user_id = $user->id;
            $log->action_user_id = Auth::user()->id;
            $log->user_type = Auth::user()->role;
            $log->user_name = Auth::user()->first_name.' '.Auth::user()->last_name;
            $log->action = 'Profile delete';
            $log->save();
        }
        $request->session()->flash('status', 'User successfully deleted');
        return Redirect::route('users');
    }

    public function users(Request $request)
    {
        if(!User::isadmin()) {
            $request->session()->flash('error', 'You dont nave access to this action');
            return back();
        }
        $locations = Location::get();
        $projects = Project::get();
        return view('admin.users',[
            'title' => 'Users',
            'locations' => $locations,
            'projects' => $projects,
        ]);
    }

    public function users_datatable(Request $request)
    {
        if(!User::isadmin()) {
            return '';
        }
        $input = $request->all();
        $column = $input['order'][0]['column'];
        $dir = $input['order'][0]['dir'];
        $order_column = 'id';

        $locations = Location::get();
        $projects = Project::get();
        //dd($input['property']);
        switch ($input['property']) {
            case 'H':
                $users = User::where('house', 1)->get();
                break;
            case 'A':
                $users = User::where('apartments', 1)->get();
                break;
            case 'HA':
                $users = User::where('house', 1)->where('apartments', 1)->get();
                break;
            default:
                $users = User::get();
                break;
        }

        return datatables()->of($users)
        ->addColumn('actions', function ($row) {
            $html = '';
            if($row->attention) {
                $html .= '<i class="fas fa-exclamation-circle fa-lg text-red"></i>';
            }
            else {
                $html .= '<i class="fas fa-exclamation-circle fa-lg text-muted"></i>';
            }
            return $html;
        })
        ->addColumn('name', function($row) {
            return $row->first_name.' '.$row->last_name;
        })
        ->addColumn('project', function($row) {
            $html = '';
            if ($row->project) {
                $project = Project::where('id', $row->project)->firstOrFail();
                $html = $project->number;
            }
            return $html;
        })
        ->addColumn('locations', function ($row) {
            $html = '';
            if ($row->locations && isset($row->locations[0])) {
                $html = $row->locations[0]->name;
                if (isset($row->locations[1])) {
                    $html .= '...';
                }
            }
            return $html;
        })
        ->addColumn('locations_title', function ($row) {
            $html = [];
            foreach($row->locations as $location) {
                $html[] = $location->name;
            }
            return implode(', ', $html);
        })
        ->addColumn('type', function ($row) {
            $html = [];
            if ($row->house) {
                $html[] = 'H';
            }
            if ($row->apartments) {
                $html[] = 'A';
            }
            return implode(', ', $html);
        })
        ->addColumn('waiting', function ($row) {
            $html = [];
            foreach ($row->projects as $project) {
                $html[] = $project->number;
            }
            return implode(', ', $html);
        })
        ->rawColumns(['actions'])
        ->toJson();
    }
}
