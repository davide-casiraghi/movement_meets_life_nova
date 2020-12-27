<div class="grid grid-flow-col auto-cols-max md:auto-cols-min text-base {{$textColor}}">
    <div class="pr-10">
        By {{$post->user->name}}
    </div>
    <div class="">
        <div class="float-right">
            {{ $post->created_at->format('M j, Y') }} |
            <div class="inline-block">
                {{ $post->readingTime('minutes') }} min read
            </div>
        </div>
    </div>
</div>