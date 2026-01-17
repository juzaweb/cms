<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://cms.juzaweb.com
 * @license    GNU V2
 */

use Juzaweb\Themes\Itube\Http\Controllers\ChannelController;
use Juzaweb\Themes\Itube\Http\Controllers\HomeController;
use Juzaweb\Themes\Itube\Http\Controllers\PageController;
use Juzaweb\Themes\Itube\Http\Controllers\PlaylistController;
use Juzaweb\Themes\Itube\Http\Controllers\ProfileController;
use Juzaweb\Themes\Itube\Http\Controllers\SearchController;
use Juzaweb\Themes\Itube\Http\Controllers\VideoCategoryController;
use Juzaweb\Themes\Itube\Http\Controllers\VideoController;
use Juzaweb\Themes\Itube\Http\Middleware\CanUpdateVideo;
use Juzaweb\Themes\Itube\Http\Controllers\PlayController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/trending', [PageController::class, 'trending'])->name('trending');
Route::get('/history', [PageController::class, 'history'])->name('history');
Route::get('/load-more-videos', [HomeController::class, 'loadMoreVideos'])->name('home.load_more');

Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/search/load-more', [SearchController::class, 'loadMore'])->name('search.load_more');

Route::get('/video/{slug}', [VideoController::class, 'show'])
    ->name('video.show');
Route::get('/video/{slug}/playlists/json', [PlaylistController::class, 'json'])
    ->name('video.playlists.json');
Route::get('/video/{slug}/next-videos', [VideoController::class, 'loadNext'])->name('video.next');

Route::get('video/category/{slug}', [VideoCategoryController::class, 'show'])
    ->name('video_category.show');

Route::get('/channel/{code}', [ChannelController::class, 'show'])
    ->name('channel.show');

Route::get('/@{username}', [ChannelController::class, 'show'])
    ->name('channel.show');

Route::group(
    ['middleware' => ['auth:member', 'verified']],
    function () {
        Route::get('/upload', [VideoController::class, 'upload'])
            ->name('video.upload');

        Route::get('/import', [VideoController::class, 'import'])
            ->name('video.import');

        Route::post('import', [VideoController::class, 'doImport'])
            ->name('import');

        Route::post('upload', [VideoController::class, 'doUpload'])
            ->name('upload');

        Route::post('upload/thumbnail', [VideoController::class, 'uploadThumbnail']);

        Route::post('videos/{video:code}', [VideoController::class, 'update'])
            ->middleware([CanUpdateVideo::class]);
        Route::post('videos/{code}/comments', [VideoController::class, 'comment'])
            ->name('video.comment');
        Route::post('videos/{code}/reaction', [VideoController::class, 'reaction'])
            ->name('video.reaction');

        Route::get('profile', [ProfileController::class, 'index'])
            ->name('profile');
        Route::post('profile', [ProfileController::class, 'update'])
            ->name('profile');

        Route::get('profile/notification', [ProfileController::class, 'notification'])
            ->name('profile.notification');

        Route::get('profile/my-videos', [ProfileController::class, 'myVideos'])
            ->name('profile.my_videos');

        Route::get('profile/my-videos/{id}/edit', [ProfileController::class, 'editVideo'])
            ->name('profile.my_videos.edit');

        Route::put('profile/my-videos/{id}', [ProfileController::class, 'updateVideo'])
            ->name('profile.my_videos.update');

        Route::delete('profile/my-videos/{id}', [ProfileController::class, 'deleteVideo'])
            ->name('profile.my_videos.delete');

        Route::post('profile/my-videos/bulk', [ProfileController::class, 'bulkAction'])
            ->name('profile.my_videos.bulk');

        Route::post('channel/{code}/subscribe', [ChannelController::class, 'subscribe'])
            ->name('channel.subscribe');
    }
);

Route::post('videos/{code}/player', [PlayController::class, 'player'])
    ->name('video.player');

Route::get('/tmps/{path}', function (Illuminate\Http\Request $request) {
    $path = $request->get('path');

    if (!Storage::disk('tmp')->exists($path)) {
        abort(404, 'File not found.');
    }

    return response()->file(Storage::disk('tmp')->path($path));
})
    ->name('tmps.file')
    ->middleware(['signed']);

Route::get('/{slug}', [PageController::class, 'show'])->name('page.show');
