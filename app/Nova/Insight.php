<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\NovaTranslatable\Translatable;

class Insight extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Insight::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'insight';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','insight',
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
            ID::make(__('ID'), 'id')->sortable(),
            Translatable::make([
                Text::make('Title')
                    ->sortable()
                    ->rules('required', 'max:255'),
                Trix::make('Description')
                    ->rules('required'),
                Text::make('Introimage Alt')->hideFromIndex(),
            ]),
            BelongsTo::make('Post')->searchable(),
            Image::make('Introimage')->disk('public')->hideFromIndex(),

            Boolean::make('Is Published'),
            Boolean::make('Is Posted On Facebook'),
            DateTime::make('Published On Facebook On')
                ->hideFromIndex()
                ->readonly()
                ->format('DD-MM-YYYY hh:mm'),
            Boolean::make('Is Posted On Twitter'),
            DateTime::make('Published On Twitter On')
                ->hideFromIndex()
                ->readonly()
                ->format('DD-MM-YYYY hh:mm'),
            BelongsToMany::make('Tags'),
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
        return [];
    }
}
