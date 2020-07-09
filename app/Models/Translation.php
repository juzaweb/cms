<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Translation
 *
 * @property int $id
 * @property string $key
 * @property string|null $en
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Translation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Translation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Translation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Translation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Translation whereEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Translation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Translation whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Translation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Translation extends Model
{
    protected $table = 'translation';
    protected $primaryKey = 'id';
    protected $fillable = [
        'key'
    ];
    
    public static function syncLanguage() {
        $dir_path = resource_path() . '/lang';
        $columns = \Schema::getColumnListing('translation');
        
        self::syncLanguageDir($dir_path . '/en', 'en');
        
        foreach ($columns as $column) {
            if (in_array($column, ['key', 'en', 'id', 'created_at', 'updated_at'])) {
                continue;
            }
    
            self::syncLanguageDir($dir_path . '/' . $column, $column);
        }
    }
    
    protected static function syncLanguageDir($dir, $lang) {
        if (!is_dir($dir)) {
            return false;
        }
        
        $dir = new \DirectoryIterator($dir);
        foreach ($dir as $fileinfo) {
            if ($fileinfo->isFile()) {
                $file_name = $fileinfo->getFilename();
                $file_name = str_replace('.php', '', $file_name);
                $file_path = $fileinfo->getPathname();
                
                $keywords = include ($file_path);
                foreach ($keywords as $key => $keyword) {
                    $key2 = $file_name . '.' . $key;
                    self::syncLanguageKey($key2, $keyword, $lang);
                    
                }
            }
        }
        
        return true;
    }
    
    protected static function syncLanguageKey($key, $keyword, $lang) {
        if (is_array($keyword)) {
            foreach ($keyword as $key2 => $item) {
                $new_key = $key . '.' . $key2;
                self::syncLanguageKey($new_key, $item, $lang);
            }
        }
        else {
            if (!Translation::where('key', '=', $key)->exists()) {
                $model = Translation::firstOrNew(['key' => $key]);
                $model->{$lang} = $keyword;
                $model->save();
            }
        }
    }
}
