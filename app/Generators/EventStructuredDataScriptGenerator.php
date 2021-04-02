<?php


namespace App\Generators;


use App\Models\Event;
use Spatie\SchemaOrg\Schema;
use Spatie\SchemaOrg\Type;

/**
 * Class EventStructuredDataScriptGenerator
 * Generate the script for Event entity.
 *
 * @package App\Generators
 */
class EventStructuredDataScriptGenerator implements StructuredDataScriptGeneratorInterface
{
    private Event $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Generate the script for an Event Schema.org type.
     *
     * @return Type
     */
    public function generate(): Type
    {
        return Schema::danceEvent()
            ->name($this->event->title)
            ->description($this->event->description)
            ->if($this->event->hasMedia('introimage'), function (\Spatie\SchemaOrg\DanceEvent $schema) {
                $schema->image($this->event->getMedia('introimage')->first()->getUrl());
            })
            ->about($this->event->category->name)
            ->startDate($this->event->repetitions()->first()->start_repeat)
            ->endDate($this->event->repetitions()->first()->end_repeat)
            ->performer(Schema::person()
                ->name($this->event->teachers()->first()->name)
            )
            ->organizer(Schema::person()
                ->name($this->event->organizers()->first()->name)
                ->url($this->event->organizers()->first()->website)
            )
            ->location(Schema::place()
                ->name($this->event->venue->name)
                ->address(Schema::postalAddress()
                    ->streetAddress($this->event->venue->address)
                    ->addressLocality($this->event->venue->city)
                    ->addressRegion($this->event->venue->state_province)
                    ->postalCode($this->event->venue->zip_code)
                    ->addressCountry($this->event->venue->country->code)
                )
            );
    }
}