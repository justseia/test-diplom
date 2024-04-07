@extends('backend.layouts.default')

@section('page_title', 'Listing Teachers')

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
            border-radius: 15px
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

    @if(auth()->user()->can('manage_user'))
        <div class="container mt-4">
            <div class="row" style="background-color: white">
                <div class="col-md-4">
                    <div class="mt-4 mb-3">
                        <form method="GET" action="{{ route('search-user') }}">
                            <div class="input-group">
                                <input type="text" name="title" class="form-control bradius"
                                       placeholder="&#128269; Search"
                                       style="font-family: Arial, 'Font Awesome 5 Free';">
                            </div>
                            {{ csrf_field() }}
                        </form>
                    </div>

                    <div class="list-group scrollable-div" style="height: 900px;">
                        @foreach($users as $user)
                            <a href="javascript:void(0);"
                               class="list-group-item list-group-item-action{{ $loop->first ? ' active' : '' }} bradius mb-3 {{ $loop->first ? 'active-orange' : '' }}"
                               style="border-radius: 20px"
                               data-id="{{ $user->id }}" onclick="getUserInfo(this)">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">{{ $user->email }}</h5>
                                </div>
                                <h5 class="mb-1">{{ $user->name }}</h5>
                                <h5>{{ $user->medcoins }} MEDC</h5>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card ">
                        <div class="x_title mt-2">
                            <div class="row">
                                <div class="col-6"><h4>Teacher info</h4></div>
                                <div class="col-6 bradius">
                                    <a href="{{ route('teacher.create') }}" class="btn btn-success pull-right bradius">Add
                                        teacher</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body bradius" style="border: 2px solid black; margin: 15px">
                            <div class="row">
                                <div class="col-12 col-md-8">
                                    <form>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <label for="">Name:</label><span
                                                    class="form-control-plaintext spanStyle"
                                                    style="padding-left: 10px">{{   $selectedUser->name }}</span>
                                            </li>
                                            <li class="list-group-item">
                                                <label for="">Email:</label> <span
                                                    class="form-control-plaintext spanStyle"
                                                    style="padding-left: 10px">{{    $selectedUser->email }}</span>
                                            </li>
                                            <li class="list-group-item"><label for="">Quizzes count:</label> <span
                                                    class="form-control-plaintext spanStyle"
                                                    style="padding-left: 10px">{{ $selectedUser->medcoins }}</span></li>
                                            <li class="list-group-item"><label for="">Total passed students of quizzes:</label> <span
                                                    class="form-control-plaintext spanStyle"
                                                    style="padding-left: 10px">{{   $selectedUser->created_at->format('d.m.Y') }}</span>
                                            </li>
                                            <li class="list-group-item"><label for="">Average score of students per quiz:</label> <span
                                                    class="form-control-plaintext spanStyle"
                                                    style="padding-left: 10px">{{   $selectedUser->created_at->format('d.m.Y') }}</span>
                                            </li>
                                            <li class="list-group-item"><label for="">Public quizzes count:</label> <span
                                                    class="form-control-plaintext spanStyle"
                                                    style="padding-left: 10px">{{   $selectedUser->created_at->format('d.m.Y') }}</span>
                                            </li>
                                        </ul>
                                    </form>
                                </div>
                            </div>
                            <button type="button" style="background-color: red" class="btn btn-danger mt-2 spanStyle  pull-right">Block User</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        @include('errors.401')
    @endif
@stop
<script>
    function getUserInfo(element) {
        var userId = element.getAttribute('data-id'); // Get the user ID from data-id attribute

        // Make an AJAX call to your route
        $.ajax({
            url: '/user/getUser', // Adjust this URL to your route
            type: 'GET',
            data: {id: userId},
            success: function (response) {
                // Process the response here
                // Example: Display the user's detailed info in a modal or a specific div
                console.log(response); // Log response for debugging
            },
            error: function (xhr, status, error) {
                // Handle errors here
                console.error(error); // Log error for debugging
            }
        });
    }

</script>
