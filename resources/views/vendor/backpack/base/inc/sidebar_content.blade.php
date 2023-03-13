{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i
            class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>


@if(backpack_user()->role=="staff" || backpack_user()->role=="admin")
    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-group"></i> Người dùng</a>
        <ul class="nav-dropdown-items">
            @if(backpack_user()->role=="admin")
                <li class="nav-item"><a class="nav-link" href="{{ backpack_url('staff') }}"><i
                            class="nav-icon la la-user-astronaut"></i> Nhân
                        viên</a></li>
            @endif
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('teacher') }}"><i
                        class="nav-icon la la-user-tie"></i>
                    Giáo viên</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('student') }}"><i
                        class="nav-icon la la-users"></i>
                    Học sinh</a></li>
            {{--        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-question"></i> Users</a>--}}
            {{--        </li>--}}
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('customer') }}"><i
                        class="nav-icon la la-users"></i> Khách hàng</a></li>
        </ul>
    @if(backpack_user()->role=="admin")
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('post') }}"><i
                    class="nav-icon la la-pinterest"></i>
                Bài viết</a>
        </li>
    @endif
@endif

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('grade') }}"><i
            class="nav-icon la la-chalkboard"></i> Lớp học</a></li>
</li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('log') }}"><i class="nav-icon la la-history"></i> Nhật ký</a>
</li>


<li class='nav-item'><a class='nav-link' href='{{ backpack_url('backup') }}'><i class='nav-icon la la-hdd-o'></i>
        Backups</a></li>
