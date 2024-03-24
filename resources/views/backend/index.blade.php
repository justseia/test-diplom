@extends('backend.layouts.default')

@section('page_title', 'Dashboard')

@section('style')

@stop

@section('content')

<div class="page-title">
    <div class="title_left">
        <h3>Dashboard</h3>
    </div>
    <div class="title_right">
        <div class="col-md-5 col-sm-5   form-group pull-right top_search">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button">Go!</button>
                </span>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="container mt-4">
    <h1>Dashboard</h1>
    <div class="row">
        <!-- Total Users Card -->
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h2 class="card-title">Total users</h2>
                    <p class="card-text display-4">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
        <!-- Total Quizzes Card -->
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h2 class="card-title">Total quizzes</h2>
                    <p class="card-text display-4">{{ $totalQuizzes }}</p>
                </div>
            </div>
        </div>

    </div>

    <div class="mt-5">
        <h2>Monthly report</h2>
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ $selectedMonth }}
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <!-- Dynamic month selection -->
                @foreach($months as $month)
                    <a class="dropdown-item" href="#">{{ $month }}</a>
                @endforeach
            </div>
        </div>

        <div class="mt-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-around">
                        <div>
                            <i class="fa fa-user-plus fa-2x"></i>
                            <p>New users</p>
                            <h3>{{ $newUsers }}</h3>
                        </div>
                        <div>
                            <i class="fa fa-file-alt fa-2x"></i>
                            <p>New quizzes</p>
                            <h3>{{ $newQuizzes }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Quiz Participants</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                @foreach ($questionAnswers as $questions)

                    <div class="row input_row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Answer By </label>
                                <div class="col-md-10 col-sm-10 col-xs-10">
                                    {{ $questions->email }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row input_row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Question </label>
                                <div class="col-md-10 col-sm-10 col-xs-10">
                                    {{ $questions->questions->question }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row input_row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">User Answer </label>
                                <div class="col-md-10 col-sm-10 col-xs-10">
                                    <?php //echo '<pre>'; var_dump($questions->questions->options) ?>
                                        @foreach($questions->questions->options as $opt)
                                            @php
                                                // echo '<pre>';
                                                // var_dump($opt->option);
                                            @endphp
                                            {{-- {{ $opt->option }} --}}
                                            @if ($questions->option_id == $opt->id)
                                                {{ $opt->option }},
                                            @endif
                                        @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row input_row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Right Answer </label>
                                <div class="col-md-10 col-sm-10 col-xs-10">
                                    @foreach($questions->questions->options as $opt)
                                        @php
                                            // echo '<pre>';
                                            // var_dump($opt->is_right_option);
                                        @endphp
                                        @if ($opt->is_right_option == 1)
                                            {{ $opt->option }}
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row input_row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Right Answer </label>
                                <div class="col-md-10 col-sm-10 col-xs-10">
                                    @if($questions->is_right == 1)
                                        <button class="btn btn-sm btn-success">Correct</button>
                                    @else
                                        <button class="btn btn-sm btn-danger">Wrong</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                @endforeach


                <div class="table-responsive">
                    <div>Showing
                        {{ ($questionAnswers->currentpage()-1) * $questionAnswers->perpage()+1}} to
                        {{(($questionAnswers->currentpage()-1) * $questionAnswers->perpage())+$questionAnswers->count()}} of
                        {{$questionAnswers->total()}} records
                    </div>

                    {{ $questionAnswers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('script')

@stop
