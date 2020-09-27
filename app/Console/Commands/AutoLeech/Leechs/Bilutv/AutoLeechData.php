<?php

namespace App\Console\Commands\AutoLeech\Leechs\Bilutv;

use App\Helpers\ImportMovie;
use App\Models\Leech\LeechLink;
use App\Models\Video\VideoServers;
use App\Models\VideoFiles;
use App\Traits\UseLeech;
use Illuminate\Console\Command;

class AutoLeechData extends Command
{
    use UseLeech;
    
    protected $signature = 'leech:bilutv-data';
    
    protected $description = '';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function handle() {
        $links = LeechLink::where('leech_data', '=', 2)
            ->where('server', '=', 'bilutv')
            ->limit(1)
            ->get();
        
        foreach ($links as $link) {
            $html = $this->getContent($link->link);
            $name_en = $this->plaintext($html, 'h2.real-name');
            
            $data = [];
            $data['name'] = $this->plaintext($html, 'h1.name');
            $data['other_name'] = $this->getMovieName($name_en);
            $data['rating'] = $this->plaintext($html, '#average');
            $data['description'] = $this->innertext($html, '.film-content');
            $data['runtime'] = $this->getInfo($html, 'Thời lượng: ');
            $data['year'] = $this->getMovieYear($name_en);
            $data['thumbnail'] = $this->attribute($html, '.poster img', 'src');
            $data['tv_series'] = $link->tv_series;
            
            $data['genres'] = $this->getDataArray($html, 'Thể loại: ');
            $data['countries'] = $this->getDataArray($html, 'Quốc gia: ');
            $data['directors'] = $this->getDataArray($html, 'Đạo diễn: ');
            $data['actors'] = $this->getActors($html);
            $data['tags'] = $this->getTags($html);
            
            $import = new ImportMovie($data);
            $files = $this->leechFiles($html, $link->tv_series);
            
            if ($files === true) {
                continue;
            }
            
            if ($files['status'] === false) {
                $link->update([
                    'leech_data' => 0,
                    'error' => json_encode([$files['data']['error']])
                ]);
                
                continue;
            }
            
            $new_movie = $import->save();
            if ($new_movie) {
                $server = new VideoServers();
                $server->name = 'Server 1';
                $server->movie_id = $new_movie->id;
                $server->save();
                
                $video_files = $files['data']['files'];
                foreach ($video_files as $file) {
                    $video = new VideoFiles();
                    $video->movie_id = $new_movie->id;
                    $video->server_id = $server->id;
                    $video->label = $file['label'];
                    $video->source = $file['source'];
                    $video->url = $file['url'];
                    
                    $video->save();
                }
                
                echo "OK: " . $data['name'];
    
                $link->update([
                    'leech_data' => 1,
                ]);
            }
            else {
                echo "Error: " . @$import->errors[0];
                
                $link->update([
                    'leech_data' => 0,
                    'error' => json_encode($import->errors)
                ]);
            }
        }
    }
    
    protected function getDataArray($content, $info) {
        $result = [];
        $genres = $this->getInfo($content, $info, 'array');
        foreach ($genres as $genre) {
            $result[] = [
                'name' => trim($genre),
            ];
        }
        
        return $result;
    }
    
    protected function getActors($content) {
        $result = [];
        $attr = $this->find($content, '#film-detail-act .actor');
        foreach ($attr as $item) {
            $text = htmlspecialchars_decode($item->text(), ENT_QUOTES);
            $text = trim($text);
            $result[] = [
                'name' => $text,
            ];
        }
        
        return $result;
    }
    
    protected function getTags($content) {
        $result = [];
        $attr = $this->find($content, '.tags .tag-item');
        foreach ($attr as $item) {
            $text = htmlspecialchars_decode($item->text(), ENT_QUOTES);
            $text = trim($text);
            $result[] = [
                'name' => $text,
            ];
        }
    
        return $result;
    }
    
    protected function getInfo($content, $info, $output = 'text') {
        $attr = $this->find($content, '.meta-data li');
        
        foreach ($attr as $item) {
            $text = htmlspecialchars_decode($item->text(), ENT_QUOTES);
            $text = trim($text);
            
            if (strpos($text, $info) === 0) {
                $val = str_replace($info, '', $text);
                $val = trim($val);
                
                if ($output == 'text') {
                    return $val;
                }
                
                if ($output == 'array') {
                    return explode(',', $val);
                }
            }
        }
        
        return null;
    }
    
    protected function leechFiles($content, $tv_series = 0) {
        if ($tv_series == 0) {
            return $this->leechFilesMovie($content);
        }
        
        return $this->leechFilesTvSeries($content);
    }
    
    protected function leechFilesMovie($content) {
        $film_id = $this->attribute($content, '#film_id', 'value');
        $play_url = $this->attribute($content, 'a.btn-see', 'href');
        $episode_id = @explode('.', $play_url)[2];
    
        if ($film_id > 0 && $episode_id > 0) {
            $data = $this->post('https://bilutvz.org/ajax/player', [
                'id' => $film_id,
                'ep' => $episode_id,
            ]);
        
            $begin = strpos($data, '"file":"');
            $data = substr($data, $begin);
            $data = str_replace('"file":"', '', $data);
            $end = strpos($data, '"');
            $data = substr($data, 0, $end);
        
            if (is_url($data)) {
                return [
                    'status' => true,
                    'data' => [
                        'files' => [
                            [
                                'label' => 'S1',
                                'url' => $data,
                                'source' => 'mp4',
                            ]
                        ]
                    ]
                ];
            }
        
            return [
                'status' => false,
                'data' => [
                    'error' => 'Cannot find link.'
                ],
            ];
        }
    
        return true;
    }
    
    protected function leechFilesTvSeries($content) {
    
    }
}
