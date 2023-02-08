<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-sm-6 col-12 mb-2">
            <div class="border rounded">
                <img src="{{$user->avatar}}" style="border: 1em white solid" class="w-100 rounded">
            </div>
        </div>
        <div class="col-md-9 col-sm-6 col-12 mb-2">
            <div class="border rounded bg-white p-lg-4 p-2 h-100">
                <div class="h2 text-primary font-weight-bold">{{$user->name}}</div>
                <div>
                    <span class="las la-envelope"></span>
                    <span class="mr-2">{{$user->email}}</span>
                    @if(isset($user->google_id))
                        <span>
                            <img src="https://cdn-icons-png.flaticon.com/512/2991/2991148.png"
                                 style="width: 1em;height: 1em">
                        </span>
                    @endif
                    @if(isset($user->facebook_id))
                        <span>
                            <a href="#">
                                <img
                                    src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b8/2021_Facebook_icon.svg/2048px-2021_Facebook_icon.svg.png"
                                    style="width: 1em;height: 1em">
                            </a>
                        </span>
                    @endif
                    @if(isset($user->github_id))
                        <span>
                            <a href="#">
                                <img
                                    src="https://cdn-icons-png.flaticon.com/512/25/25231.png"
                                    style="width: 1em;height: 1em">
                            </a>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
