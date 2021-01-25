<?php

namespace App\Services;

use App\Helpers\DateHelpers;
use App\Helpers\Helper;
use App\Http\Requests\EventSearchRequest;
use App\Http\Requests\EventStoreRequest;
use App\Models\Event;
use App\Models\EventRepetition;
use App\Repositories\EventRepository;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use PHPUnit\TextUI\Help;

class EventService
{
    private EventRepository $eventRepository;
    private EventRepetitionService $eventRepetitionService;

    /**
     * EventService constructor.
     *
     * @param \App\Repositories\EventRepository $eventRepository
     * @param \App\Services\EventRepetitionService $eventRepetitionService
     */
    public function __construct(
        EventRepository $eventRepository,
        EventRepetitionService $eventRepetitionService
    ) {
        $this->eventRepository = $eventRepository;
        $this->eventRepetitionService = $eventRepetitionService;
    }

    /**
     * Create a event
     *
     * @param array $data
     *
     * @return \App\Models\Event
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function createEvent(array $data): Event
    {
        $event = $this->eventRepository->store($data);
        $this->eventRepetitionService->updateEventRepetitions($data, $event->id);

        $event->setStatus('published');

        return $event;
    }

    /**
     * Update the Event
     *
     * @param array $data
     * @param int $eventId
     *
     * @return \App\Models\Event
     */

    public function updateEvent(array $data, int $eventId): Event
    {
        $event = $this->eventRepository->update($data, $eventId);
        $this->eventRepetitionService->updateEventRepetitions($data, $eventId);

        return $event;
    }

    /**
     * Return the event from the database
     *
     * @param $eventId
     *
     * @return \App\Models\Event
     */
    public function getById(int $eventId): Event
    {
        return $this->eventRepository->getById($eventId);
    }

    /**
     * Get all the Events.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getEvents(int $recordsPerPage = null, array $searchParameters = null)
    {
        return $this->eventRepository->getAll($recordsPerPage, $searchParameters);
    }

    /**
     * Delete the event from the database
     *
     * @param int $eventId
     */
    public function deleteEvent(int $eventId): void
    {
        $this->eventRepository->delete($eventId);
    }

    /**
     * Get the number of event created in the last 30 days.
     *
     * @return int
     */
    public function getNumberEventsCreatedLastThirtyDays(): int
    {
        return Event::whereDate('created_at', '>', date('Y-m-d', strtotime('-30 days')))->count();
    }

    /**
     * Store the uploaded photos in the Spatie Media Library
     *
     * @param \App\Models\Event $event
     * @param \App\Http\Requests\EventStoreRequest $data
     *
     * @return void
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    public function storeImages(Event $event, EventStoreRequest $data): void
    {
        if ($data->file('introimage')) {
            $introimage = $data->file('introimage');
            if ($introimage->isValid()) {
                $event->addMedia($introimage)->toMediaCollection('introimage');
            }
        }

        if ($data['introimage_delete'] == 'true') {
            $mediaItems = $event->getMedia('introimage');
            if (!is_null($mediaItems[0])) {
                $mediaItems[0]->delete();
            }
        }
    }

    /**
     * Get the event search parameters
     *
     * @param \App\Http\Requests\EventSearchRequest $request
     *
     * @return array
     */
    public function getSearchParameters(EventSearchRequest $request): array
    {
        $searchParameters = [];
        $searchParameters['title'] = $request->title ?? null;
        $searchParameters['eventCategoryId'] = $request->eventCategoryId ?? null;
        $searchParameters['startDate'] = $request->startDate ?? null;
        $searchParameters['endDate'] = $request->endDate ?? null;
        $searchParameters['teacherId'] = $request->teacherId ?? null;
        $searchParameters['organizerId'] = $request->organizerId ?? null;
        $searchParameters['repetitionKindId'] = $request->repetitionKindId ?? null;
        $searchParameters['venueId'] = $request->venueId ?? null;
        $searchParameters['status'] = $request->status ?? null;

        return $searchParameters;
    }

