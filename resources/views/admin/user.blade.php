@extends('app')
@section('content')
<div class="row mt-5">

    <div class="col-lg-6 pr-lg-5">

        <form class="form-horizontal" action="{{ route('user.update', $user->id) }}" method="post" autocomplete="off">
            @csrf
            <input type="hidden" name="role" value="{{ $user->role }}">

            <div class="mt-1 mb-3">
                <span class="pr-sm-5">User Number: {{ $user->id }}</span>
                @if($user->attention)
                    <a onclick="return confirm('Are you sure to deactivate attention?')" href="{{ route('activate.attention', [$user->id]) }}"><i class="fas fa-exclamation-circle fa-lg text-red"></i></a>
                @else
                    <a onclick="return confirm('Are you sure to activate attention?')" href="{{ route('activate.attention', [$user->id]) }}"><i class="fas fa-exclamation-circle fa-lg text-muted"></i></a>
                @endif
            </div>

            <h4 class="mt-4 mb-3">Contact details</h4>

            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label">First name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="first_name" id="name" value="{{ $user->first_name }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label">Last name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="last_name" id="name" value="{{ $user->last_name }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="email" id="email" value="{{ $user->email }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="phone" class="col-sm-3 col-form-label">Phone</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="phone" id="phone" value="{{ $user->phone }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="new_password" class="col-sm-3 col-form-label text-danger">Set pwd</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" name="password" id="new_password">
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-blue mt-3 mb-4 px-5">Update</button>
                </div>
            </div>

        </form>

        <h4 class="mt-4 mb-3">Notes</h4>

        <form class="form" id="form_notes" action="{{ route('user.update.notes', $user->id) }}" method="post" autocomplete="off">
            @csrf
            <div class="form-group row">
                <div class="col-sm-12">
                    <textarea class="form-control w-100" name="notes" id="notes" rows="7" placeholder="Internal notes">{{ $user->notes }}</textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-blue mt-3 px-5">Update</button>
        </form>

    </div>

    <div class="col-lg-6">
        <form class="form-horizontal" action="{{ route('user.update.other', $user->id) }}" method="post" autocomplete="off">
            @csrf
        Registration date: {{ date('d/m/Y', strtotime($user->created_at)) }}

        <h4 class="mt-4 mb-3">Areas to live</h4>
        <div class="location mb-4">
            <div class="mb-2 pl-3">
                <a href="#" onclick="jQuery('.location input').prop('checked', true); return false;">Select All</a>
            </div>
            @foreach($locations as $location)
                <div class="location__item">
                    <div class="form-check location__formcheck">
                        @php($checked = '')
                        @if(in_array($location->id, $locations_selected))
                            @php($checked = "checked='checked'")
                        @endif
                        <label class="location__label">
                            <input class="form-check-input" type="checkbox" name="locations[]" {{ $checked }} id="location{{ $location->id }}" value="{{ $location->id }}">
                            <span>{{ $location->name }}</span>
                        </label>
                    </div>
                </div>
            @endforeach
        </div>

        <h4 class="mt-4 mb-3">Future Home</h4>
        <div class="">

            <div class="form-group row">
                <div class="col-sm-7">Current project</div>
                <div class="col-sm-5">
                    <select class="w-100" name="project" id="project">
                        <option value="0">None</option>
                        @foreach($active_projects as $project)
                            @php($checked = '')
                            @if($user->project == $project->id)
                                @php($checked = "selected='selected'")
                            @endif
                            <option value="{{ $project->id }}" @if(old('project') == $project->id) selected='selected' @endif {{ $checked }}>{{ $project->number }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-7">What kind of home would you like?</div>
                <div class="col-sm-5">
                    @if($user->house)
                        <input type="checkbox" name="home[house]" id="house" value="1" checked="checked"> House
                    @else
                        <input type="checkbox" name="home[house]" id="house" value="1"> House
                    @endif
                    &nbsp;&nbsp;&nbsp;
                    @if($user->apartments)
                        <input type="checkbox" name="home[apartments]" id="apartments" value="1" checked="checked"> Apartments
                    @else
                        <input type="checkbox" name="home[apartments]" id="apartments" value="1"> Apartments
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-7">A number of bedrooms required?</div>
                <div class="col-sm-5">
                    @php($checked_br = array(1 => '', 2 => '', 3 => '', 4 => ''))
                    @if($user->bedrooms1)
                        @php($checked_br[1] = 'checked')
                    @endif
                    @if($user->bedrooms2)
                        @php($checked_br[2] = 'checked')
                    @endif
                    @if($user->bedrooms3)
                        @php($checked_br[3] = 'checked')
                    @endif
                    @if($user->bedrooms4)
                        @php($checked_br[4] = 'checked')
                    @endif
                    <input type="checkbox" name="bedrooms1" id="bedrooms1" value="1" {{ $checked_br[1] }}> 1
                    <input type="checkbox" name="bedrooms2" id="bedrooms2" value="1" {{ $checked_br[2] }}> 2
                    <input type="checkbox" name="bedrooms3" id="bedrooms3" value="1" {{ $checked_br[3] }}> 3
                    <input type="checkbox" name="bedrooms4" id="bedrooms4" value="1" {{ $checked_br[4] }}> 4
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-7">Are you currently a homeowner?</div>
                <div class="col-sm-5">
                    @if($user->homeowner)
                        <input type="radio" name="homeowner[]" id="homeownerY" value="1" checked="checked"> Yes
                    @else
                        <input type="radio" name="homeowner[]" id="homeownerY" value="1"> Yes
                    @endif
                    &nbsp;&nbsp;&nbsp;
                    @if($user->homeowner)
                        <input type="radio" name="homeowner[]" id="homeownerN" value="0"> No
                    @else
                        <input type="radio" name="homeowner[]" id="homeownerN" value="0" checked="checked"> No
                    @endif
                </div>
            </div>

        </div>

        <h4 class="mt-4 mb-3">Waiting lists</h4>
                <div class="">
                    @foreach($projects as $project)
                        <div class="row">
                            <div class="col-2">
                                @php($checked = '')
                                @if(in_array($project->id, $projects_selected))
                                    @php($checked = "checked='checked'")
                                @endif
                                <input type="checkbox" name="joined[]" {{ $checked }} value="{{ $project->id }}" />
                            </div>
                            <div class="col-2">
                                {{ $project->number }}
                            </div>
                            <div class="col-8">
                                <a href="{{ $project->link }}" target="_blank">{{ $project->name }}</a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-blue mt-3 mb-4 px-5">Update</button>
        </form>

    </div>

</div>

<hr class="col-xs-12 mb-4">

<div class="row mb-3">
    <div class="col-6">
        <a data-toggle="collapse" href="#collapse_logs"><h4>Logs</h4></a>
    </div>
    <div class="col-6 text-right">
        @if(Auth::user()->role == 'Admin')
            <a class="text-danger" onclick="return confirm('Are you sure to delete this user?')" href="{{ route('user.delete', [$user->id]) }}">Delete user</a>
        @endif
    </div>
</div>

<div class="" id="collapse_logs">
		<table id="table1" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>Log ID</th>
					<th>User ID</th>
					<th>User type</th>
					<th>User name</th>
					<th>Action</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody>
				@if($logs)
					@foreach($logs as $log)
						<tr>
							<td>{{ $log->id }}</td>
							<td>{{ $log->action_user_id }}</td>
							<td>{{ $log->user_type }}</td>
							<td>{{ $log->username }}</td>
							<td>{{ $log->action }}</td>
							<td>{{ $log->date }}</td>
						</tr>
					@endforeach
				@endif
			</tbody>
			<tfoot>
				<tr>
					<th>Log ID</th>
					<th>User ID</th>
					<th>User type</th>
					<th>User name</th>
					<th>Action</th>
					<th>Date</th>
				</tr>
			</tfoot>
		</table>
</div>
@push('scripts')
<script src="/js/jquery.dataTables.js"></script>
<script src="/js/dataTables.bootstrap4.js"></script>
<script src="/js/dataTables.responsive.js"></script>
<script src="/js/responsive.bootstrap4.js"></script>
<script src="/js/dataTables.buttons.js"></script>
<script src="/js/buttons.bootstrap4.js"></script>
<script src="/js/jszip.js"></script>
<script src="/js/pdfmake.js"></script>
<script src="/js/vfs_fonts.js"></script>
<script src="/js/buttons.html5.js"></script>
<script src="/js/buttons.print.js"></script>
<script src="/js/buttons.colVis.js"></script>
<script type="text/javascript">
$().ready(function(){
    $("#table1").DataTable({
        serverSide: false,
        responsive: true,
        autoWidth: false,
        "order": [[ 0, "desc" ]]
    });
    setTimeout(function(){ $("#collapse_logs").addClass('collapse'); }, 100);
});
</script>
@endpush
@endsection
