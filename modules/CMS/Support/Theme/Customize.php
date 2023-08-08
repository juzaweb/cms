<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Support\Theme;

use Illuminate\Support\Collection;

class Customize
{
    protected Collection $panels;
    protected Collection $settings;
    protected Collection $sessions;
    protected Collection $controls;

    public function __construct()
    {
        $this->panels = new Collection([]);
        $this->settings = new Collection([]);
        $this->sessions = new Collection([]);
        $this->controls = new Collection([]);
    }

    public function addPanel($key, $args = []): void
    {
        $args['key'] = $key;

        $this->panels->put($key, new Collection($args));
    }

    /**
     * @param  string|null  $key
     * @return Collection
     */
    public function getPanel(string $key = null): Collection
    {
        if (empty($key)) {
            return $this->panels;
        }

        return $this->panels->get($key);
    }

    public function removePanel($key): void
    {
        $this->panels->forget($key);
    }

    public function addSection($key, $args = []): void
    {
        $args['key'] = $key;

        $this->sessions->put($key, new Collection($args));
    }

    public function getSection($key = null)
    {
        if (empty($key)) {
            return $this->sessions;
        }

        return $this->sessions->get($key);
    }

    public function removeSection($key): void
    {
        $this->sessions->forget($key);
    }

    public function addSetting($key, $args = []): void
    {
        $args['key'] = $key;

        $this->settings->put($key, new Collection($args));
    }

    public function getSetting($key = null)
    {
        if (empty($key)) {
            return $this->settings;
        }

        return $this->settings->get($key);
    }

    public function removeSetting($key): void
    {
        $this->settings->forget($key);
    }

    public function addControl($control): void
    {
        $key = $control->getKey();
        $args = $control->getArgs();
        $args['key'] = $key;
        $args->put('control', $control);

        $this->controls->put($key, $args);
    }

    public function getControl($key = null)
    {
        if (empty($key)) {
            return $this->controls;
        }

        return $this->controls->get($key);
    }

    public function removeControl($key): void
    {
        $this->controls->forget($key);
    }
}
