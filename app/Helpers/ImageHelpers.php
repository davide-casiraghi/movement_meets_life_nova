<?php

namespace App\Helpers;

class ImageHelpers
{

    /**
     * Store the uploaded photos in the Spatie Media Library
     *
     * @param object $model
     * @param object $request
     * @param string $collectionName
     *
     * @return void
     */
    public static function storeImages(object $model, object $request, string $collectionName): void
    {
        if (!$request->file($collectionName)) {
            return;
        }

        if (is_array($request->file($collectionName))) { // Store multiple images
            foreach ($request->file($collectionName) as $file) {
                if ($file->isValid()) {
                    $model->addMedia($file)->toMediaCollection($collectionName);
                }
            }
        } else { // Store single image
            $file = $request->file($collectionName);
            if ($file->isValid()) {
                $model->addMedia($file)->toMediaCollection($collectionName);
            }
        }
    }

    /**
     * Delete photos from the Spatie Media Library
     *
     * @param object $model
     * @param object $request
     * @param string $collectionName
     *
     * @return void
     */
    public static function deleteImages(object $model, object $request, string $collectionName): void
    {
        if ($request->introimage_delete == 'true') {
            $mediaItems = $model->getMedia($collectionName);
            if (!is_null($mediaItems[0])) {
                $mediaItems[0]->delete();
            }
        }
    }

    /**
     * Return an array with the thumb images ulrs
     *
     * @param object $model
     * @param string $collectionName
     *
     * @return array
     */
    public static function getThumbsUrls(object $model, string $collectionName): array
    {
        $thumbUrls = [];

        //$model = $this->getById($modelId);
        foreach ($model->getMedia($collectionName) as $photo) {
            $thumbUrls[] = $photo->getUrl('thumb');
        }

        return $thumbUrls;
    }

}
