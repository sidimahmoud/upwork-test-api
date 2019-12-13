<?php

namespace App\Modules\BaseModule\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use League\Fractal\TransformerAbstract;

interface BaseRepository
{
    public function setModel(?Model $model);

    public function processItemTransformer($item, TransformerAbstract $transformer, string $resourceKey, array $includes = []): array;

    public function processCollectionTransformer($data, TransformerAbstract $transformer, string $resourceKey, array $includes = []): array;

    public function create(array $data): Model;

    public function findById(int $id): Model;

    public function findByParams(array $params): Model;

    public function getByParams(array $params): Collection;

    public function paginateByParams(array $params): LengthAwarePaginator;

    public function get(): Collection;

    public function paginate(): LengthAwarePaginator;

    public function update(array $data): bool;

    public function delete(): bool;

    public function transformNull(): array;

    public function transformItem(array $includes = []): array;

    public function transformCollection($data, array $includes = []): array;

    public function getTransformer(): TransformerAbstract;

    public function getResourceKey(): string;

    public function withQueryBuilder(): self;

    public function withoutQueryBuilder(): self;
}
