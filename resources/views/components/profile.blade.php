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
                            Học vấn : Melbourne University, Australia
                        </div>
                        <div class="mt-2">
                            <i class="las la-certificate text-danger"></i>
                            Chứng chỉ : IELTS 8.5 , TOEIC 950
                        </div>
                        <div class="mt-2">
                            <i class="las la-chalkboard-teacher text-danger"></i>
                            Chuyên môn : Tiếng anh cho bé, tiếng anh cho người đi làm
                        </div>
                        <div class="mt-2">
                            <i class="las la-star text-danger"></i>
                            Đánh giá : Giáo viên dạy tốt ( Dựa trên 1200 đánh giá)
                        </div>
                    </div>
                </div>
                <div class="">
                    <button class="btn btn-success">Kết nối tài khoản</button>
                    <button class="btn btn-primary">Sửa thông tin tài khoản</button>
                    <a href="{{backpack_url("logout")}}" class="btn btn-dribbble">Đăng xuất</a>
                </div>
            </div>
        </div>
    </div>
</div>
