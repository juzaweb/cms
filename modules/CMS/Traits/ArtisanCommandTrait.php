<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Traits;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

trait ArtisanCommandTrait
{
    public function executeArtisanCommand($command, $options = [])
    {
        $stmt = 'php artisan '. $command . ' ' . $this->prepareOptions($options);

        $process = new Process(trim($stmt));
        $process->setWorkingDirectory(JW_BASEPATH);
        $process->run();

        // executes after the command finishes
        if (! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }

    public function prepareOptions($options)
    {
        $args = [];
        $opts = [];
        $flags = [];
        foreach ($options as $key => $value) {
            if (ctype_alpha(substr($key, 0, 1))) {
                $args[] = $value;
            } elseif (starts_with($key, '--')) {
                $opts[] = $key. (is_null($value) ? '' : '=' . $value) ;
            } elseif (starts_with($key, '-')) {
                $flags[] = $key;
            }
        }

        return implode(' ', $args) . ' '
            .implode(' ', $opts). ' '
            .implode(' ', $flags);
    }
}
