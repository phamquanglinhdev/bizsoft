@php
    $grade = $widget["grades"]
@endphp

<style>
    .border-5 {
        border-width: 0.2em !important;
    }

    .opacity {
        background: rgba(255, 0, 0, 0.2)
    }

    li {
        list-style: none;
        display: inline;
    }

    /* width */
    ::-webkit-scrollbar {
        width: 10px;
        height: 40px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        background: rgb(217 226 239 / 0%);;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: rgba(0, 0, 0, 0.35);
        border-radius: 10px;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: rgba(161, 0, 255, 0.26);;
    }
</style>
    <div class="container-fluid my-5 rounded py-5">
        <div>
            <span class="h3">{{$grade->name}}</span>
            <sup class="small badge badge-success">
                {{$grade->getStatus()}}
            </sup>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="bg-white my-2 rounded">
                    <img src="{{$grade->thumbnail}}" class="w-100 rounded">
                </div>
                <div class="py-2 rounded opacity">
                    <div class="p-2">
                        <li>
                            <img src="{{backpack_user()->avatar}}"
                                 class="rounded-circle border border-primary border-5"
                                 style="width: 4em;height: 4em">
                        </li>
                        <li>
                            <img src="{{backpack_user()->avatar}}"
                                 class="rounded-circle border border-primary border-5"
                                 style="width: 4em;height: 4em">
                        </li>
                        <li>
                            <img src="{{backpack_user()->avatar}}"
                                 class="rounded-circle border border-primary border-5"
                                 style="width: 4em;height: 4em">
                        </li>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="opacity my-2 p-1 rounded">
                    <div class="row">
                        <div class="col-md-3 col-sm-6">
                            <div class="text-center">
                                <div class="">
                                    <i class="la-3x las la-money-check-alt text-success"></i>
                                </div>
                                <div>G??i h???c ph??</div>
                                <div class="font-weight-bold">
                                    {{number_format($grade->pricing)}} ??
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="text-center">
                                <div class="">
                                    <i class="la-3x las la-history text-warning"></i>
                                </div>
                                <div>S??? bu???i ???? h???c</div>
                                <div class="font-weight-bold">
                                    50 bu???i h???c
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="text-center">
                                <div class="">
                                    <i class="la-3x las la-calendar-day text-danger"></i>
                                </div>
                                <div>Ng??y t???o l???p</div>
                                <div class="font-weight-bold">
                                    {{$grade->created_at}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="text-center">
                                <div class="">
                                    <i class="la-3x las la-calendar-alt text-primary"></i>
                                </div>
                                <div>T???n su???t h???c</div>
                                <div class="font-weight-bold">
                                    {{$grade->frequency()}} bu???i / tu???n
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-between">
                    <div class="col-md-6  p-3">
                        <div class="h4">L???ch h???c</div>
                        <div class="opacity rounded p-2">

                            @foreach($grade->times as $time)
                                <div class="text-uppercase h4">
                                    <i class="las la-calendar-alt"></i>
                                    <span class="badge-success badge">{{$time["day"]}} </span>
                                    :
                                    <span class="badge-success badge">{{$time["start"]}} </span>

                                    <i class="las la-arrow-right"></i>
                                    <span class="badge-success badge">{{$time["end"]}} </span>

                                </div>
                            @endforeach
                        </div>
                        <div class="py-2">
                            <a href="{{$grade->link}}" class="w-100 mb-1 btn btn-success"><i
                                    class="las la-power-off"></i> V??o l???p h???c</a>
                            <a href="{{backpack_url("grade/$grade->id/edit")}}" class="w-100 mb-1 btn btn-primary"><i
                                    class="las la-pencil-alt"></i> Ch???nh s???a l???p h???c</a>
                            <form action="{{backpack_url("grade/$grade->id")}}" method="post">
                                @csrf
                                @method("delete")
                                <button type="submit" class="btn btn-danger w-100 mb-1"><i class="las la-trash-alt"></i>X??a
                                    l???p h???c
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6 p-3 ">
                        <div class="h4">Nh???t k?? h???c</div>
                        <div class="opacity rounded p-2 flex-wrap w-100">
                            <div style="max-height: 300px;overflow-y: scroll">
                                @for($i=1;$i<30;$i++)
                                    <div
                                        class="opacity  my-1 p-2 rounded d-flex justify-content-between align-items-center">
                                        <div>
                                            <div>
                                                <i class="las la-clock"></i>
                                                12:14-12-13 12/1/2023
                                            </div>
                                            <div>
                                                <i class="las la-book"></i>
                                                Lesson 1: Greeting
                                            </div>

                                        </div>
                                        <a href="#" class="">
                                            <img src="https://assets.stickpng.com/images/580b57fcd9996e24bc43c4f9.png"
                                                 style="width: 2em;height: 2em"
                                            >
                                        </a>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
