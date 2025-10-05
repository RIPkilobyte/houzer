@extends('app')
@section('content')

<h1 class="title mt-5">Project Manager</h1>
<form class="mt-5" action="{{ route('project.store') }}" method="post" autocomplete="off">
	@csrf
	<div class="row">
		<div class="col-xl-6">
            <h4 class="mb-4">Add project</h4>
            <div class="form-group row">
                <label for="number" class="col-sm-3 col-form-label">Number:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="number" id="number" value="{{ old('number') }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label">Name:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="description" class="col-sm-3 col-form-label">Description:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="description" id="description" value="{{ old('description') }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="link" class="col-sm-3 col-form-label">Link:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="link" id="link" value="{{ old('link') }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="active" class="col-sm-3 col-form-label">Active:</label>
                <div class="col-sm-9">
                    <input type="checkbox" class="form-control" name="active" id="active" value="1">
                </div>
            </div>
            <div class="col-12 text-center mt-3 row">
                <button type="submit" class="btn btn-blue px-5 mt-3">Add project</button>
            </div>
		</div>
	</div>
</form>

<hr class="my-5">

<h4 class="mb-3">Project list</h4>
<p class="text-danger">Attention! Everybody sees all projects below. But active projects can be current ones.</p>

@foreach($projects as $project)
    <form method="post" action="{{ route('project.update', $project->id) }}" autocomplete="off" id="form{{ $project->id }}">
        @csrf

        <div class="row mb-2">
            <div class="col-1">
                @if($project->active)
                    <input type="checkbox" name="active" value="1" checked="checked" value="1"> Active
                @else
                    <input type="checkbox" name="active" value="1" value="1"> Active
                @endif
            </div>
            <div class="col-xl-1">
                <input class="w-100" type="text" name="number" value="{{ $project->number }}">
            </div>
            <div class="col-xl-2">
                <input class="w-100" type="text" name="name" value="{{ $project->name }}">
            </div>
            <div class="col-xl-3">
                <input class="w-100" type="text" name="description" value="{{ $project->description }}">
            </div>
            <div class="col-xl-3">
                <input class="w-100" type="text" name="link" value="{{ $project->link }}">
            </div>
            <div class="col-xl-1">
                <button type="submit" onclick="submit_form({{ $project->id }})" class="btn btn-blue">Update</button>
            </div>
            <div class="col-xl-1">
                <button type="button" onclick="delete_project({{ $project->id }})" class="btn btn-danger">Delete</button>
            </div>
        </div>

        <? /*
        <table>
            <tr>
                <td><input type="text" name="number" size="7" value="{{ $project->number }}"></td>
                <td><input type="text" name="name" value="{{ $project->name }}"></td>
                <td><input type="text" name="description" value="{{ $project->description }}"></td>
                <td><input type="text" name="link" value="{{ $project->link }}"></td>
                @if($project->active)
                    <td><input type="checkbox" name="active" value="1" checked="checked" value="1"> Active</td>
                @else
                    <td><input type="checkbox" name="active" value="1" value="1"> Active</td>
                @endif
                <td><button type="submit" onclick="submit_form({{ $project->id }})" class="btn btn-blue">Update</button></td>
                <td><button type="button" onclick="delete_project({{ $project->id }})" class="btn btn-danger">Delete</button></td>
            </tr>
        </table>
        */ ?>
    </form>
@endforeach

<div class="my-5">  </div>

@push('scripts')
<script>
    function submit_form(id) {
        $('#form'+id).attr('action', '/manager/edit/'+id);
        $('#form'+id).submit();
    }
    function delete_project(id) {
        if(confirm("Are you sure to delete this project?")) {
            $('#form'+id).attr('action', '/manager/delete/'+id);
            $('#form'+id).submit();
        }
    }
</script>
@endpush
@endsection
