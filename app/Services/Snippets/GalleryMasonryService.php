<?php


namespace App\Services\Snippets;

/*
    This class show a Masonry (Pinterest like) responsive gallery.

    Example of snippet that evoke the plugin:
    {# gallery name=[pere] hover_animate=[true] #}

    The snippet can be placed in any blog post.

    The gallery is using this javascript plugin:
        // https://www.npmjs.com/package/justifiedGallery
        // http://miromannino.github.io/Justified-Gallery/
        // Options: http://miromannino.github.io/Justified-Gallery/options-and-events/
*/

use App\Models\Post;

class GalleryMasonryService
{

    /**
     *  Substitute gallery snippets with the related HTML
     *
     * @param \App\Models\Post $post
     *
     * @return string
     */
    public function snippetsToHTML(Post $post): string
    {
        // Find snippet occurrences
        //$ptn = '/{# +gallery +(name|width)=\[(.*)\] +(name|width)=\[(.*)\] +(name|width)=\[(.*)\] +#}/';
        $ptn = '/{# +gallery +(name|hover_animate)=\[(.*)\] +(name|hover_animate)=\[(.*)\] +#}/';

        if (preg_match_all($ptn, $post->body, $matches)) {

            // Trasform the matches array in a way that can be used
            $matches = $this->turnArray($matches);

            foreach ($matches as $key => $single_gallery_matches) {
                $parameters = $this->getParameters($single_gallery_matches);

                if (self::postHasGallery($post, $parameters['gallery_name'])) {
                    $images = $this->createImagesArray($post, $parameters['gallery_name']);

                    $galleryHtml = $this->prepareGalleryHtml($images, $parameters['hover_animate']);
                } else {
                    $galleryHtml = "<div class='alert alert-warning' role='alert'>A gallery with this name not available for this element</div>";
                }

                $galleryHtml .= "</div>";

                // Replace the TOKEN found in the article with the generatd gallery HTML
                $postBody = str_replace($parameters['token'], $galleryHtml, $post->body);
            }
        } else {
            $postBody = $post->body;
        }

        return $postBody;
    }

    /**
     *  Returns the plugin parameters.
     *
     * @param array $matches
     *
     * @return array $ret
     */
    public function getParameters(array $matches): array
    {
        $ret = [];
        //ray($matches);

        // Get activation string parameters (from article)
        $ret['token'] = $matches[0];

        $ret['gallery_name'] = $matches[2];
        $ret['hover_animate'] = filter_var($matches[4], FILTER_VALIDATE_BOOLEAN);

        //ray($ret);
        return $ret;
    }

    /**
     *  Returns true if the post has the specified gallery.
     *
     * @param \App\Models\Post $post
     * @param string $galleryName
     *
     * @return bool $ret
     */
    public function postHasGallery(Post $post, string $galleryName): bool
    {
        if (in_array($galleryName, self::getGalleryNames($post))) {
            return true;
        }
        return false;
    }

    /**
     * Return the array with the gallery names.
     * The gallery names are set as an image property.
     *
     * @param \App\Models\Post $post
     *
     * @return array
     */
    public function getGalleryNames(Post $post): array
    {
        $galleries = [];
        foreach ($post->getMedia('images') as $image) {
            $galleries[$image->getCustomProperty('image_gallery')] = $image->getCustomProperty('image_gallery');
        }
        return array_values($galleries);
    }

    /**
     * Return the array with the gallery images.
     *
     * @param \App\Models\Post $post
     * @param string $galleryName
     *
     * @return array
     */
    public function getGalleryImages(Post $post, string $galleryName): array
    {
        $galleryImages = [];
        foreach ($post->getMedia('images') as $image) {
            if ($image->getCustomProperty('image_gallery') == $galleryName) {
                $galleryImages[] = $image;
            }
        }
        return $galleryImages;
    }


    /**
     *  Create images array.
     *
     * @param \App\Models\Post $post
     * @param string $galleryName
     *
     * @return array $ret    array with the images datas
     */
    public function createImagesArray(Post $post, string $galleryName): array
    {
        $images = self::getGalleryImages($post, $galleryName);

        // Order by image name
        //sort($image_files);

        $ret = [];

        foreach ($images as $k => $image) {
            $ret[$k]['file_path'] = $image->getUrl();
            $ret[$k]['thumb_path'] = $image->getUrl('thumb');

            $ret[$k]['description'] = $image->getCustomProperty('image_description');
            $ret[$k]['video_link'] = $image->getCustomProperty('image_video_url');
        }

        return $ret;
    }

    /**
     *  Prepare the gallery HTML.
     *
     * @param array $images
     * @param bool $hoverAnimate
     *
     * @return string $ret
     */
    public function prepareGalleryHtml(array $images, bool $hoverAnimate): string
    {
        // Animate item on hover
        $itemClass = ($hoverAnimate) ? 'transform transition hover:scale-110 motion-reduce:transform-none duration-500' : '';

        // Create Grid—A—Licious grid (id=devices) and print images
        $ret = "<div class='lifeGallery'>";

        foreach ($images as $k => $image) {
            // Get item link
            $imageLink = ($image['video_link'] == null) ? $image['file_path'] : $image['video_link'];
            $videoPlayIcon = ($image['video_link'] == null) ? '' : "<i class='far fa-play-circle absolute text-6xl text-white inset-center opacity-80'></i>";

            $ret .= "<div class='item " . $itemClass . "'>";
            $ret .= "<a href='" . $imageLink . "' data-fancybox='images' data-caption='" . $image['description'] . "'>";
            $ret .= "<img src='" . asset($image['thumb_path']) . "' />";
            $ret .= $videoPlayIcon;
            $ret .= '</a>';
            $ret .= "<div class='jg-caption'>Never stop climbing</div>";
            $ret .= '</div>';
        }

        $ret .= '</div>';

        return $ret;
    }


    /**
     *  Turn array of the metches after preg_match_all function.
     *  https://secure.php.net/manual/en/function.preg-match-all.php
     *
     * @param array $m
     * @return array $ret
     */
    public function turnArray(array $m): array
    {
        for ($z = 0; $z < count($m); $z++) {
            for ($x = 0; $x < count($m[$z]); $x++) {
                $ret[$x][$z] = $m[$z][$x];
            }
        }

        return $ret;
    }

}