<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Support;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Juzaweb\CMS\Contracts\MacroableModelContract;

class MacroableModel implements MacroableModelContract
{
    private array $macros = [];

    public function getAllMacros(): array
    {
        return $this->macros;
    }

    public function addMacro(string $model, string $name, \Closure $closure): void
    {
        $this->checkModelSubclass($model);

        if (! isset($this->macros[$name])) {
            $this->macros[$name] = [];
        }
        $this->macros[$name][$model] = $closure;
        $this->syncMacros($name);
    }

    public function removeMacro($model, string $name): bool
    {
        $this->checkModelSubclass($model);

        if (isset($this->macros[$name]) && isset($this->macros[$name][$model])) {
            unset($this->macros[$name][$model]);
            if (count($this->macros[$name]) == 0) {
                unset($this->macros[$name]);
            } else {
                $this->syncMacros($name);
            }
            return true;
        }

        return false;
    }

    public function modelHasMacro($model, $name): bool
    {
        $this->checkModelSubclass($model);
        return (isset($this->macros[$name]) && isset($this->macros[$name][$model]));
    }

    public function modelsThatImplement($name): array
    {
        if (! isset($this->macros[$name])) {
            return [];
        }
        return array_keys($this->macros[$name]);
    }

    public function macrosForModel($model): array
    {
        $this->checkModelSubclass($model);

        $macros = [];

        foreach ($this->macros as $macro => $models) {
            if (in_array($model, array_keys($models))) {
                $params = (new \ReflectionFunction($this->macros[$macro][$model]))->getParameters();
                $macros[$macro] = [
                    'name' => $macro,
                    'parameters' => $params,
                ];
            }
        }

        return $macros;
    }

    private function syncMacros($name): void
    {
        $models = $this->macros[$name];
        Builder::macro($name, function (...$args) use ($name, $models) {
            $class = get_class($this->getModel());

            if (! isset($models[$class])) {
                throw new \BadMethodCallException("Call to undefined method ${class}::${name}()");
            }

            $closure = \Closure::bind($models[$class], $this->getModel());
            return call_user_func($closure, ...$args);
        });
    }

    private function checkModelSubclass(string $model): void
    {
        if (! is_subclass_of($model, Model::class)) {
            throw new \InvalidArgumentException('$model must be a subclass of Illuminate\\Database\\Eloquent\\Model');
        }
    }
}
