<?php

namespace App\Services\Gestionale;

use App\Models\Appointment;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;

/**
 * Finds the free time slots of the practice ("Trova disponibilità").
 *
 * A slot is free for a professional when it falls inside the opening hours
 * (config gestionale.working_hours) and does not overlap any of their events
 * that block time. Events without a professional block everybody.
 *
 * Candidate start times are every `slot_step_minutes` from the start of each
 * opening block, plus the end of every event, so gaps right after an
 * appointment are proposed too (e.g. 15:10 after a session ending at 15:10).
 */
class AvailabilityFinder
{
    /**
     * @param  array<int>  $professionalIds  professionals to check
     * @param  array<int>  $weekdays  ISO weekdays to include (1 = Monday)
     * @return Collection<int, array{start: CarbonImmutable, end: CarbonImmutable, professional_ids: array<int>}>
     *                                                                                                         Start and end in the practice time zone, sorted by start.
     */
    public function find(
        int $durationMinutes,
        array $professionalIds,
        CarbonImmutable $fromDay,
        int $days,
        array $weekdays = [1, 2, 3, 4, 5, 6, 7],
        ?int $ignoreAppointmentId = null,
        ?CarbonImmutable $now = null,
    ): Collection {
        $tz = config('gestionale.timezone');
        $step = max(5, (int) config('gestionale.slot_step_minutes', 30));
        $now = ($now ?? CarbonImmutable::now())->setTimezone($tz);
        $firstDay = $fromDay->setTimezone($tz)->startOfDay();
        $lastDay = $firstDay->addDays(max(1, $days));

        if ($durationMinutes < 5 || $professionalIds === []) {
            return collect();
        }

        $events = Appointment::query()
            ->blockingTime()
            ->overlapping($firstDay->utc(), $lastDay->utc())
            ->when($ignoreAppointmentId, fn ($q) => $q->whereKeyNot($ignoreAppointmentId))
            ->where(fn ($q) => $q->whereIn('user_id', $professionalIds)->orWhereNull('user_id'))
            ->get(['id', 'user_id', 'starts_at', 'ends_at'])
            ->map(fn (Appointment $a) => [
                'user_id' => $a->user_id,
                'start' => CarbonImmutable::parse($a->starts_at)->setTimezone($tz),
                'end' => CarbonImmutable::parse($a->ends_at)->setTimezone($tz),
            ]);

        $slots = [];

        for ($day = $firstDay; $day->lt($lastDay); $day = $day->addDay()) {
            if (! in_array($day->isoWeekday(), $weekdays, true)) {
                continue;
            }

            foreach (config('gestionale.working_hours.'.$day->isoWeekday(), []) as [$open, $close]) {
                $blockStart = $day->setTimeFromTimeString($open);
                $blockEnd = $day->setTimeFromTimeString($close);

                foreach ($this->candidateStarts($blockStart, $blockEnd, $step, $events) as $start) {
                    $end = $start->addMinutes($durationMinutes);

                    if ($start->lt($now) || $end->gt($blockEnd)) {
                        continue;
                    }

                    $free = array_values(array_filter(
                        $professionalIds,
                        fn (int $id) => ! $events->contains(fn ($e) => ($e['user_id'] === null || $e['user_id'] === $id)
                            && $e['start']->lt($end) && $e['end']->gt($start)),
                    ));

                    if ($free !== []) {
                        $slots[$start->timestamp] = ['start' => $start, 'end' => $end, 'professional_ids' => $free];
                    }
                }
            }
        }

        ksort($slots);

        return collect(array_values($slots));
    }

    /** @return array<CarbonImmutable> */
    private function candidateStarts(CarbonImmutable $blockStart, CarbonImmutable $blockEnd, int $step, Collection $events): array
    {
        $starts = [];

        for ($t = $blockStart; $t->lt($blockEnd); $t = $t->addMinutes($step)) {
            $starts[$t->timestamp] = $t;
        }

        foreach ($events as $event) {
            if ($event['end']->gte($blockStart) && $event['end']->lt($blockEnd)) {
                $starts[$event['end']->timestamp] = $event['end'];
            }
        }

        ksort($starts);

        return array_values($starts);
    }
}
