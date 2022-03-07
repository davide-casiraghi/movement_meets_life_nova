<?php

/**
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

use App\Http\Controllers\BookATreatmentController;
use App\Http\Controllers\ContactMeController;
use App\Http\Controllers\EventCategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\IntakeFormController;
use App\Http\Controllers\GlobalSearchController;
use App\Http\Controllers\GlossaryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\InsightController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PostCategoryController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\StaticPageController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\DatabaseBackupsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\Honeypot\ProtectAgainstSpam;

/**
 *    Dashboard Routes
 */

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {

    Route::name('dashboard.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('index');
    });

    // Users
    Route::name('users.')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('index');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('update');
        Route::get('/users/create', [UserController::class, 'create'])->name('create');
        Route::post('/users', [UserController::class, 'store'])->name('store');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('destroy');
    });

    // Teams
    Route::name('teams.')->group(function () {
        Route::get('/teams', [TeamController::class, 'index'])->name('index');
        Route::get('/teams/{id}/edit', [TeamController::class, 'edit'])->name('edit');
        Route::put('/teams/{id}', [TeamController::class, 'update'])->name('update');
        Route::get('/teams/create', [TeamController::class, 'create'])->name('create');
        Route::post('/teams', [TeamController::class, 'store'])->name('store');
        Route::delete('/teams/{id}', [TeamController::class, 'destroy'])->name('destroy');
    });
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');


    // Posts
    Route::name('posts.')->group(function () {
        Route::get('/posts', [PostController::class, 'index'])->name('index');
        Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('edit');
        Route::put('/posts/{id}', [PostController::class, 'update'])->name('update');
        Route::get('/posts/create', [PostController::class, 'create'])->name('create');
        Route::post('/posts', [PostController::class, 'store'])->name('store');
        Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('destroy');
    });

    // Tags
    Route::name('tags.')->group(function () {
        Route::get('/tags', [TagController::class, 'index'])->name('index');
        Route::get('/tags/{id}/edit', [TagController::class, 'edit'])->name('edit');
        Route::put('/tags/{id}', [TagController::class, 'update'])->name('update');
        Route::get('/tags/create', [TagController::class, 'create'])->name('create');
        Route::post('/tags', [TagController::class, 'store'])->name('store');
        Route::delete('/tags/{id}', [TagController::class, 'destroy'])->name('destroy');
    });

    // Glossaries
    Route::name('glossaries.')->group(function () {
        Route::get('/glossaries', [GlossaryController::class, 'index'])->name('index');
        Route::get('/glossaries/{id}/edit', [GlossaryController::class, 'edit'])->name('edit');
        Route::put('/glossaries/{id}', [GlossaryController::class, 'update'])->name('update');
        Route::get('/glossaries/create', [GlossaryController::class, 'create'])->name('create');
        Route::post('/glossaries', [GlossaryController::class, 'store'])->name('store');
        Route::delete('/glossaries/{id}', [GlossaryController::class, 'destroy'])->name('destroy');
    });

    // Teachers
    Route::name('teachers.')->group(function () {
        Route::get('/teachers', [TeacherController::class, 'index'])->name('index');
        Route::get('/teachers/{id}/edit', [TeacherController::class, 'edit'])->name('edit');
        Route::put('/teachers/{id}', [TeacherController::class, 'update'])->name('update');
        Route::get('/teachers/create', [TeacherController::class, 'create'])->name('create');
        Route::post('/teachers', [TeacherController::class, 'store'])->name('store');
        Route::delete('/teachers/{id}', [TeacherController::class, 'destroy'])->name('destroy');
    });

    // Organizers
    Route::name('organizers.')->group(function () {
        Route::get('/organizers', [OrganizerController::class, 'index'])->name('index');
        Route::get('/organizers/{id}/edit', [OrganizerController::class, 'edit'])->name('edit');
        Route::put('/organizers/{id}', [OrganizerController::class, 'update'])->name('update');
        Route::get('/organizers/create', [OrganizerController::class, 'create'])->name('create');
        Route::post('/organizers', [OrganizerController::class, 'store'])->name('store');
        Route::delete('/organizers/{id}', [OrganizerController::class, 'destroy'])->name('destroy');
    });

    // Venues
    Route::name('venues.')->group(function () {
        Route::get('/venues', [VenueController::class, 'index'])->name('index');
        Route::get('/venues/{id}/edit', [VenueController::class, 'edit'])->name('edit');
        Route::put('/venues/{id}', [VenueController::class, 'update'])->name('update');
        Route::get('/venues/create', [VenueController::class, 'create'])->name('create');
        Route::post('/venues', [VenueController::class, 'store'])->name('store');
        Route::delete('/venues/{id}', [VenueController::class, 'destroy'])->name('destroy');
        Route::get('/venues/{id}', [VenueController::class, 'show'])->name('show');
    });

    // Events
    Route::name('events.')->group(function () {
        Route::get('/events', [EventController::class, 'index'])->name('index');
        Route::get('/events/{id}/edit', [EventController::class, 'edit'])->name('edit');
        Route::put('/events/{id}', [EventController::class, 'update'])->name('update');
        Route::get('/events/create', [EventController::class, 'create'])->name('create');
        Route::post('/events', [EventController::class, 'store'])->name('store');
        Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('destroy');

        Route::get('/event/monthSelectOptions/', [EventController::class, 'calculateMonthlySelectOptions'])->name('monthSelectOptions');  // To populate the event repeat by month options
    });

    // Event categories
    Route::resource('eventCategories', EventCategoryController::class);

    // Posts categories
    Route::resource('postCategories', PostCategoryController::class);

    // Quotes
    Route::name('quotes.')->group(function () {
        Route::get('/quotes', [QuoteController::class, 'index'])->name('index');
        Route::get('/quotes/{id}/edit', [QuoteController::class, 'edit'])->name('edit');
        Route::put('/quotes/{id}', [QuoteController::class, 'update'])->name('update');
        Route::get('/quotes/create', [QuoteController::class, 'create'])->name('create');
        Route::post('/quotes', [QuoteController::class, 'store'])->name('store');
        Route::delete('/quotes/{id}', [QuoteController::class, 'destroy'])->name('destroy');
        Route::get('/quotes/{id}', [QuoteController::class, 'show'])->name('show');
    });

    // Testimonials
    Route::name('testimonials.')->group(function () {
        Route::get('/testimonials', [TestimonialController::class, 'index'])->name('index');
        Route::get('/testimonials/{id}/edit', [TestimonialController::class, 'edit'])->name('edit');
        Route::put('/testimonials/{id}', [TestimonialController::class, 'update'])->name('update');
        Route::delete('/testimonials/{id}', [TestimonialController::class, 'destroy'])->name('destroy');
        Route::get('/testimonials/{id}', [TestimonialController::class, 'show'])->name('show')->where('id', '[0-9]+');;
    });

    // Insights
    Route::name('insights.')->group(function () {
        Route::get('/insights', [InsightController::class, 'index'])->name('index');
        Route::get('/insights/create', [InsightController::class, 'create'])->name('create');
        Route::get('/insights/{insight}/edit', [InsightController::class, 'edit'])->name('edit');
        Route::post('/insights', [InsightController::class, 'store'])->name('store');
        Route::put('/insights/{insight}', [InsightController::class, 'update'])->name('update');
        Route::delete('/insights/{insight}', [InsightController::class, 'destroy'])->name('destroy');
        Route::get('/insights/twitter/{insight}', [InsightController::class, 'twitter'])->name('twitter');
    });

    // Medias
    Route::name('medias.')->group(function () {
        Route::get('/medias', [MediaController::class, 'edit'])->name('edit');
        Route::put('/medias/{id}', [MediaController::class, 'update'])->name('update');
    });

    // Database backups (shows and allows to edit db backups created with Spatie db backup)
    Route::name('databaseBackups.')->group(function () {
        Route::get('/databaseBackups', [DatabaseBackupsController::class, 'index'])->name('index');
        Route::get('/databaseBackups/{fileName}', [DatabaseBackupsController::class, 'download'])->name('download');
        Route::delete('/databaseBackups/{fileName}', [DatabaseBackupsController::class, 'destroy'])->name('destroy');
    });

    Route::get('/search', [GlobalSearchController::class, 'index'])->name('globalSearch');
    Route::post('/tinymce_upload', [ImageUploadController::class, 'upload']);
});


