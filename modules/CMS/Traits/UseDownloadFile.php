<?php

namespace Juzaweb\CMS\Traits;

use Illuminate\Support\Str;

/**
 * @deprecated
 */
trait UseDownloadFile
{
    protected function downloadFileUrl($url, $filename)
    {
        $options = [
            CURLOPT_FILE => fopen($filename, 'w'),
            CURLOPT_TIMEOUT => 28800,
            CURLOPT_URL => $url,
        ];

        $ch = curl_init();
        curl_setopt_array($ch, $options);
        curl_exec($ch);
        curl_close($ch);
    }

    protected function downloadChunk($url, $filename)
    {
        $cnt = 0;
        $handle = fopen($url, 'rb');

        if ($handle === false) {
            return false;
        }

        while (!feof($handle)) {
            $buffer = fread($handle, 1048576);
            file_put_contents($filename, $buffer, FILE_APPEND);
            @ob_flush();
            flush();

            $cnt += strlen($buffer);

            echo "Chunk download: ".round($cnt / 1048576, 2)." MB \n";
        }

        $status = fclose($handle);

        return $status;
    }

    protected function getBaseName($url)
    {
        $name = basename($url);
        $name = explode('?', $name)[0];

        return $name;
    }

    protected function checkAccess($url)
    {
        try {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_exec($ch);
            $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($retcode == 200) {
                return true;
            }
        } catch (\Exception $exception) {
            return false;
        }

        return false;
    }

    protected function generateFileName($url)
    {
        return Str::random(10).'_'.date('H-i-s').'.'.$this->getFileExtension($url);
    }

    protected function getFileExtension($url)
    {
        $name = $this->getBaseName($url);
        if ($name) {
            $ext = explode('.', $name)[count(explode('.', $name)) - 1];

            if ($ext) {
                return $ext;
            }
        }

        return 'mp4';
    }
}
