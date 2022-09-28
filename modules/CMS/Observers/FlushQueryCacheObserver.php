<?php

namespace Juzaweb\CMS\Observers;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class FlushQueryCacheObserver
{
    /**
     * Handle the Model "created" event.
     *
     * @param Model $model
     * @return void
     * @throws Exception
     */
    public function created(Model $model): void
    {
        $this->invalidateCache($model);
    }

    /**
     * Handle the Model "updated" event.
     *
     * @param Model $model
     * @return void
     * @throws Exception
     */
    public function updated(Model $model): void
    {
        $this->invalidateCache($model);
    }

    /**
     * Handle the Model "deleted" event.
     *
     * @param Model $model
     * @return void
     * @throws Exception
     */
    public function deleted(Model $model): void
    {
        $this->invalidateCache($model);
    }

    /**
     * Handle the Model "forceDeleted" event.
     *
     * @param Model $model
     * @return void
     * @throws Exception
     */
    public function forceDeleted(Model $model): void
    {
        $this->invalidateCache($model);
    }

    /**
     * Handle the Model "restored" event.
     *
     * @param Model $model
     * @return void
     */
    public function restored(Model $model): void
    {
        $this->invalidateCache($model);
    }

    /**
     * Invalidate attach for belongsToMany.
     *
     * @param  string  $relation
     * @param Model $model
     * @param  array  $ids
     * @return void
     */
    public function belongsToManyAttached(string $relation, Model $model, array $ids): void
    {
        $this->invalidateCache($model, $relation, $model->{$relation}()->findMany($ids));
    }

    /**
     * Invalidate detach for belongsToMany.
     *
     * @param  string  $relation
     * @param Model $model
     * @param  array  $ids
     * @return void
     */
    public function belongsToManyDetached(string $relation, Model $model, array $ids): void
    {
        $this->invalidateCache($model, $relation, $model->{$relation}()->findMany($ids));
    }

    /**
     * Invalidate update pivot for belongsToMany.
     *
     * @param  string  $relation
     * @param Model $model
     * @param  array  $ids
     * @return void
     */
    public function belongsToManyUpdatedExistingPivot(string $relation, Model $model, array $ids): void
    {
        $this->invalidateCache($model, $relation, $model->{$relation}()->findMany($ids));
    }

    /**
     * Invalidate attach for morphToMany.
     *
     * @param  string  $relation
     * @param Model $model
     * @param  array  $ids
     * @return void
     */
    public function morphToManyAttached(string $relation, Model $model, array $ids): void
    {
        $this->invalidateCache($model, $relation, $model->{$relation}()->findMany($ids));
    }

    /**
     * Invalidate detach for morphToMany.
     *
     * @param string $relation
     * @param Model $model
     * @param array $ids
     * @return void
     * @throws Exception
     */
    public function morphToManyDetached(string $relation, Model $model, array $ids)
    {
        $this->invalidateCache($model, $relation, $model->{$relation}()->findMany($ids));
    }

    /**
     * Invalidate update pivot for morphToMany.
     *
     * @param string $relation
     * @param Model $model
     * @param array $ids
     * @return void
     * @throws Exception
     */
    public function morphToManyUpdatedExistingPivot(string $relation, Model $model, array $ids)
    {
        $this->invalidateCache($model, $relation, $model->{$relation}()->findMany($ids));
    }

    /**
     * Invalidate the cache for a model.
     *
     * @param Model $model
     * @param string|null  $relation
     * @param Collection|null  $pivotedModels
     * @return void
     *
     * @throws Exception
     */
    protected function invalidateCache(
        Model $model,
        ?string $relation = null,
        Collection|null $pivotedModels = null
    ): void {
        $class = get_class($model);

        $tags = $model->getCacheTagsToInvalidateOnUpdate($relation, $pivotedModels);

        if (! $tags) {
            throw new Exception(
                'Automatic invalidation for '.$class
                .' works only if at least one tag to be invalidated is specified.'
            );
        }

        $class::flushQueryCache($tags);
    }
}
