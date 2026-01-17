<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://cms.juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Themes\Itube\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Intervention\Image\ImageManager;
use Juzaweb\Modules\Core\Enums\VideoSource;
use Juzaweb\Modules\Core\FileManager\MediaUploader;
use Juzaweb\Modules\Core\Http\Controllers\ThemeController;
use Juzaweb\Modules\Core\Http\Requests\CommentRequest;
use Juzaweb\Modules\VideoSharing\Enums\VideoMod;
use Juzaweb\Modules\VideoSharing\Enums\VideoStatus;
use Juzaweb\Modules\VideoSharing\Exceptions\VideoImportException;
use Juzaweb\Modules\VideoSharing\Http\Requests\ImportRequest;
use Juzaweb\Modules\VideoSharing\Models\Channel;
use Juzaweb\Modules\VideoSharing\Models\Video;
use Juzaweb\Themes\Itube\Http\Requests\UploadRequest;
use Juzaweb\Themes\Itube\Http\Requests\VideoUpdateRequest;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use RuntimeException;

class VideoController extends ThemeController
{
    public function show(string $slug): View
    {
        $video = Video::with([
            'media',
            'channel',
            'comments' => fn($query) => $query
                ->with('commented')
                ->whereFrontend()
                ->orderBy('created_at', 'desc')
                ->limit(10)
        ])
            ->withTranslation()
            ->where('status', VideoStatus::PUBLISHED)
            ->whereTranslation('slug', $slug)
            ->firstOrFail();

        $nextVideos = Video::with(['media', 'channel'])
            ->withTranslation()
            ->whereFrontend()
            ->where('id', '!=', $video->id)
            ->latest()
            ->limit(10)
            ->get();
        $viewPage = $video->getViewPageToken();

        return view(
            'itube::video.show',
            compact(
                'video',
                'nextVideos',
                'viewPage'
            )
        );
    }

    public function loadNext(Request $request, string $slug)
    {
        $video = Video::whereFrontend()
            ->whereTranslation('slug', $slug)
            ->firstOrFail();
        $page = $request->input('page', 1);

        if (!is_numeric($page) || $page > 5) {
            return response()->json([
                'html' => '',
                'next_page' => null,
            ]);
        }

        $nextVideos = Video::with(['media', 'channel'])
            ->withTranslation()
            ->whereFrontend()
            ->where('id', '!=', $video->id)
            ->latest()
            ->paginate(10, ['*'], 'page', $page);

        $html = view(
            'itube::components.next-video-items',
            compact('nextVideos')
        )->render();

        return response()->json([
            'html' => $html,
            'next_page' => $nextVideos->nextPageUrl() ? $page + 1 : null,
        ]);
    }

    public function upload()
    {
        return view('itube::upload');
    }

    public function import()
    {
        return view('itube::import');
    }

    public function doImport(ImportRequest $request)
    {
        $user = $request->user();
        try {
            $video = $request->import($user);
        } catch (VideoImportException $e) {
            return $this->error($e->getMessage());
        }

        return $this->success(
            [
                'message' => __('itube::translation.video_imported_successfully'),
                'redirect' => url('video/'.$video->slug),
            ]
        );
    }

    public function doUpload(UploadRequest $request)
    {
        $user = $request->user();

        try {
            $receiver = new FileReceiver('upload', $request, HandlerFactory::classFromRequest($request));
            if ($receiver->isUploaded() === false) {
                throw new UploadMissingFileException();
            }

            $save = $receiver->receive();
            if ($save->isFinished()) {
                /** @var UploadedFile $file */
                $file = $save->getFile();
                $name = $file->getClientOriginalName();

                if (!in_array($file->getMimeType(), config('video.mime_types', []))) {
                    return $this->error(__('itube::translation.invalid_file_type_only_video_files_are_allowed'));
                }

                if ($file->getSize() > config('video.max_size', 104857600)) { // Default 100MB
                    return $this->error(__('itube::translation.file_size_exceeds_the_maximum_limit'));
                }

                $video = DB::transaction(
                    function () use ($file, $name, $user) {
                        $folder = date('Y/m/d');
                        $path = $file->store($folder, ['disk' => 'video']);

                        $channel = Channel::where(['created_by' => $user->id])
                            ->firstOrCreate(
                                [
                                    'name' => $user->name,
                                ],
                                [
                                    'created_by' => $user->id,
                                ]
                            );

                        $video = Video::create(
                            [
                                'channel_id' => $channel->id,
                                'mode' => VideoMod::PUBLIC,
                                'status' => VideoStatus::PENDING,
                                'created_by' => $user->id,
                                config('translatable.fallback_locale') => [
                                    'title' => $name,
                                ],
                            ]
                        );

                        $video->files()->create(
                            [
                                'path' => $path,
                                'source' => VideoSource::UPLOAD,
                                'quality' => '720p',
                                'disk' => 'video',
                            ]
                        );

                        return $video;
                    }
                );

                return response()->json(
                    [
                        'success' => true,
                        'message' => __('itube::translation.video_uploaded_successfully'),
                        'code' => $video->code,
                    ]
                );
            }

            $handler = $save->handler();

            return response()->json(
                [
                    "done" => $handler->getPercentageDone(),
                    'status' => true,
                ]
            );
        } catch (Exception $e) {
            report($e);
            return $this->error(__('itube::translation.an_error_occurred_during_the_upload_process_message',
                ['message' => $e->getMessage()]));
        }
    }

