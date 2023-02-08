@extends(backpack_view('blank'))
@section('content')
    @if(backpack_user()->role="admin")
        @include("components.profile",['user'=>backpack_user()])
        @include("components.admin-dashboard")
    @endif
@endsection
