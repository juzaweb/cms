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
        self::fileToDatabase();
        self::databaseToFile();
    }
    
    protected static function varExportShort($var)
    {
        $output = json_decode(str_replace(array('(',')'), array('&#40','&#41'), json_encode($var)), true);
        $output = var_export($output, true);
        $output = str_replace(array('array (',')','&#40','&#41'), array('[',']','(',')'), $output);
        return $output;
    }
    
    protected static function databaseToFile() {
        $lang_dir = resource_path() . '/lang';
        $columns = self::getColumnsLanguage();
        foreach ($columns as $column) {
            $dir_path = $lang_dir . '/' . $column;
            $trans_files = new \DirectoryIterator($dir_path);
            
            if (!is_dir($dir_path)) {
                mkdir($dir_path);
            }
            
            foreach ($trans_files as $file) {
                if (!$file->isDot()) {
                    $file_name = $file->getFilename();
                    $group = explode('.', $file_name)[0];
                    echo "__START GROUP: ". $group;
                    $items = Languages::select([
                        'code AS keylang',
                        'en AS default',
                        $column .' AS lang'
                    ])->where('code', 'like', $group . '.%')
                        ->get();
            
                    $arr = [];
                    foreach ($items as $item) {
                        $keylang = str_replace($group . '.', '', $item->keylang);
                        $explode = explode('.', $keylang);
                        $lang_text = $item->lang;
                        if (empty($lang_text)) {
                            $lang_text = $item->default;
                        }
                
                        if (isset($explode[1]) && !empty($explode[1])) {
                            $arr[$explode[0]][trim($explode[1])] = trim($lang_text);
                        }
                        else {
                            $arr[\Str::slug($keylang, '_')] = trim($lang_text);
                        }
                    }
            
                    $str_arr = self::varExportShort($arr) . ";";
                    $data = "<?php \n";
                    $data .= "return $str_arr \n";
                    $data .= "\n";
            
                    $handle = fopen($dir_path . '/' . $file_name, 'w+') or die('Cannot open file: '. $file_name);
                    fwrite($handle, $data);
                    fclose($handle);
                    echo "__END GROUP: ". $group . "\n";;
                }
            }
        }
    }
    
    protected static function getColumnsLanguage() {
        $columns = \Schema::getColumnListing('translation');
        return array_merge(array_diff($columns, ['key', 'id', 'created_at', 'updated_at']));
    }
    
    protected static function fileToDatabase() {
        $dir_path = resource_path() . '/lang';
        $columns = self::getColumnsLanguage();
    
        self::syncLanguageDir($dir_path . '/en', 'en');
    
        foreach ($columns as $column) {
            if ($column == 'en') {
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