    /**
     * Return an array with the thumb images ulrs
     *
     * @param int $eventId
     *
     * @return array
     */
    public function getThumbsUrls(int $eventId): array
    {
        $thumbUrls = [];

        $event = $this->getById($eventId);
        foreach ($event->getMedia('event') as $photo) {
            $thumbUrls[] = $photo->getUrl('thumb');
        }

        return $thumbUrls;
    }

    /**
     * Return an array with the event data related to:
     * - date and time start
     * - date and time end
     * - repeat until
     * - multiple dates
     *
     * @param $event
     * @param $eventFirstRepetition
     *
     * @return array
     */
    public function getEventDateTimeParameters($event, $eventFirstRepetition): array
    {
        $dateTime = [];
        $dateTime['dateStart'] = (isset($eventFirstRepetition->start_repeat)) ? date('d/m/Y', strtotime($eventFirstRepetition->start_repeat)) : '';
        $dateTime['dateEnd'] = (isset($eventFirstRepetition->end_repeat)) ? date('d/m/Y', strtotime($eventFirstRepetition->end_repeat)) : '';

        //$dateTime['timeStart'] = (isset($eventFirstRepetition->start_repeat)) ? date('g:i A', strtotime($eventFirstRepetition->start_repeat)) : '';
        //$dateTime['timeEnd'] = (isset($eventFirstRepetition->end_repeat)) ? date('g:i A', strtotime($eventFirstRepetition->end_repeat)) : '';

        $dateTime['timeStartHours'] = (isset($eventFirstRepetition->start_repeat)) ? date('g', strtotime($eventFirstRepetition->start_repeat)) : '';
        $dateTime['timeStartMinutes'] = (isset($eventFirstRepetition->start_repeat)) ? date('i', strtotime($eventFirstRepetition->start_repeat)) : '';
        $dateTime['timeStartAmpm'] = (isset($eventFirstRepetition->start_repeat)) ? date('A', strtotime($eventFirstRepetition->start_repeat)) : '';
        $dateTime['timeEndHours'] = (isset($eventFirstRepetition->end_repeat)) ? date('g', strtotime($eventFirstRepetition->end_repeat)) : '';
        $dateTime['timeEndMinutes'] = (isset($eventFirstRepetition->end_repeat)) ? date('i', strtotime($eventFirstRepetition->end_repeat)) : '';
        $dateTime['timeEndAmpm'] = (isset($eventFirstRepetition->end_repeat)) ? date('A', strtotime($eventFirstRepetition->end_repeat)) : '';



        $dateTime['repeatUntil'] = date('d/m/Y', strtotime($event->repeat_until));
        $dateTime['multipleDates'] = $event->multiple_dates;

        return $dateTime;
    }

