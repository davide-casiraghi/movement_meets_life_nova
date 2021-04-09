@extends('layouts.app')

@section('title')@lang('static_pages.footer.get_a_treatment')@endsection

@section('content')

    @include('partials.messages')

    <div class="text-center mt-5 px-4 md:px-0">
        <h2 class="text-3xl leading-9 tracking-tight font-extrabold text-gray-900 sm:text-4xl sm:leading-10">
            {{__('forms.get_a_treatment.get_a_treatment')}}
        </h2>
        <p class="mt-3 max-w-2xl mx-auto text-xl leading-7 text-gray-500 sm:mt-4">
            {{__('forms.get_a_treatment.to_book')}}
        </p>
    </div>

    <div class="flex justify-center px-4 md:px-0">

        <form action="{{route('getATreatment.store')}}" method="POST" class="max-w-3xl">
            @csrf
            @honeypot
            <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6 mt-4">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="text-lg text-gray-600 font-extrabold tracking-tight sm:text-xl">{{__('forms.get_a_treatment.your_condition')}}</div>
                        <p class="mt-1 text-sm leading-5 text-gray-500">
                            {{__('forms.get_a_treatment.please_specify')}}
                        </p>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">

                        {{-- Main complaint description --}}
                        <div class="">
                            <label for="mainComplaint" class="block text-sm leading-5 font-medium text-gray-700">
                                {{__('forms.get_a_treatment.main_complaint')}}
                            </label>
                            <div class="rounded-md shadow-sm">
                                <textarea name="mainComplaint" id="mainComplaint" rows="3" class="form-textarea mt-1 block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary-300" placeholder="Brief description of the complaint."></textarea>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">
                                {{__('forms.get_a_treatment.specify_physical_locations')}}
                            </p>
                        </div>

                        {{-- Main complaint radio options --}}
                        <div class="mt-6">
                            <label for="main_complaint_intensity" class="block text-sm leading-5 font-medium text-gray-700">
                                {{__('forms.get_a_treatment.main_complaint_intensity')}}
                            </label>
                            <div class="flex mt-2">
                                <div class="w-1/5 bg-gray-100 h-12 text-center">
                                    <input id="main_complaint_1" name="mainComplaintIntensity" type="radio" value="1" class="form-radio h-4 w-4 text-primary-600 transition duration-150 ease-in-out">
                                    <label for="main_complaint_1" class="">
                                        <span class="block text-sm leading-5 font-medium text-gray-700">1</span>
                                    </label>
                                </div>
                                <div class="w-1/5 bg-gray-100 h-12 text-center">
                                    <input id="main_complaint_2" name="mainComplaintIntensity" type="radio" value="2" class="form-radio h-4 w-4 text-primary-600 transition duration-150 ease-in-out">
                                    <label for="main_complaint_2" class="">
                                        <span class="block text-sm leading-5 font-medium text-gray-700">2</span>
                                    </label>
                                </div>
                                <div class="w-1/5 bg-gray-100 h-12 text-center">
                                    <input id="main_complaint_3" name="mainComplaintIntensity" type="radio" value="3" class="form-radio h-4 w-4 text-primary-600 transition duration-150 ease-in-out">
                                    <label for="main_complaint_3" class="">
                                        <span class="block text-sm leading-5 font-medium text-gray-700">3</span>
                                    </label>
                                </div>
                                <div class="w-1/5 bg-gray-100 h-12 text-center">
                                    <input id="main_complaint_4" name="mainComplaintIntensity" type="radio" value="4" class="form-radio h-4 w-4 text-primary-600 transition duration-150 ease-in-out">
                                    <label for="main_complaint_4" class="">
                                        <span class="block text-sm leading-5 font-medium text-gray-700">4</span>
                                    </label>
                                </div>
                                <div class="w-1/5 bg-gray-100 h-12 text-center">
                                    <input id="main_complaint_5" name="mainComplaintIntensity" type="radio" value="5" class="form-radio h-4 w-4 text-primary-600 transition duration-150 ease-in-out">
                                    <label for="main_complaint_5" class="">
                                        <span class="block text-sm leading-5 font-medium text-gray-700">5</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- Secondary complaint description --}}
                        <div class="mt-6">
                            <label for="about" class="block text-sm leading-5 font-medium text-gray-700">
                                {{__('forms.get_a_treatment.secondary_complaint')}}
                            </label>
                            <div class="rounded-md shadow-sm">
                                <textarea name="secondaryComplaint" id="secondaryComplaint" rows="3" class="form-textarea mt-1 block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary-300" placeholder="Brief description of the complaint."></textarea>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">
                                {{__('forms.get_a_treatment.specify_physical_locations')}}
                            </p>
                        </div>

                        {{-- Secondary complaint radio options --}}
                        <div class="mt-6">
                            <label for="secondary_complaint_intensity" class="block text-sm leading-5 font-medium text-gray-700">
                                {{__('forms.get_a_treatment.secondary_complaint_intensity')}}
                            </label>
                            <div class="flex mt-2">
                                <div class="w-1/5 bg-gray-100 h-12 text-center">
                                    <input id="secondary_complaint_1" name="secondaryComplaintIntensity" type="radio" value="1" class="form-radio h-4 w-4 text-primary-600 transition duration-150 ease-in-out">
                                    <label for="secondary_complaint_1" class="">
                                        <span class="block text-sm leading-5 font-medium text-gray-700">1</span>
                                    </label>
                                </div>
                                <div class="w-1/5 bg-gray-100 h-12 text-center">
                                    <input id="secondary_complaint_2" name="secondaryComplaintIntensity" type="radio" value="2" class="form-radio h-4 w-4 text-primary-600 transition duration-150 ease-in-out">
                                    <label for="secondary_complaint_2" class="">
                                        <span class="block text-sm leading-5 font-medium text-gray-700">2</span>
                                    </label>
                                </div>
                                <div class="w-1/5 bg-gray-100 h-12 text-center">
                                    <input id="secondary_complaint_3" name="secondaryComplaintIntensity" type="radio" value="3" class="form-radio h-4 w-4 text-primary-600 transition duration-150 ease-in-out">
                                    <label for="secondary_complaint_3" class="">
                                        <span class="block text-sm leading-5 font-medium text-gray-700">3</span>
                                    </label>
                                </div>
                                <div class="w-1/5 bg-gray-100 h-12 text-center">
                                    <input id="secondary_complaint_4" name="secondaryComplaintIntensity" type="radio" value="4" class="form-radio h-4 w-4 text-primary-600 transition duration-150 ease-in-out">
                                    <label for="secondary_complaint_4" class="">
                                        <span class="block text-sm leading-5 font-medium text-gray-700">4</span>
                                    </label>
                                </div>
                                <div class="w-1/5 bg-gray-100 h-12 text-center">
                                    <input id="secondary_complaint_5" name="secondaryComplaintIntensity" type="radio" value="5" class="form-radio h-4 w-4 text-primary-600 transition duration-150 ease-in-out">
                                    <label for="secondary_complaint_5" class="">
                                        <span class="block text-sm leading-5 font-medium text-gray-700">5</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="text-lg text-gray-600 font-extrabold tracking-tight sm:text-xl">Personal Information</div>
                        {{--<p class="mt-1 text-sm leading-5 text-gray-500">
                            Use a permanent address where you can receive mail.
                        </p>--}}
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                @include('partials.forms.input', [
                                    'label' => __('forms.get_a_treatment.fields.first_name'),
                                    'name' => 'name',
                                    'placeholder' => '',
                                    'value' => old('name'),
                                    'required' => true,
                                    'disabled' => false,
                                ])
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                @include('partials.forms.input', [
                                   'label' => __('forms.get_a_treatment.fields.last_name'),
                                   'name' => 'surname',
                                   'placeholder' => '',
                                   'value' => old('surname'),
                                   'required' => true,
                                   'disabled' => false,
                               ])
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                @include('partials.forms.input', [
                                    'label' => __('forms.get_a_treatment.fields.your_email'),
                                    'name' => 'email',
                                    'placeholder' => '',
                                    'value' => old('email'),
                                    'required' => true,
                                    'disabled' => false,
                                ])
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                @include('partials.forms.input', [
                                    'label' => __('forms.get_a_treatment.fields.phone'),
                                    'name' => 'phone',
                                    'placeholder' => '',
                                    'value' => old('phone'),
                                    'required' => false,
                                    'disabled' => false,
                                ])
                            </div>
                            <div class="col-span-6">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="personalDataAgreement" name="personalDataAgreement" type="checkbox" class="form-checkbox h-4 w-4 text-primary-600 transition duration-150 ease-in-out">
                                    </div>
                                    <div class="ml-3 text-sm leading-5">
                                        <label for="personalDataAgreement" class="font-medium text-gray-700">Personal data agreement</label>
                                        <p class="text-gray-500">{{__('forms.get_a_treatment.data_save_agreement')}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="my-6 bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="text-lg text-gray-600 font-extrabold tracking-tight sm:text-xl">{{__('forms.get_a_treatment.contact')}}</div>
                        <p class="mt-1 text-sm leading-5 text-gray-500">
                            {{__('forms.get_a_treatment.decide_contact_method')}}
                        </p>
                    </div>
                    <div class="md:col-span-2">
                        <fieldset class="">
                            <div class="mt-4">
                                <div class="mt-4 flex items-center">
                                    <input name="contactChoice" value="email" type="radio" id="contact_email" class="form-radio h-4 w-4 text-primary-600 transition duration-150 ease-in-out">
                                    <label for="contact_email" class="ml-3">
                                        <span class="block text-sm leading-5 font-medium text-gray-700">Email</span>
                                    </label>
                                </div>
                                <div class="mt-4 flex items-center">
                                    <input name="contactChoice" value="phone" type="radio" id="contact_phone" class="form-radio h-4 w-4 text-primary-600 transition duration-150 ease-in-out">
                                    <label for="contact_phone" class="ml-3">
                                        <span class="block text-sm leading-5 font-medium text-gray-700">Phone call</span>
                                    </label>
                                </div>
                                <div class="mt-4 flex items-center">
                                    <input  name="contactChoice" value="sms_whatsapp" type="radio" id="contact_sms_whatsapp" class="form-radio h-4 w-4 text-primary-600 transition duration-150 ease-in-out">
                                    <label for="contact_sms_whatsapp" class="ml-3">
                                        <span class="block text-sm leading-5 font-medium text-gray-700">SMS/Whatsapp</span>
                                    </label>
                                </div>
                                <div class="mt-4 flex items-center">
                                    <input name="contactChoice" value="everything" type="radio" id="contact_everything" class="form-radio h-4 w-4 text-primary-600 transition duration-150 ease-in-out">
                                    <label for="contact_everything" class="ml-3">
                                        <span class="block text-sm leading-5 font-medium text-gray-700">All these ways are fine for me</span>
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>

            {{-- Send button --}}
            <div class="mt-6 py-5 mb-4">
                <div class="flex justify-end">
                    <span class="ml-3 inline-flex rounded-md shadow-sm">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-primary-600 hover:bg-primary-500 focus:outline-none focus:border-primary-700 focus:ring-primary active:bg-primary-700 transition duration-150 ease-in-out">
                            {{__('forms.get_a_treatment.send')}}
                        </button>
                    </span>
                </div>
            </div>
        </form>
    </div>

@endsection