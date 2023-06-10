<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Contracts;

interface MacroableModelContract
{
    public function getAllMacros(): array;

    public function addMacro(string $model, string $name, \Closure $closure): void;

    public function removeMacro($model, string $name): bool;

    public function modelHasMacro($model, $name): bool;

    public function modelsThatImplement($name): array;

    public function macrosForModel($model): array;
}