    /**
     * Return the HTML of the monthly select dropdown - inspired by - https://www.theindychannel.com/calendar
     * - Used by the AJAX in the event repeat view -
     * - The HTML contain a <select></select> with four <options></options>.
     *
     * @param string $date
     *
     * @return string
     */
    public function getMonthlySelectOptions(string $date): string
    {
        $monthlySelectOptions = [];
        $date = implode('-', array_reverse(explode('/', $date)));  // Our YYYY-MM-DD date string
        $unixTimestamp = strtotime($date);  // Convert the date string into a unix timestamp.
        $dayOfWeekString = date('l', $unixTimestamp); // Monday | Tuesday | Wednesday | ..

        // Add option: Same day number.
        // eg. "the 28th day of the month"
        $dateArray = explode('-', $date);
        $dayNumber = ltrim($dateArray[2], '0'); // remove the 0 in front of a day number eg. 02/10/2018

        $format = __('ordinalDays.the_' . ($dayNumber) . '_x_of_the_month');
        $repeatText = sprintf($format, 'day');

        array_push($monthlySelectOptions, [
            'value' => '0|' . $dayNumber,
            'text' => $repeatText,
        ]);

        // Add option: Same weekday/week of the month.
        // eg. the "1st Monday" 1|1|1 (first week, monday)
        $dayOfWeekValue = date('N', $unixTimestamp); // 1 (for Monday) through 7 (for Sunday)
        $weekOfTheMonth = DateHelpers::weekdayNumberOfMonth($date, $dayOfWeekValue); // 1 | 2 | 3 | 4 | 5

        $format = __('ordinalDays.the_' . ($weekOfTheMonth) . '_x_of_the_month');
        $repeatText = sprintf($format, $dayOfWeekString);

        array_push($monthlySelectOptions, [
            'value' => '1|' . $weekOfTheMonth . '|' . $dayOfWeekValue,
            'text' => $repeatText,
        ]);

        // Add option: Same day of the month (from the end).
        // eg. "the 3rd to last day of the month" (0 if last day, 1 if 2nd to last day, , 2 if 3rd to last day)
        $dayOfMonthFromTheEnd = DateHelpers::dayOfMonthFromTheEnd($unixTimestamp); // 1 | 2 | 3 | 4 | 5

        $format = __('ordinalDays.the_'.($dayOfMonthFromTheEnd + 1).'_to_last_x_of_the_month');
        $repeatText = sprintf($format, 'day');

        array_push($monthlySelectOptions, [
            'value' => '2|'.$dayOfMonthFromTheEnd,
            'text' => $repeatText,
        ]);

        // Add option: Same weekday/week of the month (from the end).
        // eg. the last Friday - (0 if last Friday, 1 if the 2nd to last Friday, 2 if the 3nd to last Friday)
        $weekOfMonthFromTheEnd = DateHelpers::weekOfMonthFromTheEnd($unixTimestamp); // 1 | 2 | 3 | 4 | 5

        if ($weekOfMonthFromTheEnd == 1) {
            $weekValue = 0;
        } else {
            $weekValue = $weekOfMonthFromTheEnd - 1;
        }

        $format = __('ordinalDays.the_' . ($weekOfMonthFromTheEnd) . '_to_last_x_of_the_month');
        $repeatText = sprintf($format, $dayOfWeekString);

        array_push($monthlySelectOptions, [
            'value' => '3|' . $weekValue . '|' . $dayOfWeekValue,
            'text' => $repeatText,
        ]);

        // GENERATE the HTML to return
        $selectTitle = __('general.select_repeat_monthly_kind');
        $onMonthlyKindSelect = "<select name='on_monthly_kind' id='on_monthly_kind' class='selectpicker' title='".$selectTitle."'>";
        foreach ($monthlySelectOptions as $key => $monthlySelectOption) {
            $onMonthlyKindSelect .= "<option value='".$monthlySelectOption['value']."'>".$monthlySelectOption['text'].'</option>';
        }
        $onMonthlyKindSelect .= '</select>';

        return $onMonthlyKindSelect;
    }

    /**
     * Return a string that describe repetition kind in the event show view.
     *
     * @param \App\Models\Event $event
     * @param \App\Models\EventRepetition $firstRpDates
     *
     * @return string $ret
     */
    public static function getRepetitionTextString(Event $event, EventRepetition $firstRpDates): string
    {
        $ret = '';

        switch ($event->repeat_type) {
            case '1': // noRepeat
                break;
            case '2': // repeatWeekly
                $repeatUntil = new DateTime($event->repeat_until);

                // Get the name of the weekly day when the event repeat, if two days, return like "Thursday and Sunday"
                $repetitonWeekdayNumbersArray = explode(',', $event->repeat_weekly_on);

                $repetitonWeekdayNamesArray = [];
                foreach ($repetitonWeekdayNumbersArray as $key => $repetitonWeekdayNumber) {
                    $repetitonWeekdayNamesArray[] = DateHelpers::decodeRepeatWeeklyOn($repetitonWeekdayNumber);
                }
                // create from an array a string with all the values divided by " and "
                $nameOfTheRepetitionWeekDays = implode(' and ', $repetitonWeekdayNamesArray);

                //$ret = 'The event happens every '.$nameOfTheRepetitionWeekDays.' until '.$repeatUntil->format('d/m/Y');
                $format = __('event.the_event_happens_every_x_until_x');
                $ret .= sprintf($format, $nameOfTheRepetitionWeekDays, $repeatUntil->format('d/m/Y'));
                break;
            case '3': //repeatMonthly
                $repeatUntil = new DateTime($event->repeat_until);
                $repetitionFrequency = self::decodeOnMonthlyKind($event->on_monthly_kind);

                //$ret = 'The event happens '.$repetitionFrequency.' until '.$repeatUntil->format('d/m/Y');
                $format = __('event.the_event_happens_x_until_x');
                $ret .= sprintf($format, $repetitionFrequency, $repeatUntil->format('d/m/Y'));
                break;
            case '4': //repeatMultipleDays
                $dateStart = date('d/m/Y', strtotime($firstRpDates->start_repeat));
                $singleDaysRepeatDatas = explode(',', $event->multiple_dates);

                // Sort the datas
                usort($singleDaysRepeatDatas, function ($a, $b) {
                    $a = Carbon::createFromFormat('d/m/Y', $a);
                    $b = Carbon::createFromFormat('d/m/Y', $b);

                    return strtotime($a) - strtotime($b);
                });

                $ret .= __('event.the_event_happens_on_this_dates');
                $ret .= $dateStart . ', ';
                $ret .= Helper::getStringFromArraySeparatedByComma($singleDaysRepeatDatas);
                break;
        }

        return $ret;
    }

