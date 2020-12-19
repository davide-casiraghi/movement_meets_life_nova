<?php


namespace App\Repositories;

use App\Http\Requests\EventRepetitionStoreRequest;
use App\Http\Requests\EventStoreRequest;
use App\Models\EventRepetition;
use Illuminate\Support\Facades\Auth;


class EventRepetitionRepository {

    /**
     * Get all EventRepetitions.
     *
     * @return \App\Models\EventRepetition[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return EventRepetition::all();
    }

    /**
     * Get EventRepetition by id
     *
     * @param $eventRepetitionId
     * @return EventRepetition
     */
    public function getById($eventRepetitionId)
    {
        return EventRepetition::findOrFail($eventRepetitionId);
    }

    /**
     * Get the event first repetition
     *
     * @param $eventId
     *
     * @return EventRepetition
     */
    public function getFirstByEventId($eventId)
    {
        return EventRepetition::select('id', 'start_repeat', 'end_repeat')
            ->where('event_id', '=', $eventId)
            ->first();

       /* DB::table('event_repetitions')
            ->select('id', 'start_repeat', 'end_repeat')
            ->where('event_id', '=', $event->id)
            ->first();*/
    }

    /**
     * Store EventRepetition
     *
     * @param \App\Http\Requests\EventRepetitionStoreRequest $data
     *
     * @return EventRepetition
     */
    public function store(EventRepetitionStoreRequest $data)
    {
        $eventRepetition = new EventRepetition();

        $eventRepetition->title = $data['title'] ?? null;


        // ......







        $eventRepetition->save();

        //$alert->setStatus(($data['send_as_sms'] == 'on') ? 'approved' : 'pending');

        return $eventRepetition->fresh();
    }

    /**
     * Update EventRepetition
     *
     * @param \App\Http\Requests\EventStoreRequest $data
     * @param int $id
     *
     * @return EventRepetition
     */
    public function update(EventStoreRequest $data, int $id)
    {
        $eventRepetition = $this->getById($id);


        dd('aaa');
        //
        //$eventRepetition->title = $data['title'] ?? null;
        //
        //
        ///
        ///
        ///
        ///
        ///

        $timeStart = date('H:i', strtotime($request->get('time_start')));
        $timeEnd = date('H:i', strtotime($request->get('time_end')));

        switch ($request->get('repeat_type')) {
            case '1':  // noRepeat
                $eventRepetition = new EventRepetition();
                $eventRepetition->event_id = $eventId;

                $dateStart = implode('-', array_reverse(explode('/', $request->get('startDate'))));
                $dateEnd = implode('-', array_reverse(explode('/', $request->get('endDate'))));

                $eventRepetition->start_repeat = $dateStart.' '.$timeStart;
                $eventRepetition->end_repeat = $dateEnd.' '.$timeEnd;
                $eventRepetition->save();

                break;

            case '2':   // repeatWeekly
                // Convert the start date in a format that can be used for strtotime
                $startDate = implode('-', array_reverse(explode('/', $request->get('startDate'))));

                // Calculate repeat until day
                $repeatUntilDate = implode('-', array_reverse(explode('/', $request->get('repeat_until'))));
                EventRepetition::saveWeeklyRepeatDates($eventId, $request->get('repeat_weekly_on_day'), $startDate, $repeatUntilDate, $timeStart, $timeEnd);

                break;

            case '3':  //repeatMonthly
                // Same of repeatWeekly
                $startDate = implode('-', array_reverse(explode('/', $request->get('startDate'))));
                $repeatUntilDate = implode('-', array_reverse(explode('/', $request->get('repeat_until'))));

                // Get the array with month repeat details
                $monthRepeatDatas = explode('|', $request->get('on_monthly_kind'));
                //dump("pp_1");
                EventRepetition::saveMonthlyRepeatDates($eventId, $monthRepeatDatas, $startDate, $repeatUntilDate, $timeStart, $timeEnd);

                break;

            case '4':  //repeatMultipleDays
                // Same of repeatWeekly
                $startDate = implode('-', array_reverse(explode('/', $request->get('startDate'))));

                // Get the array with single day repeat details
                $singleDaysRepeatDatas = explode(',', $request->get('multiple_dates'));

                EventRepetition::saveMultipleRepeatDates($eventId, $singleDaysRepeatDatas, $startDate, $timeStart, $timeEnd);

                break;
        }




        $eventRepetition->update();

        if($eventRepetition->wasChanged()){
            $eventRepetition->setStatus('updated', Auth::id());
        }

        return $eventRepetition;
    }

    /**
     * Delete EventRepetition
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id)
    {
        EventRepetition::destroy($id);
    }


}