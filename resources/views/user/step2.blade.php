@extends('app')
@section('content')

<div class="step1">
    <form class="mt-5" action="{{ route('step2.store') }}" method="post" autocomplete="off">
        @csrf
        <h4 class="mb-3">What kind of home would you like?</h4>
        <p>You may select both options</p>
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

{{--        <h4 class="mt-5 mb-3">A number of bedrooms required?</h4>--}}
{{--        <p>You may select multiple</p>--}}
{{--        @php($checked_br = array(1 => '', 2 => '', 3 => '', 4 => ''))--}}
{{--        @if($user->bedrooms1)--}}
{{--            @php($checked_br[1] = 'checked')--}}
{{--        @endif--}}
{{--        @if($user->bedrooms2)--}}
{{--            @php($checked_br[2] = 'checked')--}}
{{--        @endif--}}
{{--        @if($user->bedrooms3)--}}
{{--            @php($checked_br[3] = 'checked')--}}
{{--        @endif--}}
{{--        @if($user->bedrooms4)--}}
{{--            @php($checked_br[4] = 'checked')--}}
{{--        @endif--}}
{{--        <input type="checkbox" name="bedrooms1" id="bedrooms1" value="1" {{ $checked_br[1] }}> 1&nbsp;&nbsp;--}}
{{--        <input type="checkbox" name="bedrooms2" id="bedrooms2" value="1" {{ $checked_br[2] }}> 2&nbsp;&nbsp;--}}
{{--        <input type="checkbox" name="bedrooms3" id="bedrooms3" value="1" {{ $checked_br[3] }}> 3&nbsp;&nbsp;--}}
{{--        <input type="checkbox" name="bedrooms4" id="bedrooms4" value="1" {{ $checked_br[4] }}> 4--}}


        <div>
            <button type="submit" class="btn btn-blue btn-interest px-5 my-5">Confirm</button>
        </div>

    </form>
</div>


@endsection
