<div class="md:grid md:grid-cols-6 md:gap-6 text-base {{$textColor}}">
    <div class="md:col-span-2">
        @lang('post.written_by') {{$post->user->profile->full_name}}
    </div>
    <div class="md:mt-0 md:col-span-4">
        <div class="float-right">
            {{ app()->getLocale() === 'it' ? $post->created_at->day.' '.ucfirst($post->created_at->translatedFormat('M')).' '.$post->created_at->year : $post->created_at->format('M j, Y') }} |
            <div class="inline-block">
                @lang('post.reading_time', ['minutes' => $post->readingTime('minutes')])
            </div>
        </div>
    </div>
</div>