@extends('app')
@section('content')

<form class="mt-5" action="{{ route('user.store') }}" method="post" autocomplete="off">
	@csrf
	<div class="row">
		<div class="col-xl-6">
            <h4 class="mb-4">Add user</h4>
            <div class="form-group row">
                <label for="first_name" class="col-sm-2 col-form-label">First name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="first_name" id="first_name" value="{{ old('first_name') }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="last_name" class="col-sm-2 col-form-label">Last name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="last_name" id="last_name" value="{{ old('last_name') }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="role" class="col-sm-2 col-form-label">Role</label>
                <div class="col-sm-10">
                    <select name="role" id="role" class="form-control">
                        <option value="User" @if(old('role') == 'User') selected='selected' @endif>User</option>
                        <option value="Admin" @if(old('role') == 'Admin') selected='selected' @endif>Admin</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="email" id="email" value="{{ old('email') }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone') }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" name="password" id="password">
                </div>
            </div>
            <div class="col-12 text-center mt-3 row">
                <button type="submit" class="btn btn-primary mainButton px-5 mt-3">Create user</button>
            </div>
		</div>
	</div>
</form>
@endsection
