<?php


namespace App\Services\Post;

/* Calculate the estimated reading time for a given piece of $content in minutes.
 *
 * Average reading speed is between 230-280 words per minute,
 * so he using 200 here is keeping some limit to provide pessimistic reading time.
 * Most of people should read it faster.
 *
 * @param string $content Content to calculate read time for.
 * @param int $wpm Estimated words per minute of reader.
 *
 * @return string estimated read time eg. 1 minute, 30 seconds
*/

class CalculateReadingTime {

    public static function post_estimated_reading_time( $content = '', $wpm = 200 ) {
        /*$clean_content = strip_shortcodes( $content );
        $clean_content = strip_tags( $clean_content );
        $word_count = str_word_count( $clean_content );
        $time = ceil( $word_count / $wpm );
        return $time;*/

        $word_count = str_word_count(strip_tags($content));

        $minutes = floor($word_count / $wpm);
        $seconds = floor($word_count % $wpm / ($wpm / 60));

        $str_minutes = ($minutes == 1) ? "minute" : "minutes";
        $str_seconds = ($seconds == 1) ? "second" : "seconds";

        if ($minutes == 0) {
            return "{$seconds} {$str_seconds}";
        }
        else {
            return "{$minutes} {$str_minutes}, {$seconds} {$str_seconds}";
        }

    }
}