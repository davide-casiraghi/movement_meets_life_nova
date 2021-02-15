{{--
    Accordion

    PARAMETERS:
        - $elements: the text to show


Include like this:

@include('partials.contents.accordion',[
                'elements' => [
                    [
                        'title' => 'Lorem impusm',
                        'text' => 'Lorem ipsum',
                    ],
                    [
                        'title' => 'tttt',
                        'text' => 'eeee',
                    ],
                ]
            ])


--}}

<div class="textHasAccordion accordion">
    @foreach($elements as $element)

        <div class='slide w-full'>
            <input type='checkbox' name='panel' id='panel-".$this->count."' class='hidden'>
            <label for='panel-".$this->count."' class='relative block border-t border-b border-solid border-gray-500 text-purple-600 p-4 shadow'>
                {{$element['title']}}
            </label>
            <div class='accordion__content overflow-hidden bg-grey-lighter'>
                <div class='accordion__body p-4' id='panel".$this->count."'>{{$element['text']}}</div>
            </div>
        </div>
    @endforeach
</div>