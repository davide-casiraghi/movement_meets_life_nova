@extends('layouts.app')

@section('content')

<div class="text-center mt-5">
    <h2 class="text-3xl leading-9 tracking-tight font-extrabold text-gray-900 sm:text-4xl sm:leading-10">
        Get a treatment
    </h2>
    <p class="mt-3 max-w-2xl mx-auto text-xl leading-7 text-gray-500 sm:mt-4">
        To book a treatment please specify the required information to allow me to get an idea of your condition.<br>
    </p>
</div>

<div class="flex justify-center">

    <form action="#" method="POST" class="max-w-3xl">
        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6 mt-4">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Profile</h3>
                    <p class="mt-1 text-sm leading-5 text-gray-500">
                        Please specify which conditions worsen / facilitate and on what time of the day does the problem appear.
                    </p>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">

                    {{-- Main complaint description --}}
                    <div class="mt-6">
                        <label for="about" class="block text-sm leading-5 font-medium text-gray-700">
                            Main complaint
                        </label>
                        <div class="rounded-md shadow-sm">
                            <textarea id="about" rows="3" class="form-textarea mt-1 block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" placeholder="you@example.com"></textarea>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                            Brief description of the complaint. <br>
                            Please specify the physical locations if the problem is focused in specific spots.
                        </p>
                    </div>

                    {{-- Main complaint radio options --}}
                    <div class="mt-6">
                        <label for="main_complaint_intensity" class="block text-sm leading-5 font-medium text-gray-700">
                            Main complaint intensity (Light - Severe)
                        </label>
                        <div class="flex mt-2">
                            <div class="w-1/5 bg-gray-100 h-12 text-center">
                                <input id="main_complaint_1" name="main_complaint_intensity" type="radio" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                                <label for="main_complaint_1" class="">
                                    <span class="block text-sm leading-5 font-medium text-gray-700">1</span>
                                </label>
                            </div>
                            <div class="w-1/5 bg-gray-100 h-12 text-center">
                                <input id="main_complaint_2" name="main_complaint_intensity" type="radio" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                                <label for="main_complaint_2" class="">
                                    <span class="block text-sm leading-5 font-medium text-gray-700">2</span>
                                </label>
                            </div>
                            <div class="w-1/5 bg-gray-100 h-12 text-center">
                                <input id="main_complaint_3" name="main_complaint_intensity" type="radio" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                                <label for="main_complaint_3" class="">
                                    <span class="block text-sm leading-5 font-medium text-gray-700">3</span>
                                </label>
                            </div>
                            <div class="w-1/5 bg-gray-100 h-12 text-center">
                                <input id="main_complaint_4" name="main_complaint_intensity" type="radio" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                                <label for="main_complaint_4" class="">
                                    <span class="block text-sm leading-5 font-medium text-gray-700">4</span>
                                </label>
                            </div>
                            <div class="w-1/5 bg-gray-100 h-12 text-center">
                                <input id="main_complaint_5" name="main_complaint_intensity" type="radio" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                                <label for="main_complaint_5" class="">
                                    <span class="block text-sm leading-5 font-medium text-gray-700">5</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Secondary complaint description --}}
                    <div class="mt-6">
                        <label for="about" class="block text-sm leading-5 font-medium text-gray-700">
                            Secondary complaint
                        </label>
                        <div class="rounded-md shadow-sm">
                            <textarea id="about" rows="3" class="form-textarea mt-1 block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" placeholder="you@example.com"></textarea>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                            Brief description of the secondary complaint.
                        </p>
                    </div>

                    {{-- Secondary complaint radio options --}}
                    <div class="mt-6">
                        <label for="secondary_complaint_intensity" class="block text-sm leading-5 font-medium text-gray-700">
                            Secondary complaint intensity (Light - Severe)
                        </label>
                        <div class="flex mt-2">
                            <div class="w-1/5 bg-gray-100 h-12 text-center">
                                <input id="secondary_complaint_1" name="secondary_complaint_intensity" type="radio" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                                <label for="secondary_complaint_1" class="">
                                    <span class="block text-sm leading-5 font-medium text-gray-700">1</span>
                                </label>
                            </div>
                            <div class="w-1/5 bg-gray-100 h-12 text-center">
                                <input id="secondary_complaint_2" name="secondary_complaint_intensity" type="radio" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                                <label for="secondary_complaint_2" class="">
                                    <span class="block text-sm leading-5 font-medium text-gray-700">2</span>
                                </label>
                            </div>
                            <div class="w-1/5 bg-gray-100 h-12 text-center">
                                <input id="secondary_complaint_3" name="secondary_complaint_intensity" type="radio" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                                <label for="secondary_complaint_3" class="">
                                    <span class="block text-sm leading-5 font-medium text-gray-700">3</span>
                                </label>
                            </div>
                            <div class="w-1/5 bg-gray-100 h-12 text-center">
                                <input id="secondary_complaint_4" name="secondary_complaint_intensity" type="radio" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                                <label for="secondary_complaint_4" class="">
                                    <span class="block text-sm leading-5 font-medium text-gray-700">4</span>
                                </label>
                            </div>
                            <div class="w-1/5 bg-gray-100 h-12 text-center">
                                <input id="secondary_complaint_5" name="secondary_complaint_intensity" type="radio" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
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
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Personal Information</h3>
                    <p class="mt-1 text-sm leading-5 text-gray-500">
                        Use a permanent address where you can receive mail.
                    </p>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label for="first_name" class="block text-sm font-medium leading-5 text-gray-700">First name</label>
                                <input id="first_name" class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="last_name" class="block text-sm font-medium leading-5 text-gray-700">Last name</label>
                                <input id="last_name" class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <label for="email_address" class="block text-sm font-medium leading-5 text-gray-700">Email address</label>
                                <input id="email_address" class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="country" class="block text-sm font-medium leading-5 text-gray-700">Country / Region</label>
                                <select id="country" class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                                    <option>United States</option>
                                    <option>Canada</option>
                                    <option>Mexico</option>
                                </select>
                            </div>

                            <div class="col-span-6">
                                <label for="street_address" class="block text-sm font-medium leading-5 text-gray-700">Street address</label>
                                <input id="street_address" class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            </div>

                            <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                <label for="city" class="block text-sm font-medium leading-5 text-gray-700">City</label>
                                <input id="city" class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            </div>

                            <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                <label for="state" class="block text-sm font-medium leading-5 text-gray-700">State / Province</label>
                                <input id="state" class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            </div>

                            <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                <label for="postal_code" class="block text-sm font-medium leading-5 text-gray-700">ZIP / Postal</label>
                                <input id="postal_code" class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            </div>
                        </div>
                </div>
            </div>
        </div>

        <div class="my-6 bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Contact</h3>
                    <p class="mt-1 text-sm leading-5 text-gray-500">
                        Decide how you would like to be contacted
                    </p>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <fieldset>
                        <legend class="text-base leading-6 font-medium text-gray-900">By Email</legend>
                        <div class="mt-4">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="comments" type="checkbox" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                                </div>
                                <div class="ml-3 text-sm leading-5">
                                    <label for="comments" class="font-medium text-gray-700">Comments</label>
                                    <p class="text-gray-500">Get notified when someones posts a comment on a posting.</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="candidates" type="checkbox" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                                    </div>
                                    <div class="ml-3 text-sm leading-5">
                                        <label for="candidates" class="font-medium text-gray-700">Candidates</label>
                                        <p class="text-gray-500">Get notified when a candidate applies for a job.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="offers" type="checkbox" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                                    </div>
                                    <div class="ml-3 text-sm leading-5">
                                        <label for="offers" class="font-medium text-gray-700">Offers</label>
                                        <p class="text-gray-500">Get notified when a candidate accepts or rejects an offer.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="mt-6">
                        <legend class="text-base leading-6 font-medium text-gray-900">Push Notifications</legend>
                        <p class="text-sm leading-5 text-gray-500">These are delivered via SMS to your mobile phone.</p>
                        <div class="mt-4">
                            <div class="flex items-center">
                                <input id="push_everything" name="push_notifications" type="radio" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                                <label for="push_everything" class="ml-3">
                                    <span class="block text-sm leading-5 font-medium text-gray-700">Everything</span>
                                </label>
                            </div>
                            <div class="mt-4 flex items-center">
                                <input id="push_email" name="push_notifications" type="radio" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                                <label for="push_email" class="ml-3">
                                    <span class="block text-sm leading-5 font-medium text-gray-700">Same as email</span>
                                </label>
                            </div>
                            <div class="mt-4 flex items-center">
                                <input id="push_nothing" name="push_notifications" type="radio" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                                <label for="push_nothing" class="ml-3">
                                    <span class="block text-sm leading-5 font-medium text-gray-700">No push notifications</span>
                                </label>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </form>
</div>


@endsection