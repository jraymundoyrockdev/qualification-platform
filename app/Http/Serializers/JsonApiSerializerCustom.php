<?php

namespace App\Http\Serializers;

use App\Resolvers\RequestResolver;
use Illuminate\Support\Facades\Request;
use InvalidArgumentException;
use League\Fractal\Serializer\ArraySerializer;

class JsonApiSerializerCustom extends ArraySerializer
{
    use RequestResolver;

    /**
     * @var string
     */
    protected $baseApiUrl;

    /**
     * @var string
     */
    protected $fullUrl;

    /**
     * JsonApiSerializerCustom constructor.
     */
    public function __construct()
    {
        $this->baseApiUrl = $this->getBaseApiRoot();
        $this->fullUrl = $this->getFullUrl();
    }

    /**
     * Serialize an item.
     *
     * @param string $resourceKey
     * @param array $data
     *
     * @return array
     */
    public function item($resourceKey, array $data)
    {
        $id = $this->getIdFromData($data);

        $resource = [
            'data' => [
                'type' => $resourceKey,
                'id' => "$id",
                'attributes' => $data,
            ],
        ];

        unset($resource['data']['attributes']['id']);

        $resource['links']['self'] = "{$this->baseApiUrl}" . $resource['data']['attributes']['links']['uri'];

        unset($resource['data']['attributes']['links']);

        if (array_key_exists('relationships', $resource['data']['attributes'])) {
            $resource['data']['relationships'] = $resource['data']['attributes']['relationships'];
            unset($resource['data']['attributes']['relationships']);
        }
        return $resource;
    }

    /**
     * Serialize a collection.
     *
     * @param string $resourceKey
     * @param array $data
     *
     * @return array
     */
    public function collection($resourceKey, array $data)
    {
        $resources = [];

        foreach ($data as $resource) {
            $resources[] = $this->item($resourceKey, $resource);
        }

        return [
            'data' => $resources,
            'links' => ['self' => $this->getFullUrl()]
        ];
    }

    /**
     * @param array $data
     *
     * @return integer
     */
    protected function getIdFromData(array $data)
    {
        if (!array_key_exists('id', $data)) {
            throw new InvalidArgumentException(
                'JSON API resource objects MUST have a valid id'
            );
        }

        return $data['id'];
    }
}
