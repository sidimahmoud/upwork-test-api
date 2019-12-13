<?php

namespace App\Managers;

use App\Serializers\JSendSerializer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection as FractalCollection;
use League\Fractal\Resource\Item as FractalItem;
use League\Fractal\Resource\NullResource;
use League\Fractal\Scope;

class ItemAndCollectionManager
{
    /**
     * @var Manager
     */
    private $manager;

    /**
     * ItemManager constructor.
     * @param Manager $manager
     */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param FractalCollection|FractalItem|NullResource $item
     * @param array $includes
     * @return Scope
     */
    public function createData($object, array $includes = []) : Scope
    {
        $this->manager->parseIncludes($includes);
        $this->manager->setSerializer(new JSendSerializer());
        return $this->manager->createData($object);
    }
}
