<?php

namespace App\Http\Controllers;

use App\Mail\AccountActivation;
use Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Redirect;
use App\Models\User;
use App\Models\Project;
use App\Models\Location;
use App\Models\Log;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Laravel\Fortify\Rules\Password;
use setasign\Fpdf\Fpdf;
use setasign\Fpdi\Fpdi;

class UserController extends Controller
{
    public function registration(Request $request)
    {
        return view('auth.register');
    }

    public function create(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'email' => ['required', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'string', new Password],
        ]);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $user = new User();
        $user->first_name = $input['first_name'];
        $user->last_name = $input['last_name'];
        $user->email = $input['email'];
        $user->role = 'User';
        $user->phone = $input['phone'];
        $user->attention = 1;
        $user->password = Hash::make($input['password']);
        $user->save();

        $log = new Log();
        $log->user_id = $user->id;
        $log->action_user_id = $user->id;
        $log->user_type = $user->role;
        $log->user_name = $user->first_name.' '.$user->last_name;
        $log->action = 'Profile registration';
        $log->save();

        try {
            event(new Registered($user));
            //Mail::to($user->email)->send(new AccountActivation($user->first_name.' '.$user->last_name, $input['password']));
        }
        catch (Exception $e) {}

        return redirect()->route('verification.notice');
    }

    public function postregister(Request $request)
    {
        return view('auth.postregister');
    }

    public function step1view(Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->step_register, ['one', 'done'])) {
            return redirect()->route('home');
        }

        return view('user.step1',[
            'title' => 'PostRegistration step 1',
            'user' => $user,
        ]);
    }

    public function step1store(Request $request)
    {
        $goto = 'step2.view';
        $user = Auth::user();
        if (!in_array($user->step_register, ['one', 'done'])) {
            return redirect()->route('home');
        }
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'homeowner' => ['required'],
        ]);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $user->homeowner = 0;
        if (!empty($input['homeowner']) && isset($input['homeowner'][0])) {
            $user->homeowner = $input['homeowner'][0] ? 1:0;
        }

        if ('one' === $user->step_register) {
            $goto = 'step2';
            $user->step_register = 'two';
        }
        $user->save();

        $log = new Log();
        $log->user_id = $user->id;
        $log->action_user_id = Auth::user()->id;
        $log->user_type = Auth::user()->role;
        $log->user_name = Auth::user()->first_name.' '.Auth::user()->last_name;
        $log->action = 'Update PostRegistration step one';
        $log->save();

        if ('profile' === $goto) {
            return redirect()->route('profile');
        }

        return redirect()->route('step2.view');
    }

    public function step2view(Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->step_register, ['two', 'done'])) {
            return redirect()->route('home');
        }

        return view('user.step2',[
            'title' => 'PostRegistration step 2',
            'user' => $user,
        ]);
    }

    public function step2store(Request $request)
    {
        $goto = 'step3.view';
        $user = Auth::user();
        if (!in_array($user->step_register, ['two', 'done'])) {
            return redirect()->route('home');
        }

        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'home' => ['required'],
        ],
        [
            'required' => 'You must select a home'
        ]);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $user->house = isset($input['home']['house']) ? 1:0;
        $user->apartments = isset($input['home']['apartments']) ? 1:0;

        if ('two' === $user->step_register) {
            $goto = 'projects';
            $user->step_register = 'three';
        }
        $user->save();

        $log = new Log();
        $log->user_id = $user->id;
        $log->action_user_id = Auth::user()->id;
        $log->user_type = Auth::user()->role;
        $log->user_name = Auth::user()->first_name.' '.Auth::user()->last_name;
        $log->action = 'Update PostRegistration step two';
        $log->save();

        if ('profile' === $goto) {
            return redirect()->route('profile');
        }

        return redirect()->route('step3.view');
    }

    public function step3store(Request $request)
    {
        $goto = 'step4.view';
        $user = Auth::user();
        if (!in_array($user->step_register, ['three', 'done'])) {
            return redirect()->route('home');
        }

        $input = $request->all();

        $user->bedrooms1 = $user->bedrooms2 = $user->bedrooms3 = $user->bedrooms4 = 0;
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

        if ('three' === $user->step_register) {
            $goto = 'projects';
            $user->step_register = 'four';
        }
        $user->save();

        $log = new Log();
        $log->user_id = $user->id;
        $log->action_user_id = Auth::user()->id;
        $log->user_type = Auth::user()->role;
        $log->user_name = Auth::user()->first_name.' '.Auth::user()->last_name;
        $log->action = 'Update PostRegistration step three';
        $log->save();

        if ('profile' === $goto) {
            return redirect()->route('profile');
        }

        return redirect()->route('step4.view');
    }

    public function step3view(Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->step_register, ['three', 'done'])) {
            return redirect()->route('home');
        }

        return view('user.step3',[
            'title' => 'PostRegistration step 3',
            'user' => $user,
        ]);
    }

    public function step4view(Request $request)
    {
        $user = Auth::user();
        $locations = Location::get();

        if (!in_array($user->step_register, ['four', 'done'])) {
            return redirect()->route('home');
        }

        $locations_selected = [];
        foreach($user->locations as $location) {
            $locations_selected[] = $location->id;
        }

        return view('user.step4',[
            'title' => 'PostRegistration step 4',
            'user' => $user,
            'locations' => $locations,
            'locations_selected' => $locations_selected,
        ]);
    }

    public function step4store(Request $request)
    {
        $goto = 'projects';
        $user = Auth::user();
        if (!in_array($user->step_register, ['four', 'done'])) {
            return redirect()->route('home');
        }
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'locations' => ['required'],
        ],
        [
            'required' => 'You must select at leas one location'
        ]);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user->locations()->detach();
        foreach ($input['locations'] as $selected) {
            $location = Location::find($selected);
            $user->locations()->attach($location);
        }
        if ('four' === $user->step_register) {
            $goto = 'projects';
            $user->step_register = 'five';
        }
        $user->save();

        $log = new Log();
        $log->user_id = $user->id;
        $log->action_user_id = Auth::user()->id;
        $log->user_type = Auth::user()->role;
        $log->user_name = Auth::user()->first_name.' '.Auth::user()->last_name;
        $log->action = 'Update PostRegistration step one';
        $log->save();

        if ('profile' === $goto) {
            return redirect()->route('profile');
        }

        return redirect()->route('projects');
    }

    public function projects(Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->step_register, ['five', 'done'])) {
            return redirect()->route('home');
        }

        $input = $request->all();
        $skip = isset($input['skip']) ? 1:0;
        $projects = Project::get();

        $projects_selected = [];
        foreach($user->projects as $project) {
            $projects_selected[] = $project->id;
        }

        return view('user.projects',[
            'title' => 'Projects',
            'user' => $user,
            'skip' => $skip,
            'projects' => $projects,
            'projects_selected' => $projects_selected,
        ]);
    }

    public function projects_store(Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->step_register, ['five', 'done'])) {
            return redirect()->route('home');
        }
        $input = $request->all();
        $goto = 'profile';
        if (0 == $input['skipped']) {
            $user->projects()->detach();
            if (isset($input['joined'])) {
                foreach ($input['joined'] as $joined) {
                    $project = Project::find($joined);
                    $user->projects()->attach($project);
                }
            }
        }

        if ('five' === $user->step_register) {
            $goto = 'complete';
            $user->step_register = 'done';
            //$request->session()->flash('status', 'Projects successfully updated');
        }
        else {
            $request->session()->flash('status', 'Success');
        }
        $user->save();

        return redirect()->route($goto);
    }

    public function complete(Request $request)
    {
        return view('user.complete',[
            'title' => 'Reg-complete',
        ]);
    }

    public function profile(Request $request)
    {
        $user = Auth::user();
        if ('done' !== $user->step_register) {
            return redirect()->route('home');
        }
        $locations = Location::get();
        $project = null;
        if ($user->project) {
            $project = Project::find($user->project);
        }

        $rooms = [];
        if ($user->bedrooms1) {
            $rooms[] = 1;
        }
        if ($user->bedrooms2) {
            $rooms[] = 2;
        }
        if ($user->bedrooms3) {
            $rooms[] = 3;
        }
        if ($user->bedrooms4) {
            $rooms[] = 4;
        }

        $locations_selected = [];
        foreach($user->locations as $location) {
            $locations_selected[] = $location->name;
        }

        $user_projects = $user->projects;
        return view('user.profile',[
            'title' => 'Profile',
            'user' => $user,
            'locations' => $locations,
            'locations_selected' => $locations_selected,
            'project' => $project,
            'rooms' => $rooms,
            'user_projects' => $user_projects,
        ]);
    }

    public function profile_update(Request $request)
    {
        $user = Auth::user();
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'phone' => ['required'],
        ]);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $user->first_name = $input['first_name'];
        $user->last_name = $input['last_name'];
        $user->phone = $input['phone'];
        $user->save();

        $log = new Log();
        $log->user_id = $user->id;
        $log->action_user_id = $user->id;
        $log->user_type = $user->role;
        $log->user_name = $user->first_name.' '.$user->last_name;
        $log->action = 'Profile update';
        $log->save();

        $request->session()->flash('success', 'Profile successfully updated');
        return back();
    }

    public function profile_password(Request $request)
    {
        $user = Auth::user();
        $input = $request->all();
        $validator = Validator::make($input, [
            'password' => ['required', 'string', new Password, 'confirmed'],
        ]);
        if($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        $user->password = Hash::make($input['password']);
        $user->save();

        $log = new Log();
        $log->user_id = $user->id;
        $log->action_user_id = $user->id;
        $log->user_type = $user->role;
        $log->user_name = $user->first_name.' '.$user->last_name;
        $log->action = 'Update password';
        $log->save();

        $request->session()->flash('success', 'Password successfully updated');
        return back();
    }

    public function profile_delete(Request $request)
    {
        $user = Auth::user();
        $user->locations()->detach();
        $user->projects()->detach();
        User::find($user->id)->delete();
        return Redirect::route('profile.deleted');
    }

    public function router(Request $request)
    {
        $user = Auth::user();
        if($user->role == 'Admin') {
            return redirect()->route('users');
        }
        elseif($user->role == 'User') {
            switch ($user->step_register) {
                case 'one':
                    return redirect()->route('step1.view');
                case 'two':
                    return redirect()->route('step2.view');
                case 'three':
                    return redirect()->route('step3.view');
                case 'four':
                    return redirect()->route('step4.view');
                case 'five':
                    return redirect()->route('projects');
                default:
                    return redirect()->route('profile');
            }
        }
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect('/');
    }

    public function deleted_profile()
    {
        return view('user.deleted',[
            'title' => 'Your profile was deleted',
        ]);
    }
}
