<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Movie\Helpers;


use Juzaweb\Backend\Models\Resource;

class VideoFile
{
    public static function isSourceEmbed($source)
    {
        $embed_source = ['embed', 'youtube', 'vimeo'];

        if (in_array($source, $embed_source)) {
            return true;
        }

        return false;
    }

    public function getFiles(Resource $video) {
        $url = $video->getMeta('url');
        switch ($video->getMeta('source')) {
            case 'youtube';
                return $this->getVideoYoutube($url);
            case 'vimeo':
                return $this->getVideoVimeo($url);
            case 'upload':
                return $this->getVideoUpload();
            case 'gdrive':
                return $this->getVideoGoogleDrive();
            case 'mp4';
                return $this->getVideoUrl('mp4', $url);
            case 'mkv';
                return $this->getVideoUrl('mkv', $url);
            case 'webm':
                return $this->getVideoUrl('webm', $url);
            case 'm3u8':
                return $this->getVideoUrl('m3u8', $url);
            case 'embed':
                return $this->getVideoUrl('embed', $url);
        }

        return [];
    }

    protected function getVideoYoutube($url) {
        return [
            (object) [
                'file' => 'https://www.youtube.com/embed/' . get_youtube_id($url),
                'type' => 'mp4',
            ]
        ];
    }

    protected function getVideoVimeo($url)
    {
        return [
            (object) [
                'file' => 'https://player.vimeo.com/video/' . get_vimeo_id($url),
                'type' => 'mp4',
            ]
        ];
    }

    protected function getVideoUrl($type, $url) {

        if (!is_url($url)) {
            return $this->getVideoUpload();
        }

        /*$tracks = $this->subtitles()
            ->where('status', '=', 1)
            ->get([
                \DB::raw("'captions' AS kind"),
                'url AS file',
                'label'
            ])->toArray();

        if ($tracks) {

            return [
                (object) [
                    'file' => $this->url,
                    'type' => $type,
                    'tracks' => $tracks,
                ]
            ];
        }*/

        return [
            (object) [
                'file' => $url,
                'type' => $type,
            ]
        ];
    }

    protected function getVideoUpload() {
        if ($this->converted == 1) {
            $files = [];
            if ($this->video_240p) {
                $files[] = (object) [
                    'label' => '240p',
                    'type' => $this->getExtension(),
                    'file' => $this->generateStreamUrl($this->video_240p),
                ];
            }

            if ($this->video_360p) {
                $files[] = (object) [
                    'label' => '360p',
                    'type' => $this->getExtension(),
                    'file' => $this->generateStreamUrl($this->video_360p),
                ];
            }

            if ($this->video_480p) {
                $files[] = (object) [
                    'label' => '480p',
                    'type' => $this->getExtension(),
                    'file' => $this->generateStreamUrl($this->video_480p),
                ];
            }

            if ($this->video_720p) {
                $files[] = (object) [
                    'label' => '720p',
                    'type' => $this->getExtension(),
                    'file' => $this->generateStreamUrl($this->video_720p),
                ];
            }

            if ($this->video_1080p) {
                $files[] = (object) [
                    'label' => '1080p',
                    'type' => $this->getExtension(),
                    'file' => $this->generateStreamUrl($this->video_1080p),
                ];
            }

            if ($this->video_2048p) {
                $files[] = (object) [
                    'label' => '2048p',
                    'type' => $this->getExtension(),
                    'file' => $this->generateStreamUrl($this->video_2048p),
                ];
            }

            if ($this->video_4096p) {
                $files[] = (object) [
                    'label' => '4096p',
                    'type' => $this->getExtension(),
                    'file' => $this->generateStreamUrl($this->video_4096p),
                ];
            }

            if (count($files) > 0) {
                return $files;
            }
        }

        return [
            (object) [
                'file' => $this->generateStreamUrl($this->url),
                'type' => $this->getExtension(),
            ]
        ];
    }

    protected function getVideoGoogleDrive()
    {
        $use_stream = get_config('use_stream', 1);

        if (empty($use_stream)) {
            return $this->getVideoGoogleDriveEmbed();
        }

        $gdrive = GoogleDrive::link_stream(get_google_drive_id($this->url));
        if ($gdrive) {

            $files = [];
            foreach ($gdrive->qualities as $quality) {
                $file = [
                    'class' => 'GoogleDrive',
                    'file' => $gdrive->stream_id
                ];

                $token = urlencode(base64_encode(Crypt::encryptString(json_encode($file))));

                $files[] = (object)[
                    'label' => $quality,
                    'file' => route('stream.service', [
                        $token, $quality,
                        $quality . '.mp4'
                    ]),
                    'type' => 'mp4'
                ];
            }

            return $files;
        }

        return [];
    }

    protected function getVideoGoogleDriveEmbed() {
        $files[] = (object) [
            'file' => 'https://drive.google.com/file/d/'. get_google_drive_id($this->url) .'/preview',
            'type' => 'mp4',
        ];

        return $files;
    }

    protected function generateStreamUrl($path) {
        $token = generate_token(basename($path));
        $file = json_encode([
            'path' => $path,
        ]);

        $file = \Crypt::encryptString($file);

        return $this->getStreamLink($token, $file, basename($path));
    }

    protected function getStreamLink($token, $file, $name) {
        return route('stream.video', [$token, base64_encode($file), $name]);
    }

    protected function getExtension() {
        $file_name = basename($this->url);
        return explode('.', $file_name)[count(explode('.', $file_name)) - 1];
    }
}
