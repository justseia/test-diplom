@extends('backend.layouts.default')

@section('page_title', 'Listing Users')

@section('style')
    <style>
        .active-orange {
            background-color: orange !important;
            color: white;
        }

        .spanStyle {
            background-color: #3dbdf1;
            color: white;
            border-radius: 15px
        }

        .bradius {
            border-radius: 10px
        }

        label {
            font-size: 25px;
        }

        /* For WebKit browsers like Chrome, Safari, and Edge */
        .scrollable-div::-webkit-scrollbar {
            width: 13px; /* Adjust the width of the scrollbar */
        }

        .scrollable-div::-webkit-scrollbar-thumb {
            background-color: lightblue; /* Your desired color for the scrollbar thumb */
            border-radius: 5px; /* Optional: adds rounded corners to the scrollbar thumb */
        }

        /* For Firefox */
        .scrollable-div {
            scrollbar-color: lightblue #e0e0e0; /* thumb and track color */
        }

        /* Always show vertical scrollbar and ensure it's visible even if content doesn't overflow */
        .scrollable-div {
            overflow-y: scroll;
        }

        input[type="text"]::placeholder {
            color: #3dbdf1; /* Change to your desired color */
            font-family: Arial, 'Font Awesome 5 Free'; /* Ensure the icon font is applied */
        }

    </style>
@stop

@section('content')

    @if(auth()->user()->can('manage_quiz'))
        <div class="container mt-4">
            <div class="row" style="background-color: white">
                <div class="col-md-4">
                    <div class="mt-4 mb-3">
                        <form method="GET" action="{{ route('search-user') }}">
                            <div class="input-group">
                                <input type="text" class="form-control bradius" placeholder="&#128269; Search"
                                       style="font-family: Arial, 'Font Awesome 5 Free';">
                            </div>
                            {{ csrf_field() }}
                        </form>
                    </div>
                    @if($quizzes->isEmpty())
                        <p>No quizzes records found.</p>
                    @else
                        <div>
                            <div class="list-group scrollable-div" style="height: 900px;">
                                @foreach($quizzes as $quiz)
                                    <a href="javascript:void(0);"
                                       class="list-group-item list-group-item-action{{ $loop->first ? ' active' : '' }} bradius mb-3 {{ $loop->first ? 'active-orange' : '' }}"
                                       style="border-radius: 20px">
                                        <div class="row">
                                            <div class="col-9">
                                                <h5 class="mb-1">{{ $quiz->title ? $quiz->title : '' }}</h5>
                                                <h5>by {{$quiz->creator->name ?? ''}}</h5>
                                                <h5>{{$quiz->questions_count ?? ''}} questions</h5>
                                                <h5>{{$quiz->participants_count ?? ''}} participants</h5>
                                            </div>
                                            <div class="col-3">
                                                <i class='fas fa-caret-square-right mt-5' style='font-size:36px'></i>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="x_title mt-2">
                            <div class="row">
                                <div class="col-6"><h4>Quiz info</h4></div>
                                <div class="col-6 bradius">
                                    <a href="{{ route('quiz.create') }}"
                                       class="btn btn-success pull-right bradius">Create quiz</a>
                                </div>
                            </div>
                        </div>
                        @if(!is_null($selectedquiz))
                            <div class="card-body bradius" style="border: 2px solid black; margin: 15px">
                                <div class="row">
                                    <div class="col-md-3">
                                        <img
                                                src="{{ !empty($selectedquiz->image_url) ? asset('storage/' . $selectedquiz->image_url) : 'https://via.placeholder.com/150' }}"
                                                alt="Quiz Avatar" class="img-thumbnail  mx-auto d-block">
                                    </div>
                                    <div class="col-md-9">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control spanStyle" id="name"
                                               placeholder="Enter name"
                                               value="{{ $selectedquiz->title ?? ''}}">
                                        <label for="author">Author</label>
                                        <input type="text" class="form-control spanStyle" id="author"
                                               placeholder="Enter author"
                                               value="{{ $selectedquiz->creator->name . ' '. $selectedquiz->creator->email ?? ''}}">
                                        <label for="created_at">Created At</label>
                                        <input type="datetime-local" class="form-control spanStyle"
                                               id="created_at"
                                               placeholder="Enter age"
                                               value="{{ $selectedquiz->created_at ?? '' }}">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <div class="spanStyle text-white p-3 mb-3">
                                            Participants count
                                            <h3>100</h3>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="spanStyle text-white p-3">
                                            Average score of participants
                                            <h3>77%</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="spanStyle text-white p-3 mb-3">
                                            The champion of quiz
                                            <h3>Armanov Arman, armanov.a@gmail.com</h3>
                                            <h5>100% 12.03.2024</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        @if($selectedquiz->is_private == 0)
                                            <div class="input-group mb-3">
                                                <span class="spanStyle input-group-text">Public quiz</span>
                                            </div>
                                        @else
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">Private quiz</span>
                                                <input type="text" class="form-control" placeholder="XXXXXXXX">
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        <div class="row float-right">
                                            <div>
                                                @if($quiz->is_active == 1)
                                                    <form action="{{ route('quiz.inactivate') }}" method="POST"
                                                          onsubmit="return confirm('Inactivate this quiz?');">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="id" value="{{ $quiz->id }}"/>
                                                        <input type="hidden" name="_method" value="post"/>
                                                        <button type="submit" name="Inactive_quiz"
                                                                class="btn btn-sm btn-success bradius">Active quiz
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('quiz.activate') }}" method="POST"
                                                          onsubmit="return confirm('Activate this quiz?');">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="id" value="{{ $quiz->id }}"/>
                                                        <input type="hidden" name="_method" value="post"/>
                                                        <button type="submit" name="Inactive_quiz"
                                                                class="btn btn-sm btn-danger bradius">Inactive quiz
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                            <div>
                                                <form action="{{ route('quiz.destroy') }}" method="POST"
                                                      onsubmit="return confirm('Delete this record?');">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="id" value="{{ $quiz->id }}"/>
                                                    <input type="hidden" name="_method" value="DELETE"/>
                                                    <button type="submit" name="Delete"
                                                            class="btn btn-sm btn-danger bradius">Delete
                                                        quiz
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <span>Questions: {{$selectedquiz->questions_count}}</span>
                                    </div>
                                </div>

                                <a href="{{ route('quiz.edit', $quiz->id) }}"
                                   class="btn mt-2 spanStyle  pull-right btn-sm btn-success">To question list →</a>
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
