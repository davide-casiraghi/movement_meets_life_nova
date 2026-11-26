<?php

namespace Tests\Unit;

use App\Models\Appointment;
use App\Enums\AppointmentStatus;
use App\Models\User;
use App\Services\Gestionale\AvailabilityFinder;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AvailabilityFinderTest extends TestCase
{
    use RefreshDatabase;

    private User $pro;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'gestionale.timezone' => 'Europe/Rome',
            'gestionale.slot_step_minutes' => 30,
            'gestionale.working_hours' => [
                1 => [['09:00', '12:00']], 2 => [], 3 => [], 4 => [], 5 => [], 6 => [], 7 => [],
            ],
        ]);
        $this->pro = User::factory()->create();
    }

    /** Monday 30 November 2026, Rome time. */
    private function monday(string $time = '00:00'): CarbonImmutable
    {
        return CarbonImmutable::parse("2026-11-30 {$time}", 'Europe/Rome');
    }

    private function slots(int $duration, ?CarbonImmutable $now = null): array
    {
        return (new AvailabilityFinder)
            ->find($duration, [$this->pro->id], $this->monday(), 1, now: $now ?? $this->monday('06:00'))
            ->map(fn ($s) => $s['start']->format('H:i'))
            ->all();
    }

    #[Test]
    public function anEmptyDayOffersEveryStepThatFitsInTheOpeningHours(): void
    {
        $this->assertSame(['09:00', '09:30', '10:00', '10:30', '11:00'], $this->slots(60));
    }

    #[Test]
    public function busyTimeIsSkippedAndTheEndOfAnEventIsProposed(): void
    {
        Appointment::factory()->create([
            'user_id' => $this->pro->id,
            'starts_at' => $this->monday('09:00')->utc(),
            'ends_at' => $this->monday('09:40')->utc(),
        ]);

        $this->assertSame(['09:40', '10:00', '10:30', '11:00', '11:30'], $this->slots(30));
    }

    #[Test]
    public function cancelledEventsDoNotBlockAndUnassignedOnesBlockEverybody(): void
    {
        Appointment::factory()->create([
            'user_id' => $this->pro->id,
            'status' => AppointmentStatus::Cancelled,
            'starts_at' => $this->monday('09:00')->utc(),
            'ends_at' => $this->monday('10:00')->utc(),
        ]);
        Appointment::factory()->create([
            'user_id' => null,
            'starts_at' => $this->monday('10:00')->utc(),
            'ends_at' => $this->monday('12:00')->utc(),
        ]);

        $this->assertSame(['09:00', '09:30'], $this->slots(30));
    }

    #[Test]
    public function pastSlotsAndClosedDaysAreNotOffered(): void
    {
        $this->assertSame(['10:30', '11:00', '11:30'], $this->slots(30, $this->monday('10:15')));

        $tuesday = (new AvailabilityFinder)->find(30, [$this->pro->id], $this->monday()->addDay(), 1, now: $this->monday());
        $this->assertCount(0, $tuesday);
    }

    #[Test]
    public function aSlotListsWhichProfessionalsAreFree(): void
    {
        $other = User::factory()->create();
        Appointment::factory()->create([
            'user_id' => $this->pro->id,
            'starts_at' => $this->monday('09:00')->utc(),
            'ends_at' => $this->monday('12:00')->utc(),
        ]);

        $slots = (new AvailabilityFinder)->find(60, [$this->pro->id, $other->id], $this->monday(), 1, now: $this->monday());

        $this->assertSame('09:00', $slots->first()['start']->format('H:i'));
        $this->assertSame([$other->id], $slots->first()['professional_ids']);
    }
}