    public function uploadThumbnail(Request $request): JsonResponse
    {
        $receiver = new FileReceiver('upload', $request, HandlerFactory::classFromRequest($request));

        if (!$receiver->isUploaded()) {
            throw new RuntimeException('No file uploaded');
        }

        $save = $receiver->receive();

        if ($save->isFinished()) {
            /** @var UploadedFile $file */
            $file = $save->getFile();
            $fileName = $file->getClientOriginalName();
            $path = date('Y/m/d').'/'.Str::random(32).'.jpg';

            if (!Storage::disk('tmp')->exists(dirname($path))) {
                Storage::disk('tmp')->makeDirectory(dirname($path));
            }

            $img = ImageManager::gd();
            $img->read($file->getRealPath())
                ->cover(640, 360)
                ->toJpeg()
                ->save(Storage::disk('tmp')->path($path));

            $url = Storage::disk('tmp')->temporaryUrl(
                $path,
                now()->addMinutes(15)
            );

            return response()->json([
                'done' => true,
                'name' => $fileName,
                'path' => $path,
                'url' => $url,
                'disk' => 'tmp',
            ]);
        }

        return response()->json([
            "done" => false,
            "percentage" => $save->handler()->getPercentageDone()
        ]);
    }

    public function update(VideoUpdateRequest $request, Video $video)
    {
        $data = $request->validated();
        $data['mode'] = VideoMod::from($data['mode']);

        DB::transaction(
            function () use ($video, $data) {
                $thumbnail = $data['thumbnail'];

                $video->update([
                    'mode' => $data['mode'],
                    'status' => VideoStatus::PUBLISHED,
                    config('translatable.fallback_locale') => [
                        'title' => $data['title'],
                        'description' => $data['description'],
                    ],
                ]);

                if ($thumbnail['disk'] === 'tmp' && Storage::disk('tmp')->exists($thumbnail['path'])) {
                    $media = MediaUploader::make(
                        Storage::disk('tmp')->path($thumbnail['path']),
                        name: "{$data['title']}.jpg"
                    )->upload();

                    $video->attachOrUpdateMedia($media, 'thumbnail');
                }

                if (isset($data['playlists']) && is_array($data['playlists'])) {
                    $video->playlists()->sync($data['playlists']);
                } else {
                    $video->playlists()->detach();
                }

                if (isset($thumbnail['disk']) && $thumbnail['disk'] === 'tmp') {
                    Storage::disk('tmp')->delete($thumbnail['path']);
                }
            }
        );

        return $this->success(
            [
                'message' => __('itube::translation.video_updated_successfully'),
            ]
        );
    }

    public function comment(CommentRequest $request, string $code)
    {
        $video = Video::findByCode($code);

        if ($video->status !== VideoStatus::PUBLISHED) {
            return $this->error(__('itube::translation.video_is_not_available_for_comments'));
        }

        $comment = $request->save($video);

        $comment->load('commented');
        $comment->created_time = $comment->created_at->diffForHumans();
        $comment->content = nl2br(e($comment->content));

        return $this->success(
            [
                'message' => __('itube::translation.comment_added_successfully'),
                'comment' => $comment,
            ]
        );
    }

    public function reaction(Request $request, string $code)
    {
        $video = Video::findByCode($code);

        if ($video->status !== VideoStatus::PUBLISHED) {
            return $this->error(__('itube::translation.video_is_not_available'));
        }

        $user = $request->user();
        $type = $request->input('type'); // 'like' or 'dislike'

        if (!in_array($type, ['like', 'dislike'])) {
            return $this->error(__('itube::translation.invalid_reaction_type'));
        }

        DB::transaction(function () use ($video, $user, $type) {
            $existingReaction = $video->reactions()
                ->where('member_id', $user->id)
                ->first();

            if ($existingReaction) {
                if ($existingReaction->type === $type) {
                    // Remove reaction if clicking same button
                    $existingReaction->delete();
                    $video->decrement($type === 'like' ? 'likes_count' : 'dislikes_count');
                } else {
                    // Switch reaction type
                    $oldType = $existingReaction->type;
                    $existingReaction->update(['type' => $type]);
                    $video->decrement($oldType === 'like' ? 'likes_count' : 'dislikes_count');
                    $video->increment($type === 'like' ? 'likes_count' : 'dislikes_count');
                }
            } else {
                // Create new reaction
                $video->reactions()->create([
                    'member_id' => $user->id,
                    'type' => $type,
                ]);
                $video->increment($type === 'like' ? 'likes_count' : 'dislikes_count');
            }
        });

        $video->refresh();

        return $this->success([
            'message' => __('itube::translation.reaction_updated_successfully'),
            'likes_count' => $video->likes_count,
            'dislikes_count' => $video->dislikes_count,
            'user_reaction' => $video->getUserReaction($user)?->type,
        ]);
    }
}
