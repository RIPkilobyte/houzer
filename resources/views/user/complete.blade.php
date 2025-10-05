@extends('app')
@section('content')

<div class="step1">
        <div class="row">
            <div class="col-xl-8">
                <h4 class="mb-4">You have completed your registration.</h4>
                <h4 class="mb-4">What happens next?</h4>
                <p>Your application will be reviewed by our Admin team.<br />
                We will let you know when we launch a suitable housing project in your chosen area.</p>

                <p>You can make any changes to your profile at any point.</p>

                <a href="{{ route('profile') }}" class="btn btn-blue btn-interest px-5">View profile</a>

            </div>
        </div>
</div>

@endsection
