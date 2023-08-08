<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\CMS\Traits;

trait ServerLoadChecker
{
    public function checkServerLoad(float $cpu = 0.70, string $operator = '>'): bool
    {
        if (function_exists("sys_getloadavg")) {
            $serverload = sys_getloadavg();
            $serverload = round($serverload[0] / 4, 2);

            $i = 1;
            while ($i <= 3) {
                if (!$this->compareServerLoad($serverload, $cpu, $operator)) {
                    return false;
                }

                sleep(1);
                $i++;
            }

            return true;
        }

        return false;
    }

    private function compareServerLoad(float $serverload, float $cpu, string $operator): bool
    {
        switch ($operator) {
            case '>':
                return $serverload > $cpu;
            case '<':
                return $serverload < $cpu;
            case '>=':
                return $serverload >= $cpu;
            case '<=':
                return $serverload <= $cpu;
            case '=':
                return $serverload == $cpu;
        }

        throw new \Exception('Operator not found');
    }
}
