@extends('backend.layouts.default')

@section('page_title', 'Create User')

@section('style')
@stop

@section('content')

    @if( ! Auth::user()->can('manage_user'))
        @include('errors.401')
    @else
        <div class="x_panel">
            <div class="x_title">
                <h2>Create Teacher</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                @include('backend.partials.error')

                <form method="POST" action="{{ route('teacher.store') }}" class="" enctype="multipart/form-data">
                    <div class="row input_row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Name <span class="required">*</span></label> <br>
                                <input type="text" name="name" required="required" placeholder="Name"
                                       class="form-control bradius col-md-8 col-xs-12">
                            </div>
                        </div>
                    </div>
                    <div class="row input_row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Email <span class="required">*</span></label> <br>
                                <input type="email" name="email" required="required" placeholder="Email"
                                       class="form-control bradius col-md-8 col-xs-12">
                            </div>
                        </div>
                    </div>
                    <div class="row input_row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Password <span
                                        class="required">*</span></label> <br>
                                    <input type="password" name="password" required="required" placeholder="Password"
                                           class="form-control bradius col-md-8 col-xs-12">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row input_row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2">
                                    {{ csrf_field() }}
                                    <a href="{{ route('user.getTeachers') }}" class="btn btn-default bradius">Cancel</a>
                                    <button type="submit" class="btn btn-success bradius pull-right">save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    @endif

@stop
