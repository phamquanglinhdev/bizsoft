@php
    use App\Models\Post;
    if(backpack_user()->role="admin"){
        $posts = Post::orderBy("pin","DESC")->get();
    }else{
        $posts = Post::where("roles","like","%".backpack_user()->role."%")->orderBy("pin","DESC")->get();
    }
@endphp
@extends(backpack_view('blank'))
@section('content')
    @if(backpack_user()->role="admin")
        @include("components.profile",['user'=>backpack_user()])
        @include("components.admin-dashboard",['posts'=>$posts])
    @endif
@endsection
