<div>
    <div class="flex flex-wrap space-x-4 mt-1 mb-4">
        @foreach($model->getMedia('galleries') as $image)
            <div class="w-44">
                <img src="{{$image->getUrl('thumb')}}" class="" alt="">
            </div>
        @endforeach
    </div>
</div>
