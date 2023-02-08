<hr>
<div class="mt-2">
    @foreach($posts as $post)
        <div class="mb-5">
            <div class="h5 font-weight-bold text-success">
                <i class="lab la-pinterest">
                </i>
                {{$post->title}}
                @if($post->pin)
                    <i class="las la-thumbtack text-danger"></i>
                @endif
            </div>
            <div class="rounded @if(!$post->pin) border @endif p-2 " @if($post->pin)style="background: #42ba961a"@endif>
                {!! $post->document !!}
            </div>
        </div>
    @endforeach
</div>
