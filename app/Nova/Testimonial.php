<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\NovaTranslatable\Translatable;

use App\Nova\Actions\SetStatus;

class Testimonial extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Testimonial::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'author';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'author', 'profession',
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
            Text::make('First Name')
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('Last Name')
                ->sortable()
                ->rules('required', 'max:255'),
            Translatable::make([
                Text::make('Profession')
                    ->sortable(),
                Trix::make('Feedback')
                    ->sortable()
                    ->rules('required')
                    ->hideFromIndex(),
            ]),
            Image::make('Photo')
                ->disk('public')
                ->maxWidth(500)
                ->hideFromIndex(),
            Boolean::make('Personal Data Agreement'),
            Boolean::make('Publish Agreement'),

            Text::make('Status', 'status')
                ->exceptOnForms(),
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
