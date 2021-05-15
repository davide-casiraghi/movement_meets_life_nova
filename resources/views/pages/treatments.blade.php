@extends('layouts.app')

@section('title')@lang('static_pages.treatments.title')@endsection

@section('content')

    <div class="max-w-2xl mx-auto px-8 lg:px-0 mb-10 md:mt-6">

        {{--<div class="leading-6 pt-6 pb-8 text-black">
            <h1 class="sm:text-3xl md:text-5xl border-solid box-border font-extrabold text-3xl m-0 text-gray-900 tracking-tight mb-2">
                Treatments - Ilan Lev Method
            </h1>
        </div>--}}

        @include('partials.pages.treatments.intro')

        {{--
                <div class="">
                    In April 2019 I've completed the first Ilan Lev Method training program in Europe and I'm a certified practitioner.
                    <br>
                    I give private treatments in Ljubljana, Slovenia at <a href="http://www.visja-vibracija.si/" class="textLink">Višja Vibracija</a>.
        </div>
--}}

    </div>


    {{--@include('partials.pages.treatments.big_feedbacks')--}}

    @include('partials.pages.treatments.video_ilm_official')

    {{-- Galley --}}
    @include('partials.pages.treatments.treatment_gallery')

    {{-- What is the treatment about --}}
    @include('partials.pages.treatments.features')

    {{-- FAQs --}}
    @include('partials.pages.treatments.faq_two_columns', [
          'left' => [
              1 => [
                'question' => __('static_pages.treatments.faq.why_to_get_a_bodywork'),
                'answer' =>  __('static_pages.treatments.faq.somatic_bodywork_involves'),
              ],
              2 => [
                'question' => __('static_pages.treatments.faq.why_ilm_is_different'),
                'answer' =>  __('static_pages.treatments.faq.a_normal_massage'),
              ],
              3 => [
                'question' => __('static_pages.treatments.faq.what_is_sensory_motor_amnesia'),
                'answer' => __('static_pages.treatments.faq.the_more_we_are_stressed'),
              ],
              4 => [
                'question' => __('static_pages.treatments.faq.i_have_a_fresh_injury'),
                'answer' =>  __('static_pages.treatments.faq.yes_it_is_gonna_be_much_slow'),
              ],
              5 => [
                'question' => __('static_pages.treatments.faq.why_do_we_need_to_refresh'),
                'answer' =>  __('static_pages.treatments.faq.we_are_constantly_accumulating'),
              ],
            ],
          'right' => [
              1 => [
                'question' => __('static_pages.treatments.faq.how_much_treatment_last'),
                'answer' =>  __('static_pages.treatments.faq.minutes_per_session'),
              ],
              2 => [
                'question' => __('static_pages.treatments.faq.how_many_treatments'),
                'answer' =>  __('static_pages.treatments.faq.even_if_first_session'),
              ],
              3 => [
                'question' => __('static_pages.treatments.faq.is_it_good_for_back_pain'),
                'answer' =>  __('static_pages.treatments.faq.yes_it_is'),
              ],
              4 => [
                'question' => __('static_pages.treatments.faq.how_do_i_need_to_dress'),
                'answer' =>  __('static_pages.treatments.faq.long_comfortable_clothes'),
              ],
              5 => [
                'question' => __('static_pages.treatments.faq.how_is'),
                'answer' =>  __('static_pages.treatments.faq.how_is_list'),
              ],
            ],
      ])

    {{--@include('partials.pages.treatments.benefits')--}}

    @include('partials.pages.treatments.cta')

@endsection
