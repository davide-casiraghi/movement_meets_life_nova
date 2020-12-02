<?php

namespace App\Nova;

use App\Nova\Actions\SetStatus;
use DavideCasiraghi\Datefrequency\Datefrequency;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\NovaTranslatable\Translatable;

class Event extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Event::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','title',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->hideFromIndex()->sortable(),
            Text::make('Title')
                ->sortable()
                ->rules('required', 'max:255'),
            Translatable::make([
                Trix::make('Description')
                    ->sortable()
                    ->rules('required'),
            ]),
            Image::make('Image')->disk('public')->hideFromIndex(),
            BelongsTo::make('Event Category', 'category'),
            BelongsTo::make('Event Venue', 'venue')->hideFromIndex()->searchable(), // https://nova.laravel.com/docs/1.0/resources/relationships.html#searchable-relations
            //BelongsTo::make('Event Venue', 'venue', EventVenue::class)->inline()->requireChild(),

            DateTime::make('Date Start')
                ->rules('required', 'date', 'before_or_equal:date_end')  //, 'after_or_equal:now'
                ->format('DD-MM-YYYY hh:mm')->pickerFormat('d-m-Y')->pickerDisplayFormat('d-m-Y  h:m'),
            DateTime::make('Date End')->hideFromIndex()
                ->rules('required', 'date', 'after_or_equal:date_end')
                ->format('DD-MM-YYYY hh:mm')->pickerFormat('d-m-Y')->pickerDisplayFormat('d-m-Y h:m'),

            Text::make('Contact Email')->hideFromIndex(),
            Text::make('Website Event Link')->hideFromIndex(),
            Text::make('Facebook Event Link')->hideFromIndex(),
            Text::make('Status', 'status')
                ->exceptOnForms(),
            Datefrequency::make('Repetitions')->hideFromIndex(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            new SetStatus,
        ];
    }
}
