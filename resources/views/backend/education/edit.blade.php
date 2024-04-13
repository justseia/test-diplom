@extends('backend.layouts.default')

@section('page_title', 'Manage Education')

@section('style')
    <style>
        /* Custom styles to make text inputs look like buttons */
        .btn-input {
            padding: .375rem .75rem; /* Same padding as Bootstrap buttons */
            border: 1px solid transparent; /* Hide the default border */
            border-radius: .25rem; /* Same border-radius as Bootstrap buttons */
            color: #fff; /* Text color */
            display: inline-block; /* To flow like buttons */
            text-align: center; /* Center the text */
            vertical-align: middle; /* Align with other inline elements */
            cursor: pointer; /* Pointer cursor like buttons */
        }

        /* You may need to adjust the height to align with other buttons */
        .btn-input[type="text"] {
            height: 38px; /* Example height, adjust as needed */
        }

        /* Hover effect */
        .btn-input:hover {
            filter: brightness(95%); /* Slightly darken the button on hover */
        }

        .custom-success {
            background-color: #2fa360;
            color: #ffffff;
            border: 1px solid black;
        }

        .custom-light {
            background-color: #ffffff;
            color: #1b1e21;
            border: 1px solid black;
        }
    </style>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-8">
                    <div class="d-flex justify-content-start align-items-center">
                        <a href="{{ route('education.index', ['id' => $education->id]) }}" class="text-secondary mr-2">
                            <i class="fa fa-solid fa-arrow-left"></i>
                        </a>
                        <h2 class="h4"> {{ $education->title }} : </h2>
                        <span style="font-size: 25px; margin-left: 5px"> questions: {{$questions->count()}}</span>

                    </div>
                </div>
                <div class="col-4"><a href="{{ route('education.create.question',['id'=>0, 'education_id' => $education->id]) }}"
                                      class="btn btn-success pull-right bradius">Add question</a></div>
            </div>
        </div>
    </div>
    <hr>
    <div class="card">
        @include('backend.partials.error')
        @foreach ($questions as $key => $question)
            <div class="card card-body">
                <div class="row input_row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-md-10 col-sm-10 col-xs-10">
                                <h2 style="font-weight: bold">{{$key+1}}. {{ $question->question }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-10">
                        @foreach ($question->options as $key => $option)
                            <input type="text"
                                   readonly
                                   name="questions[{{ $question->id }}]"
                                   id="question_{{ $question->id }}_option_{{ $key }}"
                                   value="{{ $option->option }}"
                                   class="btn-input {{ $option->is_right_option ? 'custom-success' : 'custom-light' }}">

                        @endforeach
                    </div>
                    <div class="col-2">
                        <div class="row">
                            <div class="col-4">
                                <a href="{{ route('education.create.question',['id'=>$question->id, 'education_id' => $education->id]) }}"
                                   class="btn btn-info bradius border-0">
                                    <i class='fas fa-pen' style='font-size:22px; color: black'></i>
                                </a>
                            </div>
                            <div class="col-4">
                                <form action="{{ route('education.delete.question') }}" method="POST"
                                      onsubmit="return confirm('Delete this record?');">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id" value="{{ $question->id }}"/>
                                    <input type="hidden" name="educationID" value="{{ $education->id }}"/>
                                    <input type="hidden" name="_method" value="DELETE"/>
                                    <button class="btn btn-danger bradius border-0">
                                        <i class='fas fa-trash' style='font-size:22px; color: white'></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        @endforeach
    </div>

@stop
