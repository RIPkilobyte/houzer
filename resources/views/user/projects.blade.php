@extends('app')
@section('content')

<div class="step1">
    <form class="mt-5" action="{{ route('projects.store') }}" method="post" autocomplete="off" id="projectsForm">
        @csrf
        <div class="row text-center text-sm-left">
            <div class="col-xl-8">
                <h1 class="mb-4">Our projects</h1>
                <p>If you are interested in some of our active projects that currently don’t accept new members, you might consider joining their waiting lists in case replacement opportunities arise. You can choose any number of projects. There are following projects that you can join their</p>

                @foreach($projects as $project)
                    <div class="ourProjects__item">
                        <div class="row align-items-center">
                            <div class="col-sm-2">
                                @php($checked = '')
                                @if(in_array($project->id, $projects_selected))
                                    @php($checked = "checked='checked'")
                                @endif
                                <input type="checkbox" name="joined[]" {{ $checked }} value="{{ $project->id }}" /> Joined
                            </div>
                            <div class="col-sm-10">
                                <div class="row align-items-center">
                                    <div class="col-sm-3 col-md-2">
                                        <span class="ourProjects__number">{{ $project->number }}</span>
                                    </div>
                                    <div class="col-sm-7 col-md-8 font-weight-bold">
                                        {{ $project->name }}
                                    </div>
                                    <div class="col-sm-2 text-sm-right text-danger font-weight-bold">
                                        @if($project->active)
                                            Active
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="pt-2 pb-1">{{ $project->description }}</div>
                                        <a href="{{ $project->link }}" target="_blank">See more detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <input type="hidden" name="skipped" id="skip_input" value="0" />
                @if(!$skip)
                    <button type="button" onclick="skipStep(1)" class="btn btn-blue btn-interest px-5">Skip</button>
                @endif
                <button type="submit" class="btn btn-orange btn-interest px-5">Confirm</button>
            </div>
        </div>
    </form>
</div>
@push('scripts')
<script>
    function skipStep(id) {
        var form = document.getElementById('projectsForm');
        var input = document.getElementById('skip_input');
        input.value = 1;
        form.submit();
    }
</script>
@endpush

@endsection
