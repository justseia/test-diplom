@extends('backend.layouts.default')

@section('page_title', 'Listing Users')

@section('style')
    <style>
        .active-orange {
            background-color: orange !important;
            color: white !important;
        }

        .default-state {
            color: #3dbdf1;
            background-color: white;
        }

        .spanStyle {
            background-color: #3dbdf1;
            color: white;
            border-radius: 15px
        }

        .bradius {
            border-radius: 15px
        }

        label {
            font-size: 25px;
            margin-top: 15px;
        }

        /* For WebKit browsers like Chrome, Safari, and Edge */
        .scrollable-div::-webkit-scrollbar {
            width: 13px; /* Adjust the width of the scrollbar */
        }

        .scrollable-div::-webkit-scrollbar-thumb {
            background-color: lightblue; /* Your desired color for the scrollbar thumb */
            border-radius: 5px; /* Optional: adds rounded corners to the scrollbar thumb */
        }
        /* Always show vertical scrollbar and ensure it's visible even if content doesn't overflow */
        .scrollable-div {
            overflow-y: scroll;
            padding-right: 10px; /* Should be equal to or greater than the right padding of list-group-item for consistent alignment */
        }

        input[type="text"]::placeholder {
            color: #3dbdf1; /* Change to your desired color */
            font-family: Arial, 'Font Awesome 5 Free'; /* Ensure the icon font is applied */
        }
    </style>
@stop
@section('content')
    @if(auth()->user()->can('manage_user'))
        <div class="container mt-4">
            <div class="row">
                <div class="col-6">
                    <h3>Education</h3>
                </div>
                <div class="col-6 bradius">
                    <a href="{{ route('education.create') }}"
                       class="btn btn-success pull-right bradius">Create topic</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 card card-body bradius" style="height: 900px">
                    <div class="mt-4 mb-3">
                        <form method="GET" action="{{ route('search-education') }}">
                            <div class="input-group">
                                <input type="text" name="title" class="form-control bradius"
                                       placeholder="&#128269; Search"
                                       style="font-family: Arial, 'Font Awesome 5 Free';">
                            </div>
                            {{ csrf_field() }}
                        </form>
                    </div>
                    @if($educations->isEmpty())
                        <p>No education records found.</p>
                    @else
                        <div class="list-group scrollable-div" style="height: 900px;">
                            @foreach($educations as $education)
                                <a href="{{ route('education.index', ['id' => $education->id]) }}"
                                   class="list-group-item list-group-item-action bradius mb-3 {{ $education->id === $selectedEducation->id ? 'active-orange' : 'default-state' }}"
                                   style="border-radius: 20px"
                                   data-id="{{ $education->id }}">
                                    <div class="row">
                                        <div class="col-9">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h5 class="mb-1">{{ $education->title }}</h5>
                                            </div>
                                            <h5 class="mb-1">{{ $education->questions_count ?? '' }} questions</h5>
                                        </div>
                                        <div class="col-3">
                                            <i class='fa fa-angle-right mt-2 bradius {{ $education->id === $selectedEducation->id ? 'active-icon' : 'default-icon' }}'
                                               style='font-size:36px; border: 1px solid black; width: 40px; height: 40px; display: flex;
           align-items: center; justify-content: center;'></i>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="col-md-8">
                    <div class="card bradius" style="height: 900px;">
                        <div class="mt-2">
                            <div class="row m-2">
                                <div class="col-6"><h4>Education info</h4></div>
                            </div>
                        </div>
                        @if(!is_null($selectedEducation))
                            <div class="card-body bradius" style="border: 2px solid black; margin: 15px; padding-left: 30px">
                                <div class="row">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control spanStyle" id="title"
                                           placeholder="Enter title"
                                           value="{{ $selectedEducation->title ?? ''}}">
                                    <label for="created_at">Created At</label>
                                    <input type="datetime-local" class="form-control spanStyle"
                                           id="created_at"
                                           placeholder="Enter age"
                                           value="{{ $selectedEducation->created_at ?? '' }}">
                                </div>
                                <div class="row">
                                    <div class="col-3 mt-4">
                                        <h5>Questions: {{$selectedEducation->questions_count ?? 0 }}</h5>
                                    </div>
                                    <div class="col-9">
                                        <div class="d-flex flex-column align-items-end gap-2 mt-4">
                                            <a href="{{ route('education.edit', $selectedEducation->id) }}" class="btn spanStyle bradius" type="button">To question list <i
                                                        class="fa fa-solid fa-arrow-right"></i></a>
                                            <a href="{{ route('education.info', ['id' => $selectedEducation->id]) }}"
                                               class="btn spanStyle bradius" type="button">To information of topic <i
                                                        class=" fa fa-solid fa-arrow-right"></i></a>
                                            <a href="{{ route('education.diseases', ['id' => $selectedEducation->id]) }}"
                                               class="btn spanStyle bradius" type="button">To
                                                diseases of topic <i
                                                        class=" fa fa-solid fa-arrow-right"></i></a>
                                            <a href="" class="btn btn-danger bradius" type="button">Delete topic</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    @else
        @include('errors.401')
    @endif
@stop
<script>
    function updateActiveRow(userId) {
        // Remove active-orange from all elements
        document.querySelectorAll('.list-group-item').forEach(function (item) {
            item.classList.remove('active-orange');
            item.classList.add('default-state');
        });

        // Find the new selected element and add active-orange
        let selectedElement = document.querySelector(`a[data-id="${userId}"]`);
        if (selectedElement) {
            selectedElement.classList.add('active-orange');
        }
    }
</script>
