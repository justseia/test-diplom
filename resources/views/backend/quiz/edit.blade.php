@extends('backend.layouts.default')

@section('page_title', 'Manage Quiz')

@section('style')
    <style>

    </style>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Quiz Name:<strong> {{ $quiz->title }}</strong></h2>
                </div>
                <div class="x_content">
                    @include('backend.partials.error')
                    @if($type == 'choice')
                        @include('backend.partials.choice')
                    @endif
                    <h2><strong>Questions</strong></h2>
                    <hr>
                    @foreach ($questions as $question)

                        <div class="row input_row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-2 col-sm-2 col-xs-12">Questions </label>
                                    <div class="col-md-10 col-sm-10 col-xs-10">
                                        {{ $question->question }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row input_row">
                            <div class="col-md-12">
                                <div class='form-group'>
                                    <label class="control-label col-md-2 col-sm-2 col-xs-12">Options </label>
                                    <div class="col-md-10 col-sm-10 col-xs-12">
                                        <div class="radio">
                                            <label>
                                                @foreach ($question->options as $key => $option)
                                                    <input type="radio" value="{{ $key }}"
                                                           @if($option->is_right_option == 1) checked="checked"
                                                           @endif name="answer"> {{ $option->option }}  &nbsp; &nbsp;
                                                @endforeach
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@stop
