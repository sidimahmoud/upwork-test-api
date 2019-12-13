<?php

namespace App\Modules\BaseModule\Repositories;

use App\Modules\BaseModule\Contracts\BaseRepository as BaseRepositoryContract;
use App\Traits\TransformerTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
//use Spatie\QueryBuilder\Filter as Filter;
use Spatie\QueryBuilder\QueryBuilder;

class BaseRepository implements BaseRepositoryContract
{
    use TransformerTrait;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var array
     */
    protected $allowedIncludes = [];

    /**
     * @var array
     */
    protected $allowedFilters = [];

    /**
     * @var array
     */
    protected $exactFilters = [
        'id'
    ];

    /**
     * @var array
     */
    protected $allowedAppends = [];

    /**
     * @var array
     */
    protected $allowedSorts = [];

    /**
     * @var bool
     */
    protected $queryBuilderEnabled = true;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
        //$this->makeFillableFiltersAndSorts();
    }

    /**
     * Set model
     *
     * @param Model|null $model
     */
    public function setModel(?Model $model)
    {
        $this->model = $model;
    }

    /**
     * Set the allowed filters and sorts to the model's fillable
     */

    /*protected function makeFillableFiltersAndSorts()
    {
        // get fillable
        $fillable = $this->model->getFillable();
        $fillable[] = $this->model->getCreatedAtColumn();
        $fillable[] = $this->model->getUpdatedAtColumn();

        // add default filters
        foreach ($fillable as $field) {
            if (!in_array($field, $this->exactFilters)) {
                $this->allowedFilters[] = $field;
            }
        }

        // add exact filters
        foreach ($this->exactFilters as $filter) {
            $this->allowedFilters[] = Filter::exact($filter);
        }

        // configure sorts
        $this->allowedSorts = $fillable;
        $this->allowedSorts[] = 'id';
    }*/

    /**
     * Create model
     *
     * @param array $data
     * @return Model|Builder
     */
    public function create(array $data): Model
    {
        return $this->newQuery()
            ->create($data);
    }

    /**
     * Find model by id
     *
     * @param int $id
     * @return Model
     */
    public function findById(int $id): Model
    {
        return $this->getQueryBuilderFor(
            $this->newQuery()
        )->findOrFail($id);
    }

    /**
     * Find model by params
     *
     * @param array $params
     * @return Model|Builder
     */
    public function findByParams(array $params): Model
    {
        $query = $this->newQuery()
            ->where($params);
        return $this->getQueryBuilderFor($query)
            ->firstOrFail();
    }

    /**
     * Find list by params
     *
     * @param array $params
     * @return \Illuminate\Support\Collection
     */
    public function getByParams(array $params): \Illuminate\Support\Collection
    {
        return $this->getQueryBuilderFor(
            $this->getBasicQuery()->where($params)
        )->get();
    }

    /**
     * @param array $params
     * @return LengthAwarePaginator
     */
    public function paginateByParams(array $params): LengthAwarePaginator
    {
        return $this->getQueryBuilderFor(
            $this->getBasicQuery()->where($params)
        )->paginate();
    }

    /**
     * @return Builder
     */
    protected function getBasicQuery()
    {
        $query = $this->newQuery();

        // check if search is performed
        if (request()->has('q') && $this->canSearch()) {
            $items = $this->getScoutQuery(
                (get_class($this->model))::search(request()->input('q'))
            )->get();
            $primaryKeys = $items->pluck($this->getPrimaryKey())->toArray();
            $query->whereIn($this->getPrimaryKey(), $primaryKeys);
        }

        return $query;
    }

    /**
     * Find model collection
     *
     * @return \Illuminate\Support\Collection
     */
    public function get(): \Illuminate\Support\Collection
    {
        return $this->getQueryBuilderFor(
            $this->getBasicQuery()
        )->get();
    }

    /**
     * Paginate model collection
     *
     * @return LengthAwarePaginator
     */
    public function paginate(): LengthAwarePaginator
    {
        return $this->getQueryBuilderFor(
            $this->getBasicQuery()
        )->paginate();
    }

    /**
     * Update model
     *
     * @param array $data
     * @return bool
     */
    public function update(array $data): bool
    {
        return $this->model->update($data);
    }

    /**
     * Delete model
     *
     * @return bool
     * @throws \Exception
     */
    public function delete(): bool
    {
        return $this->model->delete();
    }

    /**
     * @param array $includes
     * @return array
     */
    public function transformItem(array $includes = []): array
    {
        return $this->processItemTransformer($this->model, $this->getTransformer(), $this->getResourceKey(), $includes);
    }

    /**
     * @param $data
     * @param array $includes
     * @return array
     */
    public function transformCollection($data, array $includes = []): array
    {
        return $this->processCollectionTransformer($data, $this->getTransformer(), $this->getResourceKey(), $includes);
    }

    /**
     * Get query builder
     *
     * @param $query
     * @param null $request
     * @return QueryBuilder|Builder
     */
    protected function getQueryBuilderFor($query, $request = null)
    {
        if ($this->queryBuilderEnabled) {
            return QueryBuilder::for($query, $request)
                ->allowedIncludes($this->allowedIncludes)
                ->allowedFilters($this->allowedFilters)
                ->allowedAppends($this->allowedAppends)
                ->allowedSorts($this->allowedSorts);
        } else if (is_string($query)) {
            $query = ($query)::query();
        }

        return $query;
    }

    /**
     * @return Builder
     */
    protected function newQuery()
    {
        return $this->model->newQuery();
    }

    /**
     * @return BaseRepositoryContract
     */
    public function withQueryBuilder(): BaseRepositoryContract
    {
        $this->queryBuilderEnabled = true;
        return $this;
    }

    /**
     * @return BaseRepositoryContract
     */
    public function withoutQueryBuilder(): BaseRepositoryContract
    {
        $this->queryBuilderEnabled = false;
        return $this;
    }

    /**
     * @return bool
     */
    protected function canSearch(): bool
    {
        return false;
    }

    /**
     * @return string
     */
    protected function getPrimaryKey()
    {
        return 'id';
    }

    /**
     * @param \Laravel\Scout\Builder $builder
     * @return \Laravel\Scout\Builder
     */
    protected function getScoutQuery($builder)
    {
        return $builder;
    }
}
