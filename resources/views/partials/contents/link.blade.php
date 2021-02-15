{{--
    Link

    PARAMETERS:
        - $text: the text to show
        - $color: the link color
        - $hoverColor: the link hover color
        - $url:
        - $target: '_self' | '_blank'
--}}

<a  href="{{$url}}" 
    class="bg-transparent cursor-pointer leading-6 text-{{$color}} hover:text-{{$hoverColor}}"
    target="{{$target}}"
    >
    {{$text}}
</a>
