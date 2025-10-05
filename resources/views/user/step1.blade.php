@extends('app')
@section('content')

<div class="step1">
    <form class="mt-5" action="{{ route('step1.store') }}" method="post" autocomplete="off">
        @csrf
        <h4 class="mt-5 mb-3">Are you currently a homeowner?</h4>
        @if($user->homeowner)
            <input type="radio" name="homeowner[]" id="homeownerY" value="1" checked="checked"> Yes
            &nbsp;&nbsp;&nbsp;
            <input type="radio" name="homeowner[]" id="homeownerN" value="0"> No
        @else
            <input type="radio" name="homeowner[]" id="homeownerY" value="1"> Yes
            &nbsp;&nbsp;&nbsp;
            <input type="radio" name="homeowner[]" id="homeownerN" value="0" checked="checked"> No
        @endif
{{--        <h4 class="mb-4">Where would you like to live?</h4>--}}
{{--        <p class="mb-4">Select the areas in which you would like to get your home. You may select multiple.</p>--}}

{{--        @foreach($locations as $location)--}}
{{--            <div class="form-group row">--}}
{{--                <div class="col-1">--}}
{{--                    @php($checked = '')--}}
{{--                    @if(in_array($location->id, $locations_selected))--}}
{{--                        @php($checked = "checked='checked'")--}}
{{--                    @endif--}}
{{--                    <input type="checkbox" class="form-control" name="locations[]" id="location{{ $location->id }}" value="{{$location->id}}" {{ $checked }}>--}}
{{--                </div>--}}
{{--                <label for="location{{ $location->id }}" class="col-sm-8 col-form-label">{{ $location->name }}</label>--}}
{{--            </div>--}}
{{--        @endforeach--}}
        <div>
            <button type="submit" class="btn btn-blue btn-interest px-5 my-5">Confirm</button>
        </div>

    </form>
</div>

@endsection
