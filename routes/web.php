<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\AttachmentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\AgencyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class,"index"])->name('home');

Route::get('/nos-biens', [ListingController::class, 'index'])->name('properties.index');
Route::get('/pages/{slug}', [HomeController::class, 'show'])->name('page.show');
Route::get('/articles', [BlogController::class, 'index'])->name('blog.index');
Route::get('/article/{post}', [BlogController::class, 'show'])->name('post.show');
Route::post('/articles',[PostController::class,'index'])->name('blog.search');
Route::get('/promotions', [ListingController::class, 'promos'])->name('promotions.index');
Route::get('/promotions/{promotion}', [ListingController::class,'showPromo'])->name('promotions.show');
Route::get('/contact',[ContactController::class,'index'])->name('contact');
Route::post('/contact-agency', [HomeController::class, 'sendContactForm'])->name('property.contact');
Route::post('/contact-form', [ContactController::class, 'submitContactForm'])->name('contact.form');

Route::prefix('admin')->name('admin.')->middleware(['auth','auth.isAdmin'])->group(function () {
    Route::resource('promotions', PromotionController::class);
    Route::resource('posts', PostController::class);
    Route::resource('pages', PageController::class);
    Route::resource('menus', MenuController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('users', UserController::class);
    Route::resource('agencies', AgencyController::class);
    Route::post('/attachments',[AttachmentController::class,"store"])->name('attachments.store');
    Route::delete('/promotions/{promotion}/media/{media}', [PromotionController::class,
    'deleteMedia'])->name('promotions.media.delete');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index') ;
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
