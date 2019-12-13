<?php

namespace App\Serializers;

use League\Fractal\Serializer\DataArraySerializer;

class JSendSerializer extends DataArraySerializer
{
    /**
     * Serialize a collection.
     *
     * @param string $resourceKey
     * @param array  $data
     *
     * @return array
     */
    public function collection($resourceKey, array $data)
    {
        return [
            'status' => 'success',
            'data' => [
                str_plural($resourceKey) => $data
            ]
        ];
    }

    /**
     * Serialize an item.
     *
     * @param string $resourceKey
     * @param array  $data
     *
     * @return array
     */
    public function item($resourceKey, array $data)
    {
        return [
            'status' => 'success',
            'data' => [
                str_singular($resourceKey) => $data
            ]
        ];
    }

    /**
     * Serialize a null item
     *
     * @return array|null
     */
    public function null()
    {
        return [
            'status' => 'success',
            'data' => null
        ];
    }

    /**
     * Merge includes
     *
     * @param $transformedData
     * @param $includedData
     * @return array
     */
    public function mergeIncludes($transformedData, $includedData)
    {
        $includedData = collect($includedData)->flatMap(function ($include, $key) {
            // check for null resource
            if ($include['data'] === null) {
                return [
                    str_singular($key) => null
                ];
            }

            return $include['data'];
        })->toArray();

        return parent::mergeIncludes($transformedData, $includedData);
    }
}
