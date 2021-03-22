<div class='lifeGallery'>
    @foreach($images as $image)

        <div class='item'>
            @php
                $imageLink = $path.$image['name'];
                $thumbLink = $path."thumb/".$image['name'];
                $isVideo = false;

                if (array_key_exists('youtube_url',$image)){
                  $imageLink = $image['youtube_url'];
                  $isVideo = true;
                }
                if(array_key_exists('vimeo_url',$image)){
                  $imageLink = $image['vimeo_url'];
                  $isVideo = true;
                }

                $caption = '';
                if(array_key_exists('description',$image)){
                  $caption = $image['description'].'<br>';
                }
                if(array_key_exists('credits',$image)){
                  $caption = $image['credits'];
                }
            @endphp



            <a href='{{asset($imageLink)}}' data-fancybox='images' @if(!empty($caption))data-caption='{{$caption}}'@endif>
                <img src='{{asset($thumbLink)}}' @if(array_key_exists('description',$image)) alt='{{$image['description']}} @endif' />
                @if($isVideo)
                    <i class='far fa-play-circle' style="position: absolute;top: calc(50% - 25px);left: calc(50% - 25px); color: hsla(0,0%,100%,.8);font-size: 50px;"></i>
                @endif
            </a>
            @if(array_key_exists('description',$image))
                <div class="jg-caption">
                    {{$image['description']}}
                </div>
            @endif
        </div>
    @endforeach
</div>

@isset($image['description']){{$image['description']}}@endisset