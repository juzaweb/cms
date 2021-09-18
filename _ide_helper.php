<?php
// @formatter:off

namespace  { 

    class App extends \Illuminate\Support\Facades\App {}

    class Arr extends \Illuminate\Support\Arr {}

    class Artisan extends \Illuminate\Support\Facades\Artisan {}

    class Auth extends \Illuminate\Support\Facades\Auth {}

    class Blade extends \Illuminate\Support\Facades\Blade {}

    class Broadcast extends \Illuminate\Support\Facades\Broadcast {}

    class Bus extends \Illuminate\Support\Facades\Bus {}

    class Cache extends \Illuminate\Support\Facades\Cache {}

    class Config extends \Illuminate\Support\Facades\Config {}

    class Cookie extends \Illuminate\Support\Facades\Cookie {}

    class Crypt extends \Illuminate\Support\Facades\Crypt {}

    class DB extends \Illuminate\Support\Facades\DB {}

    class Eloquent extends \Illuminate\Database\Eloquent\Model {         
            /**
             * Create and return an un-saved model instance.
             *
             * @param array $attributes
             * @return \Illuminate\Database\Eloquent\Model 
             * @static 
             */ 
            public static function make($attributes = [])
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->make($attributes);
            }
         
            /**
             * Register a new global scope.
             *
             * @param string $identifier
             * @param \Illuminate\Database\Eloquent\Scope|\Closure $scope
             * @return \Illuminate\Database\Eloquent\Builder 
             * @static 
             */ 
            public static function withGlobalScope($identifier, $scope)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->withGlobalScope($identifier, $scope);
            }
         
            /**
             * Remove a registered global scope.
             *
             * @param \Illuminate\Database\Eloquent\Scope|string $scope
             * @return \Illuminate\Database\Eloquent\Builder 
             * @static 
             */ 
            public static function withoutGlobalScope($scope)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->withoutGlobalScope($scope);
            }
         
            /**
             * Remove all or passed registered global scopes.
             *
             * @param array|null $scopes
             * @return \Illuminate\Database\Eloquent\Builder 
             * @static 
             */ 
            public static function withoutGlobalScopes($scopes = null)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->withoutGlobalScopes($scopes);
            }
         
            /**
             * Get an array of global scopes that were removed from the query.
             *
             * @return array 
             * @static 
             */ 
            public static function removedScopes()
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->removedScopes();
            }
         
            /**
             * Add a where clause on the primary key to the query.
             *
             * @param mixed $id
             * @return \Illuminate\Database\Eloquent\Builder 
             * @static 
             */ 
            public static function whereKey($id)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->whereKey($id);
            }
         
            /**
             * Add a where clause on the primary key to the query.
             *
             * @param mixed $id
             * @return \Illuminate\Database\Eloquent\Builder 
             * @static 
             */ 
            public static function whereKeyNot($id)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->whereKeyNot($id);
            }
         
            /**
             * Add a basic where clause to the query.
             *
             * @param string|array|\Closure $column
             * @param mixed $operator
             * @param mixed $value
             * @param string $boolean
             * @return \Illuminate\Database\Eloquent\Builder 
             * @static 
             */ 
            public static function where($column, $operator = null, $value = null, $boolean = 'and')
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->where($column, $operator, $value, $boolean);
            }
         
            /**
             * Add an "or where" clause to the query.
             *
             * @param \Closure|array|string $column
             * @param mixed $operator
             * @param mixed $value
             * @return \Illuminate\Database\Eloquent\Builder|static 
             * @static 
             */ 
            public static function orWhere($column, $operator = null, $value = null)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->orWhere($column, $operator, $value);
            }
         
            /**
             * Add an "order by" clause for a timestamp to the query.
             *
             * @param string $column
             * @return \Illuminate\Database\Eloquent\Builder 
             * @static 
             */ 
            public static function latest($column = null)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->latest($column);
            }
         
            /**
             * Add an "order by" clause for a timestamp to the query.
             *
             * @param string $column
             * @return \Illuminate\Database\Eloquent\Builder 
             * @static 
             */ 
            public static function oldest($column = null)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->oldest($column);
            }
         
            /**
             * Create a collection of models from plain arrays.
             *
             * @param array $items
             * @return \Illuminate\Database\Eloquent\Collection 
             * @static 
             */ 
            public static function hydrate($items)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->hydrate($items);
            }
         
            /**
             * Create a collection of models from a raw query.
             *
             * @param string $query
             * @param array $bindings
             * @return \Illuminate\Database\Eloquent\Collection 
             * @static 
             */ 
            public static function fromQuery($query, $bindings = [])
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->fromQuery($query, $bindings);
            }
         
            /**
             * Find a model by its primary key.
             *
             * @param mixed $id
             * @param array $columns
             * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|static[]|static|null 
             * @static 
             */ 
            public static function find($id, $columns = [])
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->find($id, $columns);
            }
         
            /**
             * Find multiple models by their primary keys.
             *
             * @param \Illuminate\Contracts\Support\Arrayable|array $ids
             * @param array $columns
             * @return \Illuminate\Database\Eloquent\Collection 
             * @static 
             */ 
            public static function findMany($ids, $columns = [])
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->findMany($ids, $columns);
            }
         
            /**
             * Find a model by its primary key or throw an exception.
             *
             * @param mixed $id
             * @param array $columns
             * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|static|static[] 
             * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
             * @static 
             */ 
            public static function findOrFail($id, $columns = [])
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->findOrFail($id, $columns);
            }
         
            /**
             * Find a model by its primary key or return fresh model instance.
             *
             * @param mixed $id
             * @param array $columns
             * @return \Illuminate\Database\Eloquent\Model|static 
             * @static 
             */ 
            public static function findOrNew($id, $columns = [])
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->findOrNew($id, $columns);
            }
         
            /**
             * Get the first record matching the attributes or instantiate it.
             *
             * @param array $attributes
             * @param array $values
             * @return \Illuminate\Database\Eloquent\Model|static 
             * @static 
             */ 
            public static function firstOrNew($attributes, $values = [])
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->firstOrNew($attributes, $values);
            }
         
            /**
             * Get the first record matching the attributes or create it.
             *
             * @param array $attributes
             * @param array $values
             * @return \Illuminate\Database\Eloquent\Model|static 
             * @static 
             */ 
            public static function firstOrCreate($attributes, $values = [])
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->firstOrCreate($attributes, $values);
            }
         
            /**
             * Create or update a record matching the attributes, and fill it with values.
             *
             * @param array $attributes
             * @param array $values
             * @return \Illuminate\Database\Eloquent\Model|static 
             * @static 
             */ 
            public static function updateOrCreate($attributes, $values = [])
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->updateOrCreate($attributes, $values);
            }
         
            /**
             * Execute the query and get the first result or throw an exception.
             *
             * @param array $columns
             * @return \Illuminate\Database\Eloquent\Model|static 
             * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
             * @static 
             */ 
            public static function firstOrFail($columns = [])
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->firstOrFail($columns);
            }
         
            /**
             * Execute the query and get the first result or call a callback.
             *
             * @param \Closure|array $columns
             * @param \Closure|null $callback
             * @return \Illuminate\Database\Eloquent\Model|static|mixed 
             * @static 
             */ 
            public static function firstOr($columns = [], $callback = null)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->firstOr($columns, $callback);
            }
         
            /**
             * Get a single column's value from the first result of a query.
             *
             * @param string $column
             * @return mixed 
             * @static 
             */ 
            public static function value($column)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->value($column);
            }
         
            /**
             * Execute the query as a "select" statement.
             *
             * @param array $columns
             * @return \Illuminate\Database\Eloquent\Collection|static[] 
             * @static 
             */ 
            public static function get($columns = [])
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->get($columns);
            }
         
            /**
             * Get the hydrated models without eager loading.
             *
             * @param array $columns
             * @return \Illuminate\Database\Eloquent\Model[]|static[] 
             * @static 
             */ 
            public static function getModels($columns = [])
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->getModels($columns);
            }
         
            /**
             * Eager load the relationships for the models.
             *
             * @param array $models
             * @return array 
             * @static 
             */ 
            public static function eagerLoadRelations($models)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->eagerLoadRelations($models);
            }
         
            /**
             * Get a generator for the given query.
             *
             * @return \Generator 
             * @static 
             */ 
            public static function cursor()
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->cursor();
            }
         
            /**
             * Chunk the results of a query by comparing numeric IDs.
             *
             * @param int $count
             * @param callable $callback
             * @param string|null $column
             * @param string|null $alias
             * @return bool 
             * @static 
             */ 
            public static function chunkById($count, $callback, $column = null, $alias = null)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->chunkById($count, $callback, $column, $alias);
            }
         
            /**
             * Get an array with the values of a given column.
             *
             * @param string $column
             * @param string|null $key
             * @return \Illuminate\Support\Collection 
             * @static 
             */ 
            public static function pluck($column, $key = null)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->pluck($column, $key);
            }
         
            /**
             * Paginate the given query.
             *
             * @param int $perPage
             * @param array $columns
             * @param string $pageName
             * @param int|null $page
             * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator 
             * @throws \InvalidArgumentException
             * @static 
             */ 
            public static function paginate($perPage = null, $columns = [], $pageName = 'page', $page = null)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->paginate($perPage, $columns, $pageName, $page);
            }
         
            /**
             * Paginate the given query into a simple paginator.
             *
             * @param int $perPage
             * @param array $columns
             * @param string $pageName
             * @param int|null $page
             * @return \Illuminate\Contracts\Pagination\Paginator 
             * @static 
             */ 
            public static function simplePaginate($perPage = null, $columns = [], $pageName = 'page', $page = null)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->simplePaginate($perPage, $columns, $pageName, $page);
            }
         
            /**
             * Save a new model and return the instance.
             *
             * @param array $attributes
             * @return \Illuminate\Database\Eloquent\Model|$this 
             * @static 
             */ 
            public static function create($attributes = [])
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->create($attributes);
            }
         
            /**
             * Save a new model and return the instance. Allow mass-assignment.
             *
             * @param array $attributes
             * @return \Illuminate\Database\Eloquent\Model|$this 
             * @static 
             */ 
            public static function forceCreate($attributes)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->forceCreate($attributes);
            }
         
            /**
             * Register a replacement for the default delete function.
             *
             * @param \Closure $callback
             * @return void 
             * @static 
             */ 
            public static function onDelete($callback)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                $instance->onDelete($callback);
            }
         
            /**
             * Call the given local model scopes.
             *
             * @param array $scopes
             * @return static|mixed 
             * @static 
             */ 
            public static function scopes($scopes)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->scopes($scopes);
            }
         
            /**
             * Apply the scopes to the Eloquent builder instance and return it.
             *
             * @return static 
             * @static 
             */ 
            public static function applyScopes()
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->applyScopes();
            }
         
            /**
             * Prevent the specified relations from being eager loaded.
             *
             * @param mixed $relations
             * @return \Illuminate\Database\Eloquent\Builder 
             * @static 
             */ 
            public static function without($relations)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->without($relations);
            }
         
            /**
             * Create a new instance of the model being queried.
             *
             * @param array $attributes
             * @return \Illuminate\Database\Eloquent\Model|static 
             * @static 
             */ 
            public static function newModelInstance($attributes = [])
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->newModelInstance($attributes);
            }
         
            /**
             * Get the underlying query builder instance.
             *
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function getQuery()
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->getQuery();
            }
         
            /**
             * Set the underlying query builder instance.
             *
             * @param \Illuminate\Database\Query\Builder $query
             * @return \Illuminate\Database\Eloquent\Builder 
             * @static 
             */ 
            public static function setQuery($query)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->setQuery($query);
            }
         
            /**
             * Get a base query builder instance.
             *
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function toBase()
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->toBase();
            }
         
            /**
             * Get the relationships being eagerly loaded.
             *
             * @return array 
             * @static 
             */ 
            public static function getEagerLoads()
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->getEagerLoads();
            }
         
            /**
             * Set the relationships being eagerly loaded.
             *
             * @param array $eagerLoad
             * @return \Illuminate\Database\Eloquent\Builder 
             * @static 
             */ 
            public static function setEagerLoads($eagerLoad)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->setEagerLoads($eagerLoad);
            }
         
            /**
             * Get the model instance being queried.
             *
             * @return \Illuminate\Database\Eloquent\Model|static 
             * @static 
             */ 
            public static function getModel()
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->getModel();
            }
         
            /**
             * Set a model instance for the model being queried.
             *
             * @param \Illuminate\Database\Eloquent\Model $model
             * @return \Illuminate\Database\Eloquent\Builder 
             * @static 
             */ 
            public static function setModel($model)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->setModel($model);
            }
         
            /**
             * Get the given macro by name.
             *
             * @param string $name
             * @return \Closure 
             * @static 
             */ 
            public static function getMacro($name)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->getMacro($name);
            }
         
            /**
             * Chunk the results of the query.
             *
             * @param int $count
             * @param callable $callback
             * @return bool 
             * @static 
             */ 
            public static function chunk($count, $callback)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->chunk($count, $callback);
            }
         
            /**
             * Execute a callback over each item while chunking.
             *
             * @param callable $callback
             * @param int $count
             * @return bool 
             * @static 
             */ 
            public static function each($callback, $count = 1000)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->each($callback, $count);
            }
         
            /**
             * Execute the query and get the first result.
             *
             * @param array $columns
             * @return \Illuminate\Database\Eloquent\Model|object|static|null 
             * @static 
             */ 
            public static function first($columns = [])
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->first($columns);
            }
         
            /**
             * Apply the callback's query changes if the given "value" is true.
             *
             * @param mixed $value
             * @param callable $callback
             * @param callable|null $default
             * @return mixed|$this 
             * @static 
             */ 
            public static function when($value, $callback, $default = null)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->when($value, $callback, $default);
            }
         
            /**
             * Pass the query to a given callback.
             *
             * @param callable $callback
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function tap($callback)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->tap($callback);
            }
         
            /**
             * Apply the callback's query changes if the given "value" is false.
             *
             * @param mixed $value
             * @param callable $callback
             * @param callable|null $default
             * @return mixed|$this 
             * @static 
             */ 
            public static function unless($value, $callback, $default = null)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->unless($value, $callback, $default);
            }
         
            /**
             * Add a relationship count / exists condition to the query.
             *
             * @param string|\Illuminate\Database\Eloquent\Relations\Relation $relation
             * @param string $operator
             * @param int $count
             * @param string $boolean
             * @param \Closure|null $callback
             * @return \Illuminate\Database\Eloquent\Builder|static 
             * @static 
             */ 
            public static function has($relation, $operator = '>=', $count = 1, $boolean = 'and', $callback = null)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->has($relation, $operator, $count, $boolean, $callback);
            }
         
            /**
             * Add a relationship count / exists condition to the query with an "or".
             *
             * @param string $relation
             * @param string $operator
             * @param int $count
             * @return \Illuminate\Database\Eloquent\Builder|static 
             * @static 
             */ 
            public static function orHas($relation, $operator = '>=', $count = 1)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->orHas($relation, $operator, $count);
            }
         
            /**
             * Add a relationship count / exists condition to the query.
             *
             * @param string $relation
             * @param string $boolean
             * @param \Closure|null $callback
             * @return \Illuminate\Database\Eloquent\Builder|static 
             * @static 
             */ 
            public static function doesntHave($relation, $boolean = 'and', $callback = null)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->doesntHave($relation, $boolean, $callback);
            }
         
            /**
             * Add a relationship count / exists condition to the query with an "or".
             *
             * @param string $relation
             * @return \Illuminate\Database\Eloquent\Builder|static 
             * @static 
             */ 
            public static function orDoesntHave($relation)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->orDoesntHave($relation);
            }
         
            /**
             * Add a relationship count / exists condition to the query with where clauses.
             *
             * @param string $relation
             * @param \Closure|null $callback
             * @param string $operator
             * @param int $count
             * @return \Illuminate\Database\Eloquent\Builder|static 
             * @static 
             */ 
            public static function whereHas($relation, $callback = null, $operator = '>=', $count = 1)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->whereHas($relation, $callback, $operator, $count);
            }
         
            /**
             * Add a relationship count / exists condition to the query with where clauses and an "or".
             *
             * @param string $relation
             * @param \Closure $callback
             * @param string $operator
             * @param int $count
             * @return \Illuminate\Database\Eloquent\Builder|static 
             * @static 
             */ 
            public static function orWhereHas($relation, $callback = null, $operator = '>=', $count = 1)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->orWhereHas($relation, $callback, $operator, $count);
            }
         
            /**
             * Add a relationship count / exists condition to the query with where clauses.
             *
             * @param string $relation
             * @param \Closure|null $callback
             * @return \Illuminate\Database\Eloquent\Builder|static 
             * @static 
             */ 
            public static function whereDoesntHave($relation, $callback = null)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->whereDoesntHave($relation, $callback);
            }
         
            /**
             * Add a relationship count / exists condition to the query with where clauses and an "or".
             *
             * @param string $relation
             * @param \Closure $callback
             * @return \Illuminate\Database\Eloquent\Builder|static 
             * @static 
             */ 
            public static function orWhereDoesntHave($relation, $callback = null)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->orWhereDoesntHave($relation, $callback);
            }
         
            /**
             * Add a polymorphic relationship count / exists condition to the query.
             *
             * @param string $relation
             * @param string|array $types
             * @param string $operator
             * @param int $count
             * @param string $boolean
             * @param \Closure|null $callback
             * @return \Illuminate\Database\Eloquent\Builder|static 
             * @static 
             */ 
            public static function hasMorph($relation, $types, $operator = '>=', $count = 1, $boolean = 'and', $callback = null)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->hasMorph($relation, $types, $operator, $count, $boolean, $callback);
            }
         
            /**
             * Add a polymorphic relationship count / exists condition to the query with an "or".
             *
             * @param string $relation
             * @param string|array $types
             * @param string $operator
             * @param int $count
             * @return \Illuminate\Database\Eloquent\Builder|static 
             * @static 
             */ 
            public static function orHasMorph($relation, $types, $operator = '>=', $count = 1)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->orHasMorph($relation, $types, $operator, $count);
            }
         
            /**
             * Add a polymorphic relationship count / exists condition to the query.
             *
             * @param string $relation
             * @param string|array $types
             * @param string $boolean
             * @param \Closure|null $callback
             * @return \Illuminate\Database\Eloquent\Builder|static 
             * @static 
             */ 
            public static function doesntHaveMorph($relation, $types, $boolean = 'and', $callback = null)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->doesntHaveMorph($relation, $types, $boolean, $callback);
            }
         
            /**
             * Add a polymorphic relationship count / exists condition to the query with an "or".
             *
             * @param string $relation
             * @param string|array $types
             * @return \Illuminate\Database\Eloquent\Builder|static 
             * @static 
             */ 
            public static function orDoesntHaveMorph($relation, $types)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->orDoesntHaveMorph($relation, $types);
            }
         
            /**
             * Add a polymorphic relationship count / exists condition to the query with where clauses.
             *
             * @param string $relation
             * @param string|array $types
             * @param \Closure|null $callback
             * @param string $operator
             * @param int $count
             * @return \Illuminate\Database\Eloquent\Builder|static 
             * @static 
             */ 
            public static function whereHasMorph($relation, $types, $callback = null, $operator = '>=', $count = 1)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->whereHasMorph($relation, $types, $callback, $operator, $count);
            }
         
            /**
             * Add a polymorphic relationship count / exists condition to the query with where clauses and an "or".
             *
             * @param string $relation
             * @param string|array $types
             * @param \Closure $callback
             * @param string $operator
             * @param int $count
             * @return \Illuminate\Database\Eloquent\Builder|static 
             * @static 
             */ 
            public static function orWhereHasMorph($relation, $types, $callback = null, $operator = '>=', $count = 1)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->orWhereHasMorph($relation, $types, $callback, $operator, $count);
            }
         
            /**
             * Add a polymorphic relationship count / exists condition to the query with where clauses.
             *
             * @param string $relation
             * @param string|array $types
             * @param \Closure|null $callback
             * @return \Illuminate\Database\Eloquent\Builder|static 
             * @static 
             */ 
            public static function whereDoesntHaveMorph($relation, $types, $callback = null)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->whereDoesntHaveMorph($relation, $types, $callback);
            }
         
            /**
             * Add a polymorphic relationship count / exists condition to the query with where clauses and an "or".
             *
             * @param string $relation
             * @param string|array $types
             * @param \Closure $callback
             * @return \Illuminate\Database\Eloquent\Builder|static 
             * @static 
             */ 
            public static function orWhereDoesntHaveMorph($relation, $types, $callback = null)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->orWhereDoesntHaveMorph($relation, $types, $callback);
            }
         
            /**
             * Add subselect queries to count the relations.
             *
             * @param mixed $relations
             * @return \Illuminate\Database\Eloquent\Builder 
             * @static 
             */ 
            public static function withCount($relations)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->withCount($relations);
            }
         
            /**
             * Merge the where constraints from another query to the current query.
             *
             * @param \Illuminate\Database\Eloquent\Builder $from
             * @return \Illuminate\Database\Eloquent\Builder|static 
             * @static 
             */ 
            public static function mergeConstraintsFrom($from)
            {
                                /** @var \Illuminate\Database\Eloquent\Builder $instance */
                                return $instance->mergeConstraintsFrom($from);
            }
         
            /**
             * Set the columns to be selected.
             *
             * @param array|mixed $columns
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function select($columns = [])
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->select($columns);
            }
         
            /**
             * Add a subselect expression to the query.
             *
             * @param \Closure|\Illuminate\Database\Query\Builder|string $query
             * @param string $as
             * @return \Illuminate\Database\Query\Builder|static 
             * @throws \InvalidArgumentException
             * @static 
             */ 
            public static function selectSub($query, $as)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->selectSub($query, $as);
            }
         
            /**
             * Add a new "raw" select expression to the query.
             *
             * @param string $expression
             * @param array $bindings
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function selectRaw($expression, $bindings = [])
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->selectRaw($expression, $bindings);
            }
         
            /**
             * Makes "from" fetch from a subquery.
             *
             * @param \Closure|\Illuminate\Database\Query\Builder|string $query
             * @param string $as
             * @return \Illuminate\Database\Query\Builder|static 
             * @throws \InvalidArgumentException
             * @static 
             */ 
            public static function fromSub($query, $as)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->fromSub($query, $as);
            }
         
            /**
             * Add a raw from clause to the query.
             *
             * @param string $expression
             * @param mixed $bindings
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function fromRaw($expression, $bindings = [])
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->fromRaw($expression, $bindings);
            }
         
            /**
             * Add a new select column to the query.
             *
             * @param array|mixed $column
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function addSelect($column)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->addSelect($column);
            }
         
            /**
             * Force the query to only return distinct results.
             *
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function distinct()
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->distinct();
            }
         
            /**
             * Set the table which the query is targeting.
             *
             * @param string $table
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function from($table)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->from($table);
            }
         
            /**
             * Add a join clause to the query.
             *
             * @param string $table
             * @param \Closure|string $first
             * @param string|null $operator
             * @param string|null $second
             * @param string $type
             * @param bool $where
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function join($table, $first, $operator = null, $second = null, $type = 'inner', $where = false)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->join($table, $first, $operator, $second, $type, $where);
            }
         
            /**
             * Add a "join where" clause to the query.
             *
             * @param string $table
             * @param \Closure|string $first
             * @param string $operator
             * @param string $second
             * @param string $type
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function joinWhere($table, $first, $operator, $second, $type = 'inner')
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->joinWhere($table, $first, $operator, $second, $type);
            }
         
            /**
             * Add a subquery join clause to the query.
             *
             * @param \Closure|\Illuminate\Database\Query\Builder|string $query
             * @param string $as
             * @param \Closure|string $first
             * @param string|null $operator
             * @param string|null $second
             * @param string $type
             * @param bool $where
             * @return \Illuminate\Database\Query\Builder|static 
             * @throws \InvalidArgumentException
             * @static 
             */ 
            public static function joinSub($query, $as, $first, $operator = null, $second = null, $type = 'inner', $where = false)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->joinSub($query, $as, $first, $operator, $second, $type, $where);
            }
         
            /**
             * Add a left join to the query.
             *
             * @param string $table
             * @param \Closure|string $first
             * @param string|null $operator
             * @param string|null $second
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function leftJoin($table, $first, $operator = null, $second = null)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->leftJoin($table, $first, $operator, $second);
            }
         
            /**
             * Add a "join where" clause to the query.
             *
             * @param string $table
             * @param \Closure|string $first
             * @param string $operator
             * @param string $second
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function leftJoinWhere($table, $first, $operator, $second)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->leftJoinWhere($table, $first, $operator, $second);
            }
         
            /**
             * Add a subquery left join to the query.
             *
             * @param \Closure|\Illuminate\Database\Query\Builder|string $query
             * @param string $as
             * @param \Closure|string $first
             * @param string|null $operator
             * @param string|null $second
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function leftJoinSub($query, $as, $first, $operator = null, $second = null)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->leftJoinSub($query, $as, $first, $operator, $second);
            }
         
            /**
             * Add a right join to the query.
             *
             * @param string $table
             * @param \Closure|string $first
             * @param string|null $operator
             * @param string|null $second
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function rightJoin($table, $first, $operator = null, $second = null)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->rightJoin($table, $first, $operator, $second);
            }
         
            /**
             * Add a "right join where" clause to the query.
             *
             * @param string $table
             * @param \Closure|string $first
             * @param string $operator
             * @param string $second
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function rightJoinWhere($table, $first, $operator, $second)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->rightJoinWhere($table, $first, $operator, $second);
            }
         
            /**
             * Add a subquery right join to the query.
             *
             * @param \Closure|\Illuminate\Database\Query\Builder|string $query
             * @param string $as
             * @param \Closure|string $first
             * @param string|null $operator
             * @param string|null $second
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function rightJoinSub($query, $as, $first, $operator = null, $second = null)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->rightJoinSub($query, $as, $first, $operator, $second);
            }
         
            /**
             * Add a "cross join" clause to the query.
             *
             * @param string $table
             * @param \Closure|string|null $first
             * @param string|null $operator
             * @param string|null $second
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function crossJoin($table, $first = null, $operator = null, $second = null)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->crossJoin($table, $first, $operator, $second);
            }
         
            /**
             * Merge an array of where clauses and bindings.
             *
             * @param array $wheres
             * @param array $bindings
             * @return void 
             * @static 
             */ 
            public static function mergeWheres($wheres, $bindings)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                $instance->mergeWheres($wheres, $bindings);
            }
         
            /**
             * Prepare the value and operator for a where clause.
             *
             * @param string $value
             * @param string $operator
             * @param bool $useDefault
             * @return array 
             * @throws \InvalidArgumentException
             * @static 
             */ 
            public static function prepareValueAndOperator($value, $operator, $useDefault = false)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->prepareValueAndOperator($value, $operator, $useDefault);
            }
         
            /**
             * Add a "where" clause comparing two columns to the query.
             *
             * @param string|array $first
             * @param string|null $operator
             * @param string|null $second
             * @param string|null $boolean
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function whereColumn($first, $operator = null, $second = null, $boolean = 'and')
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->whereColumn($first, $operator, $second, $boolean);
            }
         
            /**
             * Add an "or where" clause comparing two columns to the query.
             *
             * @param string|array $first
             * @param string|null $operator
             * @param string|null $second
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function orWhereColumn($first, $operator = null, $second = null)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->orWhereColumn($first, $operator, $second);
            }
         
            /**
             * Add a raw where clause to the query.
             *
             * @param string $sql
             * @param mixed $bindings
             * @param string $boolean
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function whereRaw($sql, $bindings = [], $boolean = 'and')
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->whereRaw($sql, $bindings, $boolean);
            }
         
            /**
             * Add a raw or where clause to the query.
             *
             * @param string $sql
             * @param mixed $bindings
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function orWhereRaw($sql, $bindings = [])
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->orWhereRaw($sql, $bindings);
            }
         
            /**
             * Add a "where in" clause to the query.
             *
             * @param string $column
             * @param mixed $values
             * @param string $boolean
             * @param bool $not
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function whereIn($column, $values, $boolean = 'and', $not = false)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->whereIn($column, $values, $boolean, $not);
            }
         
            /**
             * Add an "or where in" clause to the query.
             *
             * @param string $column
             * @param mixed $values
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function orWhereIn($column, $values)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->orWhereIn($column, $values);
            }
         
            /**
             * Add a "where not in" clause to the query.
             *
             * @param string $column
             * @param mixed $values
             * @param string $boolean
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function whereNotIn($column, $values, $boolean = 'and')
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->whereNotIn($column, $values, $boolean);
            }
         
            /**
             * Add an "or where not in" clause to the query.
             *
             * @param string $column
             * @param mixed $values
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function orWhereNotIn($column, $values)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->orWhereNotIn($column, $values);
            }
         
            /**
             * Add a "where in raw" clause for integer values to the query.
             *
             * @param string $column
             * @param \Illuminate\Contracts\Support\Arrayable|array $values
             * @param string $boolean
             * @param bool $not
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function whereIntegerInRaw($column, $values, $boolean = 'and', $not = false)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->whereIntegerInRaw($column, $values, $boolean, $not);
            }
         
            /**
             * Add a "where not in raw" clause for integer values to the query.
             *
             * @param string $column
             * @param \Illuminate\Contracts\Support\Arrayable|array $values
             * @param string $boolean
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function whereIntegerNotInRaw($column, $values, $boolean = 'and')
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->whereIntegerNotInRaw($column, $values, $boolean);
            }
         
            /**
             * Add a "where null" clause to the query.
             *
             * @param string|array $columns
             * @param string $boolean
             * @param bool $not
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function whereNull($columns, $boolean = 'and', $not = false)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->whereNull($columns, $boolean, $not);
            }
         
            /**
             * Add an "or where null" clause to the query.
             *
             * @param string $column
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function orWhereNull($column)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->orWhereNull($column);
            }
         
            /**
             * Add a "where not null" clause to the query.
             *
             * @param string $column
             * @param string $boolean
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function whereNotNull($column, $boolean = 'and')
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->whereNotNull($column, $boolean);
            }
         
            /**
             * Add a where between statement to the query.
             *
             * @param string $column
             * @param array $values
             * @param string $boolean
             * @param bool $not
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function whereBetween($column, $values, $boolean = 'and', $not = false)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->whereBetween($column, $values, $boolean, $not);
            }
         
            /**
             * Add an or where between statement to the query.
             *
             * @param string $column
             * @param array $values
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function orWhereBetween($column, $values)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->orWhereBetween($column, $values);
            }
         
            /**
             * Add a where not between statement to the query.
             *
             * @param string $column
             * @param array $values
             * @param string $boolean
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function whereNotBetween($column, $values, $boolean = 'and')
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->whereNotBetween($column, $values, $boolean);
            }
         
            /**
             * Add an or where not between statement to the query.
             *
             * @param string $column
             * @param array $values
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function orWhereNotBetween($column, $values)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->orWhereNotBetween($column, $values);
            }
         
            /**
             * Add an "or where not null" clause to the query.
             *
             * @param string $column
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function orWhereNotNull($column)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->orWhereNotNull($column);
            }
         
            /**
             * Add a "where date" statement to the query.
             *
             * @param string $column
             * @param string $operator
             * @param \DateTimeInterface|string|null $value
             * @param string $boolean
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function whereDate($column, $operator, $value = null, $boolean = 'and')
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->whereDate($column, $operator, $value, $boolean);
            }
         
            /**
             * Add an "or where date" statement to the query.
             *
             * @param string $column
             * @param string $operator
             * @param \DateTimeInterface|string|null $value
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function orWhereDate($column, $operator, $value = null)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->orWhereDate($column, $operator, $value);
            }
         
            /**
             * Add a "where time" statement to the query.
             *
             * @param string $column
             * @param string $operator
             * @param \DateTimeInterface|string|null $value
             * @param string $boolean
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function whereTime($column, $operator, $value = null, $boolean = 'and')
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->whereTime($column, $operator, $value, $boolean);
            }
         
            /**
             * Add an "or where time" statement to the query.
             *
             * @param string $column
             * @param string $operator
             * @param \DateTimeInterface|string|null $value
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function orWhereTime($column, $operator, $value = null)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->orWhereTime($column, $operator, $value);
            }
         
            /**
             * Add a "where day" statement to the query.
             *
             * @param string $column
             * @param string $operator
             * @param \DateTimeInterface|string|null $value
             * @param string $boolean
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function whereDay($column, $operator, $value = null, $boolean = 'and')
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->whereDay($column, $operator, $value, $boolean);
            }
         
            /**
             * Add an "or where day" statement to the query.
             *
             * @param string $column
             * @param string $operator
             * @param \DateTimeInterface|string|null $value
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function orWhereDay($column, $operator, $value = null)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->orWhereDay($column, $operator, $value);
            }
         
            /**
             * Add a "where month" statement to the query.
             *
             * @param string $column
             * @param string $operator
             * @param \DateTimeInterface|string|null $value
             * @param string $boolean
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function whereMonth($column, $operator, $value = null, $boolean = 'and')
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->whereMonth($column, $operator, $value, $boolean);
            }
         
            /**
             * Add an "or where month" statement to the query.
             *
             * @param string $column
             * @param string $operator
             * @param \DateTimeInterface|string|null $value
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function orWhereMonth($column, $operator, $value = null)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->orWhereMonth($column, $operator, $value);
            }
         
            /**
             * Add a "where year" statement to the query.
             *
             * @param string $column
             * @param string $operator
             * @param \DateTimeInterface|string|int|null $value
             * @param string $boolean
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function whereYear($column, $operator, $value = null, $boolean = 'and')
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->whereYear($column, $operator, $value, $boolean);
            }
         
            /**
             * Add an "or where year" statement to the query.
             *
             * @param string $column
             * @param string $operator
             * @param \DateTimeInterface|string|int|null $value
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function orWhereYear($column, $operator, $value = null)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->orWhereYear($column, $operator, $value);
            }
         
            /**
             * Add a nested where statement to the query.
             *
             * @param \Closure $callback
             * @param string $boolean
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function whereNested($callback, $boolean = 'and')
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->whereNested($callback, $boolean);
            }
         
            /**
             * Create a new query instance for nested where condition.
             *
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function forNestedWhere()
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->forNestedWhere();
            }
         
            /**
             * Add another query builder as a nested where to the query builder.
             *
             * @param \Illuminate\Database\Query\Builder|static $query
             * @param string $boolean
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function addNestedWhereQuery($query, $boolean = 'and')
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->addNestedWhereQuery($query, $boolean);
            }
         
            /**
             * Add an exists clause to the query.
             *
             * @param \Closure $callback
             * @param string $boolean
             * @param bool $not
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function whereExists($callback, $boolean = 'and', $not = false)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->whereExists($callback, $boolean, $not);
            }
         
            /**
             * Add an or exists clause to the query.
             *
             * @param \Closure $callback
             * @param bool $not
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function orWhereExists($callback, $not = false)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->orWhereExists($callback, $not);
            }
         
            /**
             * Add a where not exists clause to the query.
             *
             * @param \Closure $callback
             * @param string $boolean
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function whereNotExists($callback, $boolean = 'and')
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->whereNotExists($callback, $boolean);
            }
         
            /**
             * Add a where not exists clause to the query.
             *
             * @param \Closure $callback
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function orWhereNotExists($callback)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->orWhereNotExists($callback);
            }
         
            /**
             * Add an exists clause to the query.
             *
             * @param \Illuminate\Database\Query\Builder $query
             * @param string $boolean
             * @param bool $not
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function addWhereExistsQuery($query, $boolean = 'and', $not = false)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->addWhereExistsQuery($query, $boolean, $not);
            }
         
            /**
             * Adds a where condition using row values.
             *
             * @param array $columns
             * @param string $operator
             * @param array $values
             * @param string $boolean
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function whereRowValues($columns, $operator, $values, $boolean = 'and')
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->whereRowValues($columns, $operator, $values, $boolean);
            }
         
            /**
             * Adds a or where condition using row values.
             *
             * @param array $columns
             * @param string $operator
             * @param array $values
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function orWhereRowValues($columns, $operator, $values)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->orWhereRowValues($columns, $operator, $values);
            }
         
            /**
             * Add a "where JSON contains" clause to the query.
             *
             * @param string $column
             * @param mixed $value
             * @param string $boolean
             * @param bool $not
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function whereJsonContains($column, $value, $boolean = 'and', $not = false)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->whereJsonContains($column, $value, $boolean, $not);
            }
         
            /**
             * Add a "or where JSON contains" clause to the query.
             *
             * @param string $column
             * @param mixed $value
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function orWhereJsonContains($column, $value)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->orWhereJsonContains($column, $value);
            }
         
            /**
             * Add a "where JSON not contains" clause to the query.
             *
             * @param string $column
             * @param mixed $value
             * @param string $boolean
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function whereJsonDoesntContain($column, $value, $boolean = 'and')
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->whereJsonDoesntContain($column, $value, $boolean);
            }
         
            /**
             * Add a "or where JSON not contains" clause to the query.
             *
             * @param string $column
             * @param mixed $value
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function orWhereJsonDoesntContain($column, $value)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->orWhereJsonDoesntContain($column, $value);
            }
         
            /**
             * Add a "where JSON length" clause to the query.
             *
             * @param string $column
             * @param mixed $operator
             * @param mixed $value
             * @param string $boolean
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function whereJsonLength($column, $operator, $value = null, $boolean = 'and')
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->whereJsonLength($column, $operator, $value, $boolean);
            }
         
            /**
             * Add a "or where JSON length" clause to the query.
             *
             * @param string $column
             * @param mixed $operator
             * @param mixed $value
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function orWhereJsonLength($column, $operator, $value = null)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->orWhereJsonLength($column, $operator, $value);
            }
         
            /**
             * Handles dynamic "where" clauses to the query.
             *
             * @param string $method
             * @param array $parameters
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function dynamicWhere($method, $parameters)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->dynamicWhere($method, $parameters);
            }
         
            /**
             * Add a "group by" clause to the query.
             *
             * @param array $groups
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function groupBy(...$groups)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->groupBy(...$groups);
            }
         
            /**
             * Add a "having" clause to the query.
             *
             * @param string $column
             * @param string|null $operator
             * @param string|null $value
             * @param string $boolean
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function having($column, $operator = null, $value = null, $boolean = 'and')
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->having($column, $operator, $value, $boolean);
            }
         
            /**
             * Add a "or having" clause to the query.
             *
             * @param string $column
             * @param string|null $operator
             * @param string|null $value
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function orHaving($column, $operator = null, $value = null)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->orHaving($column, $operator, $value);
            }
         
            /**
             * Add a "having between " clause to the query.
             *
             * @param string $column
             * @param array $values
             * @param string $boolean
             * @param bool $not
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function havingBetween($column, $values, $boolean = 'and', $not = false)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->havingBetween($column, $values, $boolean, $not);
            }
         
            /**
             * Add a raw having clause to the query.
             *
             * @param string $sql
             * @param array $bindings
             * @param string $boolean
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function havingRaw($sql, $bindings = [], $boolean = 'and')
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->havingRaw($sql, $bindings, $boolean);
            }
         
            /**
             * Add a raw or having clause to the query.
             *
             * @param string $sql
             * @param array $bindings
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function orHavingRaw($sql, $bindings = [])
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->orHavingRaw($sql, $bindings);
            }
         
            /**
             * Add an "order by" clause to the query.
             *
             * @param string $column
             * @param string $direction
             * @return \Illuminate\Database\Query\Builder 
             * @throws \InvalidArgumentException
             * @static 
             */ 
            public static function orderBy($column, $direction = 'asc')
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->orderBy($column, $direction);
            }
         
            /**
             * Add a descending "order by" clause to the query.
             *
             * @param string $column
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function orderByDesc($column)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->orderByDesc($column);
            }
         
            /**
             * Put the query's results in random order.
             *
             * @param string $seed
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function inRandomOrder($seed = '')
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->inRandomOrder($seed);
            }
         
            /**
             * Add a raw "order by" clause to the query.
             *
             * @param string $sql
             * @param array $bindings
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function orderByRaw($sql, $bindings = [])
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->orderByRaw($sql, $bindings);
            }
         
            /**
             * Alias to set the "offset" value of the query.
             *
             * @param int $value
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function skip($value)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->skip($value);
            }
         
            /**
             * Set the "offset" value of the query.
             *
             * @param int $value
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function offset($value)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->offset($value);
            }
         
            /**
             * Alias to set the "limit" value of the query.
             *
             * @param int $value
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function take($value)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->take($value);
            }
         
            /**
             * Set the "limit" value of the query.
             *
             * @param int $value
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function limit($value)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->limit($value);
            }
         
            /**
             * Set the limit and offset for a given page.
             *
             * @param int $page
             * @param int $perPage
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function forPage($page, $perPage = 15)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->forPage($page, $perPage);
            }
         
            /**
             * Constrain the query to the previous "page" of results before a given ID.
             *
             * @param int $perPage
             * @param int|null $lastId
             * @param string $column
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function forPageBeforeId($perPage = 15, $lastId = 0, $column = 'id')
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->forPageBeforeId($perPage, $lastId, $column);
            }
         
            /**
             * Constrain the query to the next "page" of results after a given ID.
             *
             * @param int $perPage
             * @param int|null $lastId
             * @param string $column
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function forPageAfterId($perPage = 15, $lastId = 0, $column = 'id')
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->forPageAfterId($perPage, $lastId, $column);
            }
         
            /**
             * Add a union statement to the query.
             *
             * @param \Illuminate\Database\Query\Builder|\Closure $query
             * @param bool $all
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function union($query, $all = false)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->union($query, $all);
            }
         
            /**
             * Add a union all statement to the query.
             *
             * @param \Illuminate\Database\Query\Builder|\Closure $query
             * @return \Illuminate\Database\Query\Builder|static 
             * @static 
             */ 
            public static function unionAll($query)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->unionAll($query);
            }
         
            /**
             * Lock the selected rows in the table.
             *
             * @param string|bool $value
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function lock($value = true)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->lock($value);
            }
         
            /**
             * Lock the selected rows in the table for updating.
             *
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function lockForUpdate()
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->lockForUpdate();
            }
         
            /**
             * Share lock the selected rows in the table.
             *
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function sharedLock()
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->sharedLock();
            }
         
            /**
             * Get the SQL representation of the query.
             *
             * @return string 
             * @static 
             */ 
            public static function toSql()
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->toSql();
            }
         
            /**
             * Get the count of the total records for the paginator.
             *
             * @param array $columns
             * @return int 
             * @static 
             */ 
            public static function getCountForPagination($columns = [])
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->getCountForPagination($columns);
            }
         
            /**
             * Concatenate values of a given column as a string.
             *
             * @param string $column
             * @param string $glue
             * @return string 
             * @static 
             */ 
            public static function implode($column, $glue = '')
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->implode($column, $glue);
            }
         
            /**
             * Determine if any rows exist for the current query.
             *
             * @return bool 
             * @static 
             */ 
            public static function exists()
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->exists();
            }
         
            /**
             * Determine if no rows exist for the current query.
             *
             * @return bool 
             * @static 
             */ 
            public static function doesntExist()
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->doesntExist();
            }
         
            /**
             * Retrieve the "count" result of the query.
             *
             * @param string $columns
             * @return int 
             * @static 
             */ 
            public static function count($columns = '*')
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->count($columns);
            }
         
            /**
             * Retrieve the minimum value of a given column.
             *
             * @param string $column
             * @return mixed 
             * @static 
             */ 
            public static function min($column)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->min($column);
            }
         
            /**
             * Retrieve the maximum value of a given column.
             *
             * @param string $column
             * @return mixed 
             * @static 
             */ 
            public static function max($column)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->max($column);
            }
         
            /**
             * Retrieve the sum of the values of a given column.
             *
             * @param string $column
             * @return mixed 
             * @static 
             */ 
            public static function sum($column)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->sum($column);
            }
         
            /**
             * Retrieve the average of the values of a given column.
             *
             * @param string $column
             * @return mixed 
             * @static 
             */ 
            public static function avg($column)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->avg($column);
            }
         
            /**
             * Alias for the "avg" method.
             *
             * @param string $column
             * @return mixed 
             * @static 
             */ 
            public static function average($column)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->average($column);
            }
         
            /**
             * Execute an aggregate function on the database.
             *
             * @param string $function
             * @param array $columns
             * @return mixed 
             * @static 
             */ 
            public static function aggregate($function, $columns = [])
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->aggregate($function, $columns);
            }
         
            /**
             * Execute a numeric aggregate function on the database.
             *
             * @param string $function
             * @param array $columns
             * @return float|int 
             * @static 
             */ 
            public static function numericAggregate($function, $columns = [])
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->numericAggregate($function, $columns);
            }
         
            /**
             * Insert a new record into the database.
             *
             * @param array $values
             * @return bool 
             * @static 
             */ 
            public static function insert($values)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->insert($values);
            }
         
            /**
             * Insert a new record into the database while ignoring errors.
             *
             * @param array $values
             * @return int 
             * @static 
             */ 
            public static function insertOrIgnore($values)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->insertOrIgnore($values);
            }
         
            /**
             * Insert a new record and get the value of the primary key.
             *
             * @param array $values
             * @param string|null $sequence
             * @return int 
             * @static 
             */ 
            public static function insertGetId($values, $sequence = null)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->insertGetId($values, $sequence);
            }
         
            /**
             * Insert new records into the table using a subquery.
             *
             * @param array $columns
             * @param \Closure|\Illuminate\Database\Query\Builder|string $query
             * @return bool 
             * @static 
             */ 
            public static function insertUsing($columns, $query)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->insertUsing($columns, $query);
            }
         
            /**
             * Insert or update a record matching the attributes, and fill it with values.
             *
             * @param array $attributes
             * @param array $values
             * @return bool 
             * @static 
             */ 
            public static function updateOrInsert($attributes, $values = [])
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->updateOrInsert($attributes, $values);
            }
         
            /**
             * Run a truncate statement on the table.
             *
             * @return void 
             * @static 
             */ 
            public static function truncate()
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                $instance->truncate();
            }
         
            /**
             * Create a raw database expression.
             *
             * @param mixed $value
             * @return \Illuminate\Database\Query\Expression 
             * @static 
             */ 
            public static function raw($value)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->raw($value);
            }
         
            /**
             * Get the current query value bindings in a flattened array.
             *
             * @return array 
             * @static 
             */ 
            public static function getBindings()
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->getBindings();
            }
         
            /**
             * Get the raw array of bindings.
             *
             * @return array 
             * @static 
             */ 
            public static function getRawBindings()
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->getRawBindings();
            }
         
            /**
             * Set the bindings on the query builder.
             *
             * @param array $bindings
             * @param string $type
             * @return \Illuminate\Database\Query\Builder 
             * @throws \InvalidArgumentException
             * @static 
             */ 
            public static function setBindings($bindings, $type = 'where')
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->setBindings($bindings, $type);
            }
         
            /**
             * Add a binding to the query.
             *
             * @param mixed $value
             * @param string $type
             * @return \Illuminate\Database\Query\Builder 
             * @throws \InvalidArgumentException
             * @static 
             */ 
            public static function addBinding($value, $type = 'where')
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->addBinding($value, $type);
            }
         
            /**
             * Merge an array of bindings into our bindings.
             *
             * @param \Illuminate\Database\Query\Builder $query
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function mergeBindings($query)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->mergeBindings($query);
            }
         
            /**
             * Get the database query processor instance.
             *
             * @return \Illuminate\Database\Query\Processors\Processor 
             * @static 
             */ 
            public static function getProcessor()
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->getProcessor();
            }
         
            /**
             * Get the query grammar instance.
             *
             * @return \Illuminate\Database\Query\Grammars\Grammar 
             * @static 
             */ 
            public static function getGrammar()
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->getGrammar();
            }
         
            /**
             * Use the write pdo for query.
             *
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function useWritePdo()
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->useWritePdo();
            }
         
            /**
             * Clone the query without the given properties.
             *
             * @param array $properties
             * @return static 
             * @static 
             */ 
            public static function cloneWithout($properties)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->cloneWithout($properties);
            }
         
            /**
             * Clone the query without the given bindings.
             *
             * @param array $except
             * @return static 
             * @static 
             */ 
            public static function cloneWithoutBindings($except)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->cloneWithoutBindings($except);
            }
         
            /**
             * Dump the current SQL and bindings.
             *
             * @return \Illuminate\Database\Query\Builder 
             * @static 
             */ 
            public static function dump()
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->dump();
            }
         
            /**
             * Die and dump the current SQL and bindings.
             *
             * @return void 
             * @static 
             */ 
            public static function dd()
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                $instance->dd();
            }
         
            /**
             * Register a custom macro.
             *
             * @param string $name
             * @param object|callable $macro
             * @return void 
             * @static 
             */ 
            public static function macro($name, $macro)
            {
                                \Illuminate\Database\Query\Builder::macro($name, $macro);
            }
         
            /**
             * Mix another object into the class.
             *
             * @param object $mixin
             * @param bool $replace
             * @return void 
             * @throws \ReflectionException
             * @static 
             */ 
            public static function mixin($mixin, $replace = true)
            {
                                \Illuminate\Database\Query\Builder::mixin($mixin, $replace);
            }
         
            /**
             * Checks if macro is registered.
             *
             * @param string $name
             * @return bool 
             * @static 
             */ 
            public static function hasMacro($name)
            {
                                return \Illuminate\Database\Query\Builder::hasMacro($name);
            }
         
            /**
             * Dynamically handle calls to the class.
             *
             * @param string $method
             * @param array $parameters
             * @return mixed 
             * @throws \BadMethodCallException
             * @static 
             */ 
            public static function macroCall($method, $parameters)
            {
                                /** @var \Illuminate\Database\Query\Builder $instance */
                                return $instance->macroCall($method, $parameters);
            }
        }

    class Event extends \Illuminate\Support\Facades\Event {}

    class File extends \Illuminate\Support\Facades\File {}

    class Gate extends \Illuminate\Support\Facades\Gate {}

    class Hash extends \Illuminate\Support\Facades\Hash {}

    class Lang extends \Illuminate\Support\Facades\Lang {}

    class Log extends \Illuminate\Support\Facades\Log {}

    class Mail extends \Illuminate\Support\Facades\Mail {}

    class Notification extends \Illuminate\Support\Facades\Notification {}

    class Password extends \Illuminate\Support\Facades\Password {}

    class Queue extends \Illuminate\Support\Facades\Queue {}

    class Redirect extends \Illuminate\Support\Facades\Redirect {}

    class Request extends \Illuminate\Support\Facades\Request {}

    class Response extends \Illuminate\Support\Facades\Response {}

    class Route extends \Illuminate\Support\Facades\Route {}

    class Schema extends \Illuminate\Support\Facades\Schema {}

    class Session extends \Illuminate\Support\Facades\Session {}

    class Storage extends \Illuminate\Support\Facades\Storage {}

    class Str extends \Illuminate\Support\Str {}

    class URL extends \Illuminate\Support\Facades\URL {}

    class Validator extends \Illuminate\Support\Facades\Validator {}

    class View extends \Illuminate\Support\Facades\View {}

    class Image extends \Intervention\Image\Facades\Image {}
}




