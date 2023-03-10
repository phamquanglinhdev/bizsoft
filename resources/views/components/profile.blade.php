<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-sm-6 col-12 mb-2">
            <div class="border rounded">
                <img src="{{$user->avatar}}" style="border: 1em white solid" class="w-100 rounded">
            </div>
        </div>
        <div class="col-md-9 col-sm-6 col-12 mb-2">
            <div class="border rounded bg-white p-lg-4 p-2 h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="h2 text-primary font-weight-bold mb-2 mb-lg-5">{{$user->name}}</div>
                    <div>
                        <span class="las la-envelope text-danger"></span>
                        <span class="mr-2">Email: {{$user->email}}</span>
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
                    <div class="extras-information">
                        <div class="mt-2">
                            <i class="las la-graduation-cap text-danger"></i>
                            H???c v???n : Melbourne University, Australia
                        </div>
                        <div class="mt-2">
                            <i class="las la-certificate text-danger"></i>
                            Ch???ng ch??? : IELTS 8.5 , TOEIC 950
                        </div>
                        <div class="mt-2">
                            <i class="las la-chalkboard-teacher text-danger"></i>
                            Chuy??n m??n : Ti???ng anh cho b??, ti???ng anh cho ng?????i ??i l??m
                        </div>
                        <div class="mt-2">
                            <i class="las la-star text-danger"></i>
                            ????nh gi?? : Gi??o vi??n d???y t???t ( D???a tr??n 1200 ????nh gi??)
                        </div>
                    </div>
                </div>
                <div class="">
                    <button class="btn btn-success">K???t n???i t??i kho???n</button>
                    <button class="btn btn-primary">S???a th??ng tin t??i kho???n</button>
                    <a href="{{backpack_url("logout")}}" class="btn btn-dribbble">????ng xu???t</a>
                </div>
            </div>
        </div>
    </div>
</div>
