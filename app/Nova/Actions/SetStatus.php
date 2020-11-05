<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;

class SetStatus extends Action
{
    use InteractsWithQueue, Queueable;

    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {

            // The normal function to set the Status
            $model->setStatus($fields->status);
        }
    }

    public function fields()
    {
        return [
            Select::make('Status')->options([
                'Unpublished' => 'Unpublished',
                'Published' => 'Published',
            ])->displayUsingLabels()
        ];
    }
}
