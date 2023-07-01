<?php

use App\Http\Controllers\API\V1\{AuthController, CategoryController, CommentController, ContactUsController, ForgotPasswordController, ImageController, PostController, QuoteController, SlideController, StaffController, SubscribeController, TagController, UserController, VideoController};
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->prefix('users')->group(function () {
    Route::get('/', 'index')->name('api-v1.users.index');
    Route::post('/', 'store')->name('api-v1.users.store');
    Route::get('/{user}/show', 'show')->name('api-v1.users.show');
    Route::put('/{user}/update', 'update')->name('api-v1.users.update');
    Route::delete('/{user}/destroy', 'destroy')->name('api-v1.users.destroy');
    Route::post('/{users}/restore', 'restore')->name('api-v1.users.restore');
    Route::delete('/{users}/delete', 'delete')->name('api-v1.users.delete');
    Route::post('/restore-all', 'restoreAll')->name('api-v1.users.restore-all');
    Route::delete('/delete-all', 'deleteAll')->name('api-v1.users.detele-all');
});

Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('/register', 'register')->name('api-v1.auth.register');
    Route::post('/login', 'login')->name('api-v1.auth.login');
    Route::post('/logout', 'logout')->name('api-v1.auth.logout');
    Route::post('/refresh', 'refresh')->name('api-v1.auth.token.refresh');
    Route::post('/me', 'me')->name('api-v1.auth.get.user');
});

Route::controller(ForgotPasswordController::class)->prefix('password')->group(function () {
    Route::post('/forgot', 'forgetPassword')->name('api-v1.password.forgot');
    Route::post('/reset', 'resetPassword')->name('api-v1.password.reset');
});

// Route::controller(UserVerifyController::class)->prefix('verify')->group(function () {
//     Route::get('user', 'sendVerifyMail')->name('api-v1.send.mail_verify');
//     Route::get('user/{verify}', 'getVerifyUser')->name('api-v1.get.verify_user');
// });

Route::controller(ContactUsController::class)->prefix('contacts')->group(function () {
    Route::get('/', 'index')->name('api-v1.contacts.index');
    Route::post('/', 'store')->name('api-v1.contacts.store');
    Route::get('/{contact}/show', 'show')->name('api-v1.contacts.show');
    Route::delete('/{contact}/destroy', 'destroy')->name('api-v1.contacts.destroy');
    Route::post('/{contacts}/restore', 'restore')->name('api-v1.contacts.restore');
    Route::delete('/{contacts}/delete', 'delete')->name('api-v1.contacts.delete');
    Route::post('/restore-all', 'restoreAll')->name('api-v1.contacts.restore-all');
    Route::delete('/delete-all', 'deleteAll')->name('api-v1.contacts.detele-all');
});

Route::controller(SubscribeController::class)->prefix('subscribes')->group(function () {
    Route::get('/', 'index')->name('api-v1.subscribers.index');
    Route::post('/', 'store')->name('api-v1.subscribers.store');
    Route::get('/{subscriber}/show', 'show')->name('api-v1.subscribers.show');
    Route::delete('/{subscriber}/destroy', 'destroy')->name('api-v1.subscribers.destroy');
    Route::post('/{subscribers}/restore', 'restore')->name('api-v1.subscribers.restore');
    Route::delete('/{subscribers}/delete', 'delete')->name('api-v1.subscribers.delete');
    Route::post('/restore-all', 'restoreAll')->name('api-v1.subscribers.restore-all');
    Route::delete('/delete-all', 'deleteAll')->name('api-v1.subscribers.detele-all');
});

Route::controller(CategoryController::class)->prefix('categories')->group(function () {
    Route::get('/', 'index')->name('api-v1.categories.index');
    Route::post('/', 'store')->name('api-v1.categories.store');
    Route::get('/{category}/show', 'show')->name('api-v1.categories.show');
    Route::put('/{category}/update', 'update')->name('api-v1.categories.update');
    Route::delete('/{category}/destroy', 'destroy')->name('api-v1.categories.destroy');
});

Route::controller(TagController::class)->prefix('tags')->group(function () {
    Route::get('/', 'index')->name('api-v1.tags.index');
    Route::post('/', 'store')->name('api-v1.tags.store');
    Route::get('/{tag}/show', 'show')->name('api-v1.tags.show');
    Route::put('/{tag}/update', 'update')->name('api-v1.tags.update');
    Route::delete('/{tag}/destroy', 'destroy')->name('api-v1.tags.destroy');
});