/**
 *    Guest Routes
 */

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function(){

    Route::name('postComments.')->group(function () {
        Route::post('/postComment', [PostCommentController::class, 'store'])->name('store')->middleware(ProtectAgainstSpam::class);
    });

    //Route::get('tag/{tagId}',[ TagController::class, 'show'])->name('tags.show');
    Route::get('glossaries/{glossary:slug}', [ GlossaryController::class, 'show'])->name('glossaries.show');

    Route::get('/contact', [ContactMeController::class, 'index'])->name('contact.index');
    Route::post('/contact', [ContactMeController::class, 'store'])->name('contact.store')->middleware(ProtectAgainstSpam::class);

    Route::get('/', [ HomeController::class, 'index'])->name('home');
    Route::get('/blog', [PostController::class, 'blog'])->name('posts.blog');
    Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/insights/{insight}', [InsightController::class, 'show'])->name('show');
    Route::get('/insightsFeed', [InsightController::class, 'feed'])->name('insightsFeed');
    Route::get('/tags/{tag:slug}', [TagController::class, 'show'])->name('tags.show');
    Route::get('/next-events', [EventController::class, 'nextEvents'])->name('events.next');
    Route::get('/past-events', [EventController::class, 'pastEvents'])->name('events.past');
    Route::get('/about-me', [StaticPageController::class, 'aboutMe'])->name('staticPages.aboutMe');
    Route::get('/treatments-ilan-lev-method', [StaticPageController::class, 'treatments'])->name('staticPages.treatments');
    Route::get('/learn-more-ilan-lev-method', [StaticPageController::class, 'treatmentsLearnMore'])->name('staticPages.treatmentsLearnMore');
    Route::get('/contact-improvisation', [StaticPageController::class, 'contactImprovisation'])->name('staticPages.contactImprovisation');
    Route::get('/water-contact', [StaticPageController::class, 'waterContact'])->name('staticPages.waterContact');
    Route::get('/events/{event:slug}', [EventController::class, 'show'])->name('events.show');
    Route::get('/testimonials/create', [TestimonialController::class, 'create'])->name('testimonials.create');
    Route::post('/testimonials', [TestimonialController::class, 'store'])->name('testimonials.store')->middleware(ProtectAgainstSpam::class);;

    Route::get('/teachers/{teacher:slug}', [TeacherController::class, 'show'])->name('teachers.show');
    Route::get('/organizers/{organizer:slug}', [OrganizerController::class, 'show'])->name('organizers.show');

    // Intake form
    Route::get('/intake-form', [IntakeFormController::class, 'create'])->name('intakeForm.create');
    Route::post('/intake-form', [IntakeFormController::class, 'store'])->name('intakeForm.store')->middleware(ProtectAgainstSpam::class);;

    // Book a treatment
    Route::get('/book-a-treatment', [BookATreatmentController::class, 'create'])->name('bookATreatment.create');
    Route::get('/book-a-treatment-confirmation', [BookATreatmentController::class, 'confirmed'])->name('bookATreatment.confirmed');


    });
