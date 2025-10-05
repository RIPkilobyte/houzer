@extends('app')
@section('content')

<div class="profile">

    <div class="row mt-5">

        <div class="col-lg-6 pr-lg-5">

            <h4 class="mb-4">Your profile</h4>

            <b>My contact details</b>
            <form action="{{ route('profile.update') }}" method="post">
                @csrf
                <div class="row form-row">
                    <div class="col-sm-6">
                        <label class="col-form-label">First name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="first_name" value="{{ $user->first_name }}">
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label">Last name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="last_name" value="{{ $user->last_name }}">
                    </div>
                </div>
                <div class="row form-row">
                    <div class="col-sm-6">
                        <label class="col-form-label">E-mail <span class="text-danger">*</span></label>
                        <input type="text" disabled="disabled" name="email" class="form-control" value="{{ $user->email }}">
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label">Phone <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="phone" value="{{ $user->phone }}">
                    </div>
                </div>
                <button type="submit" class="btn btn-blue px-5 mt-4">Save</button>
            </form>

            <hr class="my-4">

            {{-- Change password --}}
            <div class="profileItem">
                <a class="profileItem__title collapsed" data-toggle="collapse" href="#collapseProfilePwd" role="button" aria-expanded="false" aria-controls="collapseProfilePwd">
                    <div class="row align-items-center">
                        <div class="col-6"><h5 class="m-0">Change password</h5></div>
                        <div class="col-1"><div class="profileItem__plus"></div></div>
                        <div class="col-5 text-right"></div>
                    </div>
                </a>
                <div class="collapse profileItem__blue pt-sm-3" id="collapseProfilePwd">
                    <form action="{{ route('profile.password') }}" method="post">
                        @csrf
                        <div class="form-row">
                            <div class="col ">
                                <label class="col-form-label">New Password</label>
                            </div>
                            <div class="col ">
                                <label class="col-form-label">Re-enter</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col input-group">
                                <input type="password" name="password" id="password-input1" class="form-control" placeholder="8 characters min.">
                                <div class="input-group-append">
                                    <div class="input-group-text"><a href="#" class="pwdControl ctrl1"></a></div>
                                </div>
                            </div>
                            <div class="col input-group">

                                <input type="password" name="password_confirmation" id="password-input2" class="form-control">
                                <div class="input-group-append">
                                    <div class="input-group-text"><a href="#" class="pwdControl ctrl2"></a></div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mainButton px-5 mt-4">Change password</button>
                    </form>
                </div>
            </div>

        </div>

        <div class="col-lg-6">
            <p class="mb-4">Registration No. {{ $user->id }}</p>
            <b>Your housing needs</b>
            <!--
            <div class="row">
                <div class="col-7">Our current project:</div>
                <div class="col-5">
                    @if($user->project)
                        <a href="{{ $project->link }}" target="_blank">{{ $project->number }}</a>
                    @else
                        <i class="font-weight-light">You don't have a project</i>
                    @endif
                </div>
            </div>
            -->
            <div class="row">
                <div class="col-7">Are you currently a homeowner:</div>
                <div class="col-5">{{ $user->homeowner ? 'Yes':'No' }}</div>
            </div>
            <div class="row">
                <div class="col-7">What kind of home would you like:</div>
                <div class="col-5">
                    @if($user->house)
                        House
                        @if($user->apartments)
                         / Apartments
                        @endif
                    @elseif($user->apartments)
                        Apartments
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-7">A number of bedrooms required:</div>
                <div class="col-5">{{ implode(',', $rooms) }}</div>
            </div>
            <div class="row">
                <div>Where would you like to live:</div>
                <div>{{ implode(', ', $locations_selected) }}</div>
            </div>

            <div>Live projects that you are interested in:</div>
            @foreach($user_projects as $project)
                <a class="d-block" href="{{ $project->link }}" target="_blank">{{ $project->number }} / {{ $project->name }}</a>
            @endforeach
            <button type="button" onclick="gotostep(1)" class="btn btn-blue px-5 mt-3 mb-4">Update</button>
        </div>

    </div>

    <hr class="my-5">

    <!-- Delete profile -->
    <div class="row mt-4 mb-0 mb-lg-4">
        <div class="col-8 fs-14-mobile">
            Registration date: {{ date('d/m/Y', strtotime($user->created_at)) }}
        </div>
        <div class="col-4 text-right fs-16-mobile">
            <a data-toggle="collapse" href="#delete_profile" id="delete_profile_link" onclick="$('html, body').animate({scrollTop: $('#profileDelete').offset().top + 500 }, 1500); document.getElementById('delete_profile_link').removeAttribute('onclick');">Delete profile</a>
        </div>
        <div class="col-12">
            <div class="collapse" id="delete_profile">
                <div id="profileDelete" class="profileDelete mt-2">
                    <div class="profileDelete__img"></div>
                    <div class="mt-2 mb-2">Do you want to delete this profile?</div>
                    <a class='btn btn-primary' href='{{ route('profile.delete') }}'>Delete</a>
                    <a class='btn bg-white' data-toggle="collapse" href="#delete_profile">Cancel</a>
                </div>
            </div>
        </div>
    </div>

</div>
@push('scripts')
<script>
    function gotostep(id) {
        window.location.href = '/step'+id;
    }
    function gotoprojects() {
        window.location.href = '/projects?redirect=profile';
    }
</script>
@endpush
@endsection
