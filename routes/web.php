<?php

use App\Http\Controllers\GlossaryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostCategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ContactUsFormController;
use App\Http\Controllers\BeATestimonialFormController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TestimonialController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[ HomeController::class, 'index'])->name('home');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('posts', PostController::class);
Route::resource('categories', PostCategoryController::class);

Route::get('tag/{tagId}',[ TagController::class, 'show'])->name('tags.show');
Route::get('glossaryTerms/{glossaryTermId}',[ GlossaryController::class, 'show'])->name('glossary.show');

// Contact form
Route::get('/contact', [ContactUsFormController::class, 'index']);
Route::post('/contact', [ContactUsFormController::class, 'ContactUsForm'])->name('contact.store');

// Be a testimonial form
Route::name('testimonials.')->group(function () {
    Route::get('/testimonial', [TestimonialController::class, 'create'])->name('create');
    Route::post('/testimonial', [TestimonialController::class, 'store'])->name('store');
});