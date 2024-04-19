<?php

namespace App\Packages\Emerald\Repositories;

use App\Packages\Emerald\Log\Log as Logger;
use BadMethodCallException;
use Error;
use Exception;
use Illuminate\{Database\Eloquent\Model, Pipeline\Pipeline, Support\Collection};
use ReflectionClass;
use ReflectionException;

abstract class Repository
{

    protected Pipeline $pipeline;
    protected $query;
    private array $selects = [];
    private array $wheres = [];
    private array $with = [];
    private array $visible = [];
    private array $orderBys = [];
    private int $take = 0;

    /**
     * BaseRepository constructor
     * @param Model $model
     */
    public function __construct(protected Model $model)
    {
    }


    /**
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all(array $columns = ['*']): Collection
    {
        return $this->model->all($columns);
    }

    /**
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): ?Model
    {
        $this->newQuery()->eagerLoad()->setClauses();
        return $this->query->find($id);
    }

    /**
     * @param array $array
     */
    public static function insert(array $array): void
    {
        (self::getInstance())->model->insert($array);
    }

    /**
     * @return Repository
     */
    public static function getInstance(): Repository
    {
        $class = static::class;
        try {
            $parameter = (new ReflectionClass($class))->getConstructor()?->getParameters()[0]->getClass()?->getName();
        } catch (ReflectionException $e) {
            dd($e->getMessage());
        }
        return (new $class(new $parameter));
    }
//
//    /**
//     * @param array $columns
//     * @return Collection
//     */
//    public static function all(array $columns = ['*']): Collection
//    {
//        return (self::getInstance())->model->all($columns);
//    }

    /**
     * @param $method
     * @param $parameters
     * @return mixed
     * @throws Exception
     */
    public static function __callStatic($method, $parameters)
    {
        try {
//            call_user_func_array($method, $parameters);
            return (self::getInstance())->{$method}($parameters);
        } catch (Error|BadMethodCallException $e) {
            $pattern = '~^Call to undefined method (?P<class>[^:]+)::(?P<method>[^\(]+)\(\)$~';

            if (!preg_match($pattern, $e->getMessage(), $matches)) {
                Logger::Logging($e);
                throw $e;
            }

            if ($matches['class'] != get_class(self::class) || $matches['method'] != $method) {
                Logger::Logging($e);
                throw $e;
            }

            Logger::Logging($exception = sprintf(
                'Call to undefined method %s::%s()', static::class, $method
            ));

            throw new BadMethodCallException($exception);
        }
    }

    /**
     * @return mixed
     */
    public function getQuery(): mixed
    {
        $this->newQuery()->eagerLoad()->setClauses();

        return $this->query;
    }

    /**
     * Add a simple where clause to the query.
     *
     * @param string|array $column
     * @return $this
     */
    public function selects(string|array $column): self
    {
        if (is_array($column)) {
            $this->selects = array_merge($this->selects, $column);
        } else {
            $this->selects[] = $column;
        }

        return $this;
    }

    /**
     * @param int $take
     * @return $this
     */
    public function take(int $take): self
    {
        $this->take = $take;

        return $this;
    }

    /**
     * @param int $take
     * @return $this
     */
    public function limit(int $take): self
    {
        $this->take = $take;

        return $this;
    }

    /**
     * @param array $columns
     * @return mixed
     */
    public function get(array $columns = ['*']): mixed
    {
        $this->newQuery()->eagerLoad()->setClauses();

        return $this->query->get($columns);
    }

    /**
     * Set clauses on the query builder.
     *
     * @return $this
     */
    protected function setClauses(): self
    {
        foreach ($this->wheres as $where) {
            $this->query->where($where['column'], $where['operator'], $where['value']);
        }
//
//        foreach ($this->whereIns as $whereIn) {
//            $this->query->whereIn($whereIn['column'], $whereIn['values']);
//        }
//
        foreach ($this->orderBys as $orders) {
            $this->query->orderBy($orders['column'], $orders['direction']);
        }

        if (!empty($this->take)) {
            $this->query->take($this->take);
        }

        if (count($this->selects)) {
            $this->query->select($this->selects);
        }

        return $this;
    }

    /**
     * Add a simple where clause to the query.
     *
     * @param string $column
     * @param string $value
     * @param string $operator
     *
     * @return $this
     */
    public function where(string $column, string $value, string $operator = '='): self
    {
        $this->wheres[] = compact('column', 'value', 'operator');

        return $this;
    }

    public function removeWhereConditions()
    {
        $this->wheres= [];
        return $this;

    }

    /**
     * Set an ORDER BY clause.
     *
     * @param string $column
     * @param string $direction
     * @return $this
     */
    public function orderBy(string $column, string $direction = 'asc'): self
    {
        $this->orderBys[] = compact('column', 'direction');

        return $this;
    }

    /**
     * Add relationships to the query builder to eager load.
     *
     * @return $this
     */
    protected function eagerLoad(): self
    {
        foreach ($this->with as $relation) {
            $this->query->with($relation);
        }

//        if (count($this->visible)) {
//            $this->query->makeVisible($this->visible);
//        }

//        foreach ($this->whereHas as $relation) {
//            $this->query->whereHas($relation);
//        }

        return $this;
    }

    /**
     * Set Eloquent relationships to eager load.
     *
     * @param $relations
     *
     * @return $this
     */
    public function with($relations): self
    {
        if (is_string($relations)) {
            $relations = func_get_args();
        }

        $this->with = $relations;

        return $this;
    }

    /**
     * RoleCreate a new instance of the service's query builder.
     *
     * @return $this
     */
    protected function newQuery(): self
    {
        $this->query = $this->model->newQuery();

        return $this;
    }

    /**
     * make column visible to eager load.
     *
     * @param array $columns
     * @return $this
     */
    public function makeVisible(array $columns): self
    {
        $this->visible = $columns;

        return $this;
    }

    /**
     * @param string $key
     * @param $value
     * @param bool $withTrashed
     * @return bool
     */
    public function exists(string $key, $value, bool $withTrashed = false): bool
    {
        $this->where($key, $value);

        $this->newQuery()->eagerLoad()->setClauses();

        if ($withTrashed && $this->query->hasMacro('withTrashed')) {
            $this->query->withTrashed();
        }

        return $this->query->exists();

    }


    /**
     * @param int $n
     * @param array $relations
     * @param bool $withTrashed
     * @param array $selects
     * @return mixed
     */
    public function getPaginate(int $n, array $relations = [], bool $withTrashed = false, array $selects = [])
    {
        $query = $this->initiateQuery($relations, $withTrashed, $selects);
        return $query->paginate($n);
    }


    /**
     * @param integer|string $id
     * @return mixed
     */
    public function getById(int|string $id): mixed
    {
        $this->newQuery()->eagerLoad()->setClauses();
        return $this->query->find($id);
    }

    /**
     * @param bool $withTrashed
     * @return mixed
     */
    public function countAll(bool $withTrashed = false): mixed
    {
        $query = $this->newQuery()->query;

        if ($withTrashed && $query->hasMacro('withTrashed')) {
            $query = $query->withTrashed();
        }

        return $query->count();
    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }


}
