<?php

namespace Juzaweb\Crawler\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Storage;

class TranslateFromEnglish extends Command
{
    protected $signature = 'leech:en-trans';
    
    public function handle()
    {
        $file_lock = 'lock-translate.txt';
        if (Storage::disk('local')->exists($file_lock)) {
            $file_lock_path = Storage::disk('local')->path($file_lock);
            $last_modified = filemtime($file_lock_path);
            if ($last_modified > time() - 7200) {
                echo "Translate is lock.";
                return;
            }
            
            unlink($file_lock_path);
        }
        
        $query = LeechContent::from('crawler_contents AS a')
            ->where('status', '=', 1)
            ->whereNotExists(function (Builder $builder) {
                $builder->select(['id'])
                    ->from('crawler_translate_histories AS b')
                    ->whereColumn('b.content_id', '=', 'a.id')
                    ->where('status', '!=', 3);
            })
            ->inRandomOrder();
    
        $links = $query->limit(1)->get();
    
        foreach ($links as $link) {
            $targets = Language::from('languages AS a')
                ->where('trans', '=', 1)
                ->where('code', '!=', $link->lang)
                ->get(['code']);
            
            $template = $link->template;
            $translate = new Translate\TranslateComponent($template->components);
            
            foreach ($targets as $target) {
                echo "TRANSLATING {$link->id} to {$target->code} \n";
                
                $history = LeechTranslate::firstOrNew([
                    'content_id' => $link->id,
                    'lang' => $target->code,
                ]);
                
                $history->fill([
                    'content_id' => $link->id,
                    'lang' => $target->code,
                    'status' => 2,
                ]);
                
                $history->save();
                
                try {
                    $components = json_decode($link->components, true);
                    $components = $translate->translate($components, $link->lang, $target->code);
                    if ($components === false) {
                        $history->update([
                            'status' => 3,
                            'error' => 'Google lock translate.',
                        ]);
    
                        continue;
                    }
                    
                    $title = trim(map_crawler_params($template->crawler_title, $components));
                    $content = map_crawler_params($template->crawler_content, $components);
                    
                    if (empty($title)) {
                        $history->update([
                            'status' => 0,
                            'error' => 'Cann\'t get title.',
                        ]);
    
                        continue;
                    }
                    
                    if (empty($content)) {
                        $history->update([
                            'status' => 0,
                            'error' => 'Cann\'t get content.',
                        ]);
                        
                        continue;
                    }
    
                    if ($history->post_id) {
                        Post::where('id', $history->post_id)
                            ->update([
                                'title' => $title,
                                'thumbnail' => $link->thumbnail,
                                'lang' => $target->code,
                                'category_id' => $link->category_id,
                                'channel_id' => $link->channel_id,
                            ]);
        
                        $pcontent = PostContent::firstOrNew(['post_id' => $history->post_id]);
                        $pcontent->post_id = $history->post_id;
                        $pcontent->lang = $target->code;
                        $pcontent->content = $content;
                        $pcontent->save();
        
                        $history->update([
                            'status' => 1,
                            'error' => '',
                        ]);
        
                        echo "TRANSLATE {$link->id} to {$target->code} \n";
        
                        continue;
                    }
    
                    $import = new PostImport([
                        'title' => $title,
                        'thumbnail' => $link->thumbnail,
                        'content' => $content,
                        'lang' => $target->code,
                        'category_id' => $link->category_id,
                        'channel_id' => $link->channel_id,
                        'status' => 'publish',
                    ]);
    
                    $new_post = $import->import();
                    if ($new_post) {
                        $history->update([
                            'status' => 1,
                            'post_id' => $new_post->id,
                            'error' => '',
                        ]);
        
                        echo "TRANSLATE {$link->id} to {$target->code} \n";
                    } else {
                        $history->update([
                            'status' => 0,
                            'error' => json_encode($import->getErrors()),
                        ]);
                    }
                    sleep(2);
                } catch (\Exception $exception) {
                    write_log($exception);
                    
                    $history->update([
                        'status' => 0,
                        'error' => $exception->getMessage(),
                    ]);
                }
            }
        }
    }
}
