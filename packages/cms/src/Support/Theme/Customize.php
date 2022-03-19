<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Support\Theme;

use Illuminate\Support\Collection;

class Customize
{
    protected $panels;
    protected $settings;
    protected $sessions;
    protected $controls;

    public function __construct()
    {
        $this->panels = new Collection([]);
        $this->settings = new Collection([]);
        $this->sessions = new Collection([]);
        $this->controls = new Collection([]);
    }

    public function addPanel($key, $args = [])
    {
        $this->panels->put($key, new Collection($args));
    }

    /**
     * @param string $key
     * @return Collection
     */
    public function getPanel($key = null)
    {
        if (empty($key)) {
            return $this->panels;
        }

        return $this->panels->get($key);
    }

    public function removePanel($key)
    {
        $this->panels->forget($key);
    }

    public function addSection($key, $args = [])
    {
        $this->sessions->put($key, new Collection($args));
    }

    public function getSection($key = null)
    {
        if (empty($key)) {
            return $this->sessions;
        }

        return $this->sessions->get($key);
    }

    public function removeSection($key)
    {
        $this->sessions->forget($key);
    }

    public function addSetting($key, $args = [])
    {
        $this->settings->put($key, new Collection($args));
    }

    public function getSetting($key = null)
    {
        if (empty($key)) {
            return $this->settings;
        }

        return $this->settings->get($key);
    }

    public function removeSetting($key)
    {
        $this->settings->forget($key);
    }

    public function addControl($control)
    {
        $key = $control->getKey();
        $args = $control->getArgs();
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

    public function removeControl($key)
    {
        $this->controls->forget($key);
    }
}
