<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Contracts;

interface MacroableModelContract
{
    /**
     * Retrieves all the macros.
     *
     * @return array An array containing all the macros.
     */
    public function getAllMacros(): array;

    /**
     * Adds a macro to the given model.
     *
     * @param string $model The model to add the macro to.
     * @param string $name The name of the macro.
     * @param \Closure $closure The closure that defines the macro.
     * @return void
     */
    public function addMacro(string $model, string $name, \Closure $closure): void;

    /**
     * Removes a macro from the given model.
     *
     * @param mixed $model The model from which to remove the macro.
     * @param string $name The name of the macro to remove.
     * @return bool True if the macro was successfully removed, false otherwise.
     */
    public function removeMacro($model, string $name): bool;

    /**
     * Determines if the given model has a macro with the specified name.
     *
     * @param mixed $model The model to check for the macro.
     * @param string $name The name of the macro.
     * @return bool Returns true if the model has the macro, false otherwise.
     */
    public function modelHasMacro($model, $name): bool;

    /**
     * Retrieve an array of models that implement a given name.
     *
     * @param mixed $name The name of the macro.
     * @return array An array of models that implement the given name.
     */
    public function modelsThatImplement($name): array;

    /**
     * Generate the function comment for the given function body in a markdown code block with the correct language syntax.
     *
     * @param mixed $model The model to generate macros for.
     * @return array The generated macros for the model.
     */
    public function macrosForModel($model): array;
}
