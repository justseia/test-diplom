<div class="left_col scroll-view">
    <div>
        <div class="navbar" style="border: 0;">
            <a href="{{ route('dashboard') }}" class="site_title">
                <img src="{{asset('images/body_genuis.png')}}" alt="" width="200px" height="100px">
            </a>
        </div>

        <div class="navbar" style="margin-left: 20%; border: 0;">
            <span style="font-size: x-large">{{ env('APP_NAME')}}</span>
        </div>
    </div>
    <div class="clearfix"></div>
    <br/>
    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
            <ul class="nav side-menu" style="color: #1d2124">

                <li><a href="{{ route('dashboard') }}"><i class="fa fa-home"></i> Dashboard </a></li>
               {{-- @if( Auth::user()->can('manage_role'))
                    <li><a href="{{ route('role.index') }}"><i class="fa fa-edit"></i> Manage Role </a></li>
                @endif--}}

                @if( Auth::user()->can('manage_user'))
{{--                    <li><a href="{{ route('user.index') }}"><i class="fa fa-user"></i> All User </a></li>--}}
                    <li><a href="{{ route('user.getUsers') }}"><i class="fa fa-user-circle"></i> User List </a></li>

{{--                    <li><a><i class="fa fa-edit"></i> User Management <span class="fa fa-chevron-down"></span></a>--}}
{{--                        <ul class="nav child_menu">--}}
{{--                            <li><a href="{{ route('user.index') }}">All Users</a></li>--}}
{{--                            <li><a href="{{ route('user.create') }}">Register User</a></li>--}}
{{--                        </ul>--}}
{{--                    </li>--}}
                @endif

                <li><a href="{{ route('quiz.index') }}"><i class="fa fa-question-circle" aria-hidden="true"></i>
                        Quizzes List </a></li>

                @if( Auth::user()->can('manage_user'))
                    <li><a href="{{ route('education.index') }}"><i class="fa fa-graduation-cap" aria-hidden="true"></i> Education </a></li>
                    <li><a href="{{ route('user.getTeachers') }}"><i class="fas fa-chalkboard-teacher"></i> Teacher's List </a></li>
                @endif
            </ul>
        </div>
    </div>
    <!-- /sidebar menu -->

</div>
