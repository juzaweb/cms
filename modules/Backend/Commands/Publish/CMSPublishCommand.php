<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Commands\Publish;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Input\InputArgument;

class CMSPublishCommand extends Command
{
    protected $name = 'cms:publish';

    public function handle(): void
    {
        $tag = match ($this->argument('type')) {
            'config' => 'cms_config',
            default => 'cms_assets',
        };

        if ($tag == 'cms_assets') {
            File::deleteDirectory(base_path('public/jw-styles/juzaweb/build'), true);
        }

        $this->call(
            'vendor:publish',
            [
                '--force' => true,
                '--tag' => [$tag],
            ]
        );
    }

    protected function getArguments(): array
    {
        return [
            ['type', InputArgument::OPTIONAL, 'Publish type.', 'assets'],
        ];
    }
}
