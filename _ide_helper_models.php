<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Event
 *
 * @property int $id
 * @property int $event_category_id
 * @property int $event_venue_id
 * @property int $user_id
 * @property string $title
 * @property array $description
 * @property string|null $image
 * @property string|null $contact_email
 * @property string|null $website_event_link
 * @property string|null $facebook_event_link
 * @property string|null $status
 * @property \Illuminate\Support\Carbon $date_start
 * @property \Illuminate\Support\Carbon $date_end
 * @property string $slug
 * @property string $is_published
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\EventCategory $category
 * @property-read array $translations
 * @property-read \App\Models\Venue $venue
 * @method static \Illuminate\Database\Eloquent\Builder|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereContactEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDateEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDateStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereEventCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereEventVenueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereFacebookEventLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereWebsiteEventLink($value)
 */
	class Event extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EventCategory
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Event[] $events
 * @property-read int|null $events_count
 * @method static \Illuminate\Database\Eloquent\Builder|EventCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|EventCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventCategory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventCategory whereUpdatedAt($value)
 */
	class EventCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EventVenue
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string|null $image
 * @property string|null $website
 * @property string|null $extra_info
 * @property string|null $address
 * @property string $city
 * @property string|null $state_province
 * @property string $country
 * @property string|null $zip_code
 * @property float|null $lng
 * @property float|null $lat
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Event[] $events
 * @property-read int|null $events_count
 * @method static \Illuminate\Database\Eloquent\Builder|Venue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Venue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Venue query()
 * @method static \Illuminate\Database\Eloquent\Builder|Venue whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venue whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venue whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venue whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venue whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venue whereExtraInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venue whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venue whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venue whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venue whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venue whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venue whereStateProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venue whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venue whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venue whereZipCode($value)
 */
	class EventVenue extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Glossary
 *
 * @property int $id
 * @property array|null $term
 * @property array $definition
 * @property array $body
 * @property int $is_published
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read array $translations
 * @method static \Illuminate\Database\Eloquent\Builder|Glossary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Glossary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Glossary query()
 * @method static \Illuminate\Database\Eloquent\Builder|Glossary whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Glossary whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Glossary whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Glossary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Glossary whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Glossary whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Glossary whereTerm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Glossary whereUpdatedAt($value)
 */
	class Glossary extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Insight
 *
 * @property int $id
 * @property array|null $title
 * @property array $description
 * @property string|null $introimage
 * @property array|null $introimage_alt
 * @property int $is_posted_on_facebook
 * @property int $is_posted_on_twitter
 * @property \Illuminate\Support\Carbon|null $published_on_facebook_on
 * @property \Illuminate\Support\Carbon|null $published_on_twitter_on
 * @property int $is_published
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read array $translations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Post[] $posts
 * @property-read int|null $posts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Insight newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Insight newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Insight query()
 * @method static \Illuminate\Database\Eloquent\Builder|Insight whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Insight whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Insight whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Insight whereIntroimage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Insight whereIntroimageAlt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Insight whereIsPostedOnFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Insight whereIsPostedOnTwitter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Insight whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Insight wherePublishedOnFacebookOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Insight wherePublishedOnTwitterOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Insight whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Insight whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Insight whereUpdatedAt($value)
 */
	class Insight extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Inspiration
 *
 * @property int $id
 * @property string|null $author
 * @property string $description
 * @property int $is_published
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Inspiration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Inspiration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Inspiration query()
 * @method static \Illuminate\Database\Eloquent\Builder|Inspiration whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inspiration whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inspiration whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inspiration whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inspiration whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inspiration whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inspiration whereUpdatedAt($value)
 */
	class Inspiration extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Mantra
 *
 * @property int $id
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Mantra newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mantra newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mantra query()
 * @method static \Illuminate\Database\Eloquent\Builder|Mantra whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mantra whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mantra whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mantra whereUpdatedAt($value)
 */
	class Mantra extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Post
 *
 * @property int $id
 * @property int $category_id
 * @property array $title
 * @property int|null $created_by
 * @property array $intro_text
 * @property array $body
 * @property int $featured
 * @property string|null $before_content
 * @property string|null $after_content
 * @property string|null $introimage
 * @property array|null $introimage_alt
 * @property string|null $publish_at
 * @property string|null $publish_until
 * @property int $is_published
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read array $translations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Insight[] $insights
 * @property-read int|null $insights_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \App\Models\PostCategory $post_category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereAfterContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereBeforeContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereIntroText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereIntroimage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereIntroimageAlt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePublishAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePublishUntil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedAt($value)
 */
	class Post extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\PostCategory
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Post[] $post
 * @property-read int|null $post_count
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory whereUpdatedAt($value)
 */
	class PostCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Quote
 *
 * @property int $id
 * @property string|null $author
 * @property array $description
 * @property int $is_published
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read array $translations
 * @method static \Illuminate\Database\Eloquent\Builder|Quote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Quote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Quote query()
 * @method static \Illuminate\Database\Eloquent\Builder|Quote whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quote whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quote whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quote whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quote whereUpdatedAt($value)
 */
	class Quote extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Tag
 *
 * @property int $id
 * @property array $tag
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read array $translations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Insight[] $insights
 * @property-read int|null $insights_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Post[] $posts
 * @property-read int|null $posts_count
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereTag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereUpdatedAt($value)
 */
	class Tag extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Testimonial
 *
 * @property int $id
 * @property string|null $author
 * @property array|null $profession
 * @property array|null $description
 * @property string|null $photo
 * @property int $is_published
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read array $translations
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial query()
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial whereProfession($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial whereUpdatedAt($value)
 */
	class Testimonial extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $remember_token
 * @property int|null $current_team_id
 * @property string|null $profile_photo_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $profile_photo_url
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Post[] $post
 * @property-read int|null $post_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

