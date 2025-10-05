@extends('app')
@section('content')

<div class="step1">
    <form class="mt-5" action="{{ route('step4.store') }}" method="post" autocomplete="off">
        @csrf
        <h4 class="mb-4">Where would you like to live?</h4>
        <p class="mb-4">Select the areas in which you would like to get your home. You may select multiple.</p>

        @foreach($locations as $location)
            <div class="form-group row">
                <div class="col-1">
                    @php($checked = '')
                    @if(in_array($location->id, $locations_selected))
                        @php($checked = "checked='checked'")
                    @endif
                    <input type="checkbox" class="form-control" name="locations[]" id="location{{ $location->id }}" value="{{$location->id}}" {{ $checked }}>
                </div>
                <label for="location{{ $location->id }}" class="col-sm-8 col-form-label">{{ $location->name }}</label>
            </div>
        @endforeach
        <div>
            <button type="submit" class="btn btn-blue btn-interest px-5 my-5">Confirm</button>
        </div>

    </form>
</div>

@endsection