    /**
     * Return a string that describe the report misuse reason.
     *
     * @param  int $reason
     * @return string $ret
     */
    public static function getReportMisuseReasonDescription(int $reason): string
    {
        $ret = '';
        switch ($reason) {
            case '1':
                $ret = 'Not about Contact Improvisation';
                break;
            case '2':
                $ret = 'Contains wrong informations';
                break;
            case '3':
                $ret = 'It is not translated in english';
                break;
            case '4':
                $ret = 'Other (specify in the message)';
                break;
        }

        return $ret;
    }

    /**
     * Decode the event on_monthly_kind field - used in event.show.
     * Return a string like "the 4th to last Thursday of the month".
     *
     * @param  string $onMonthlyKindCode
     * @return string
     */
    public static function decodeOnMonthlyKind(string $onMonthlyKindCode): string
    {
        $ret = '';
        $onMonthlyKindCodeArray = explode('|', $onMonthlyKindCode);
        $weekDays = [
            '',
            __('general.monday'),
            __('general.tuesday'),
            __('general.wednesday'),
            __('general.thursday'),
            __('general.friday'),
            __('general.saturday'),
            __('general.sunday'),
        ];

        //dd($onMonthlyKindCodeArray);
        switch ($onMonthlyKindCodeArray[0]) {
            case '0':  // 0|7 eg. the 7th day of the month
                $dayNumber = $onMonthlyKindCodeArray[1];
                $format = __('ordinalDays.the_'.($dayNumber).'_x_of_the_month');
                $ret = sprintf($format, __('general.day'));
                break;
            case '1':  // 1|2|4 eg. the 2nd Thursday of the month
                $dayNumber = $onMonthlyKindCodeArray[1];
                $weekDay = $weekDays[$onMonthlyKindCodeArray[2]]; // Monday, Tuesday, Wednesday
                $format = __('ordinalDays.the_'.($dayNumber).'_x_of_the_month');
                $ret = sprintf($format, $weekDay);
                break;
            case '2': // 2|20 eg. the 21st to last day of the month
                $dayNumber = (int) $onMonthlyKindCodeArray[1] + 1;
                $format = __('ordinalDays.the_'.($dayNumber).'_to_last_x_of_the_month');
                $ret = sprintf($format, __('general.day'));
                break;
            case '3': // 3|3|4 eg. the 4th to last Thursday of the month
                $dayNumber = (int) $onMonthlyKindCodeArray[1] + 1;
                $weekDay = $weekDays[$onMonthlyKindCodeArray[2]]; // Monday, Tuesday, Wednesday
                $format = __('ordinalDays.the_'.($dayNumber).'_to_last_x_of_the_month');
                $ret = sprintf($format, $weekDay);
                break;
        }

        return $ret;
    }
}
