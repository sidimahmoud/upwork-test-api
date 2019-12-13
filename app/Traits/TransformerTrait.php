<?php

namespace App\Traits;

use App\Managers\ItemAndCollectionManager;
use App\Transformers\BasicTransformer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\NullResource;
use League\Fractal\TransformerAbstract;

trait TransformerTrait
{
    /**
     * @return array
     */
    public function transformNull(): array
    {
        $manager = new ItemAndCollectionManager(new Manager);

        $item = new NullResource(null, $this->getTransformer(), $this->getResourceKey());

        return $manager->createData(
            $item
        )->toArray();
    }

    /**
     * Process item transformer
     *
     * @param object|null $item
     * @param TransformerAbstract $transformer
     * @param string $resourceKey
     * @param array $includes
     * @return array
     */
    public function processItemTransformer($item, TransformerAbstract $transformer, string $resourceKey, array $includes = []): array
    {
        $manager = new ItemAndCollectionManager(new Manager);

        if (!$item) {
            $item = new NullResource(null, $transformer, $resourceKey);
        } else {
            $item = new Item($item, $transformer, $resourceKey);
        }

        return $manager->createData(
            $item,
            $includes
        )->toArray();
    }

    /**
     * Process collection transformer
     *
     * @param $data
     * @param TransformerAbstract $transformer
     * @param string $resourceKey
     * @param array $includes
     * @return array
     */
    public function processCollectionTransformer($data, TransformerAbstract $transformer, string $resourceKey, array $includes = []): array
    {
        $manager = new ItemAndCollectionManager(new Manager);

        // paginated
        if ($data instanceof LengthAwarePaginator) {
            $queryParams = array_diff_key($_GET, array_flip(['page']));
            $data->appends($queryParams);

            $fractalCollection = new Collection($data, $transformer, $resourceKey);
            $fractalCollection->setPaginator(new IlluminatePaginatorAdapter($data));
        } else {
            // full collection
            $fractalCollection = new Collection($data, $transformer, $resourceKey);
        }

        return $manager->createData(
            $fractalCollection,
            $includes
        )->toArray();
    }

    /**
     * @return TransformerAbstract
     */
    public function getTransformer(): TransformerAbstract
    {
        return new BasicTransformer;
    }

    /**
     * @return string
     */
    public function getResourceKey(): string
    {
        return 'items';
    }
}
