@php
    use App\Models\Post;
    if(backpack_user()->role=="admin"){
        $posts = Post::orderBy("pin","DESC")->get();
    }else{
        $posts = Post::where("roles","like","%".backpack_user()->role."%")->orderBy("pin","DESC")->get();
    }
@endphp
@extends(backpack_view('blank'))
@section('content')
    @include("components.profile",['user'=>backpack_user()])
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="border rounded p-3 bg-white">
                    @if(backpack_user()->role=="admin")
                        @include("components.admin-dashboard")
                    @endif
                    @include("components.posts_dashboard",['posts'=>$posts])
                </div>
            </div>
        </div>
    </div>
@endsection
