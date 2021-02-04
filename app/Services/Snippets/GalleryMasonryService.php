<?php


namespace App\Services\Snippets;

/*
    This class show a Masonry (Pinterest like) responsive gallery.

    Example of snippet that evoke the plugin:
    {# gallery src=[contact_improvisation/gallery_1] width=[400] height=[300] #}
    {# gallery src=[1/background_homepage] width=[400] height=[300] #}

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
        $storagePath = storage_path('app/public');
        $publicPath = public_path();

        // Find plugin occurrences
        //$ptn = '/{# +gallery +(name|width)=\[(.*)\] +(name|width)=\[(.*)\] +(name|width)=\[(.*)\] +#}/';
        $ptn = '/{# +gallery +(name|width)=\[(.*)\] +(name|width)=\[(.*)\] +#}/';

        if (preg_match_all($ptn, $post->body, $matches)) {
            // Trasform the matches array in a way that can be used
            $matches = $this->turn_array($matches);

            foreach ($matches as $key => $single_gallery_matches) {
                // Get plugin parameters array
                $parameters = $this->getParameters($single_gallery_matches, $storagePath, $publicPath);

                ray($parameters);

                if (self::postHasGallery($post, $parameters['gallery_name'])) {
                    $galleryHtml = 'ciao1';

                    $images = $this->createImagesArray($post, $parameters['gallery_name']);

                    // Prepare Gallery HTML
                    $galleryHtml = $this->prepareGallery($images);



                } else {
                    $galleryHtml = "<div class='alert alert-warning' role='alert'>A gallery with this name not available for this element</div>";
                }


                /*if (is_dir($parameters['images_dir'])) {
                    // Get images file name array
                    $image_files = $this->getImageFiles($parameters['images_dir']);
                    //sort($image_files,SORT_STRING);

                    if (! empty($image_files)) {
                        // Get images data from excel
                        //$image_data = $this->getImgDataFromExcel($parameters['images_dir']);
                        $image_data = null;
                        // Generate thumbnails files
                        $this->generateThumbs($parameters['images_dir'], $parameters['thumbs_dir'], $parameters['thumbs_size'], $image_files);

                        // Create Images array [file_path, short_desc, long_desc]
                        $images = $this->createImagesArray($image_files, $image_data, $parameters['gallery_url']);

                        // Prepare Gallery HTML
                        $galleryHtml = $this->prepareGallery($images);
                    } else {
                        $galleryHtml = "<div class='alert alert-warning' role='alert'>The directory specified exist but it doesn't contain images</div>";
                    }
                } else {
                    $galleryHtml = "<div class='alert alert-warning' role='alert'>A gallery with this name not available for this element</div>";
                }*/




                //$galleryHtml = 'ciao';








                $galleryHtml .= "</div>";







                // Replace the TOKEN found in the article with the generatd gallery HTML
                $postBody = str_replace($parameters['token'], $galleryHtml, $post->body);
            }
        }

        return $postBody;
    }

    /**
     *  Returns the plugin parameters.
     *  @param array $matches       result from the regular expression on the string from the article
     *  @return array $ret          the array containing the parameters
     **/
    public function getParameters($matches, $storagePath, $publicPath)
    {
        $ret = [];
        //ray($matches);

        // Get activation string parameters (from article)
        $ret['token'] = $matches[0];

        $ret['gallery_name'] = $matches[2];
        $ret['thumbnail_width'] = $matches[4];

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
     *  Get images files name array.
     *  @param $images_dir           the images dir on the server
     *  @return array $ret           array containing all the images file names
     **/
    public function getImageFiles($images_dir)
    {
        $ret = $this->get_files($images_dir);

        return $ret;
    }

    /**
     *  Prepare the gallery HTML.
     *
     * @param array $images Images array [file_path, short_desc, long_desc]
     *
     * @return string $ret             the HTML to print on screen
     */
    public function prepareGallery(array $images)
    {
        // Animate item on hover
        $itemClass = 'animated';

        // Create Grid—A—Licious grid (id=devices) and print images
        $ret = "<div class='lifeGallery'>";

        foreach ($images as $k => $image) {
            // Get item link
            $imageLink = ($image['video_link'] == null) ? $image['file_path'] : $image['video_link'];
            $videoPlayIcon = ($image['video_link'] == null) ? '' : "<i class='far fa-play-circle'></i>";

            $ret .= "<div class='item " . $itemClass . "'>";
            $ret .= "<a href='" . $imageLink . "' data-fancybox='images' data-caption='" . $image['description'] . "'>";
            $ret .= "<img src='" . asset($image['thumb_path']) . "' />";
            $ret .= $videoPlayIcon;
            $ret .= '</a>';
            $ret .= '</div>';
        }

        $ret .= '</div>';

        return $ret;
    }

    /**
     *  Returns files from dir.
     *  @param string $images_dir                 The images directory
     *  @param array $exts     the file types (actually doesn't work the thumb with png, it's to study why)
     *  @return array $files             the files array
     **/
    public function get_files($images_dir, $exts = ['jpg'])
    {
        $files = [];

        if ($handle = opendir($images_dir)) {
            while (false !== ($file = readdir($handle))) {
                $extension = strtolower($this->get_file_extension($file));
                if ($extension && in_array($extension, $exts)) {
                    $files[] = $file;
                }
            }
            closedir($handle);
        }

        return $files;
    }

    /**
     *  Returns a file's extension.
     *  @param string $file_name        the file name
     *  @return string                  the extension
     **/
    public function get_file_extension($file_name)
    {
        return substr(strrchr($file_name, '.'), 1);
    }

    /**
     *  Turn array of the metches after preg_match_all function (taken from - https://secure.php.net/manual/en/function.preg-match-all.php).
     *  @param array $file_name        the file name
     *  @return array $ret             the extension
     **/
    public function turn_array($m)
    {
        for ($z = 0; $z < count($m); $z++) {
            for ($x = 0; $x < count($m[$z]); $x++) {
                $ret[$x][$z] = $m[$z][$x];
            }
        }

        return $ret;
    }

}