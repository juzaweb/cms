<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Network\Traits;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Str;

trait RootNetworkModel
{
    protected string $tableWithPrefix;

    public function getPrefix()
    {
        return $this->tablePrefix ?? '';
    }

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        if (isset($this->tableWithPrefix)) {
            return $this->tableWithPrefix;
        }

        if ($this instanceof Pivot && ! isset($this->table)) {
            $this->setTable(
                $this->getPrefix() . str_replace(
                    '\\',
                    '',
                    Str::snake(Str::singular(class_basename($this)))
                )
            );

            return $this->tableWithPrefix;
        }

        return $this->getPrefix() . $this->table;
    }

    /**
     * Set the table associated with the model.
     *
     * @param  string  $table
     * @return $this
     */
    public function setTable($table)
    {
        $this->tableWithPrefix = $table;

        return $this;
    }
}
