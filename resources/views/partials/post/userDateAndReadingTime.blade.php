{{-- Author on the left, date and reading time on the right: each takes the width it needs (on small screens the date wraps below, aligned right) --}}
<div class="flex flex-wrap justify-between gap-x-6 gap-y-1 text-base {{$textColor}}">
    <div class="whitespace-nowrap">
        @lang('post.written_by') {{$post->user->profile->full_name}}
    </div>
    <div class="ml-auto text-right">
        {{ app()->getLocale() === 'it' ? $post->created_at->day.' '.ucfirst($post->created_at->translatedFormat('M')).' '.$post->created_at->year : $post->created_at->format('M j, Y') }} |
        <div class="inline-block">
            @lang('post.reading_time', ['minutes' => $post->readingTime('minutes')])
        </div>
    </div>
</div>