Route::controller(CommentController::class)->prefix('comments')->group(function () {
    Route::get('/', 'index')->name('api-v1.comments.index');
    Route::post('/{comments}', 'store')->name('api-v1.comments.store');
    Route::get('/{comment}/show', 'show')->name('api-v1.comments.show');
    Route::put('/{comment}/update', 'update')->name('api-v1.comments.update');
    Route::delete('/{comment}/destroy', 'destroy')->name('api-v1.comments.destroy');
    Route::post('/{comments}/restore', 'restore')->name('api-v1.comments.restore');
    Route::delete('/{comments}/delete', 'delete')->name('api-v1.comments.delete');
    Route::post('/restore-all', 'restoreAll')->name('api-v1.comments.restore-all');
    Route::delete('/delete-all', 'deleteAll')->name('api-v1.comments.detele-all');
});

Route::controller(PostController::class)->prefix('posts')->group(function () {
    Route::get('/', 'index')->name('api-v1.posts.index');
    Route::post('/', 'store')->name('api-v1.posts.store');
    Route::get('/{post:slug}/show', 'show')->name('api-v1.posts.show');
    Route::put('/{post}/update', 'update')->name('api-v1.posts.update');
    Route::delete('/{post}/destroy', 'destroy')->name('api-v1.posts.destroy');
    Route::post('/{posts}/restore', 'restore')->name('api-v1.posts.restore');
    Route::delete('/{posts}/delete', 'delete')->name('api-v1.posts.delete');
    Route::post('/restore-all', 'restoreAll')->name('api-v1.posts.restore-all');
    Route::delete('/delete-all', 'deleteAll')->name('api-v1.posts.detele-all');
});

Route::controller(ImageController::class)->prefix('image')->group(function () {
    Route::post('/upload', 'uploadImage')->name('api-v1.image.upload');
});

Route::controller(SlideController::class)->prefix('slides')->group(function () {
    Route::get('/', 'index')->name('api-v1.slides.index');
    Route::post('/', 'store')->name('api-v1.slides.store');
    Route::get('/{slide}/show', 'show')->name('api-v1.slides.show');
    Route::put('/{slide}/update', 'update')->name('api-v1.slides.update');
    Route::delete('/{slide}/destroy', 'destroy')->name('api-v1.slides.destroy');
    Route::post('/{slides}/restore', 'restore')->name('api-v1.slides.restore');
    Route::delete('/{slides}/delete', 'delete')->name('api-v1.slides.delete');
    Route::post('/restore-all', 'restoreAll')->name('api-v1.slides.restore-all');
    Route::delete('/delete-all', 'deleteAll')->name('api-v1.slides.detele-all');
});

Route::controller(VideoController::class)->prefix('videos')->group(function () {
    Route::get('/', 'index')->name('api-v1.videos.index');
    Route::post('/', 'store')->name('api-v1.videos.store');
    Route::get('/{video}/show', 'show')->name('api-v1.videos.show');
    Route::put('/{video}/update', 'update')->name('api-v1.videos.update');
    Route::delete('/{video}/destroy', 'destroy')->name('api-v1.videos.destroy');
    Route::post('/{videos}/restore', 'restore')->name('api-v1.videos.restore');
    Route::delete('/{videos}/delete', 'delete')->name('api-v1.videos.delete');
    Route::post('/restore-all', 'restoreAll')->name('api-v1.videos.restore-all');
    Route::delete('/delete-all', 'deleteAll')->name('api-v1.videos.detele-all');
});

Route::controller(QuoteController::class)->prefix('quotes')->group(function () {
    Route::get('/', 'index')->name('api-v1.quotes.index');
    Route::post('/', 'store')->name('api-v1.quotes.store');
    Route::get('/{quote}/show', 'show')->name('api-v1.quotes.show');
    Route::put('/{quote}/update', 'update')->name('api-v1.quotes.update');
    Route::delete('/{quote}/destroy', 'destroy')->name('api-v1.quotes.destroy');
});

Route::controller(StaffController::class)->prefix('staffs')->group(function () {
    Route::get('/', 'index')->name('api-v1.staff.index');
    Route::get('/export', 'export')->name('api-v1.staff.export');
    Route::post('/import', 'import')->name('api-v1.staff.import');
});
