<?php

namespace App\Http\Response;

use App\Http\Serializers\JsonApiSerializerCustom;
use Illuminate\Support\Facades\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Symfony\Component\HttpFoundation\Response;

class FractalResponse extends AbstractApiResponse
{

    protected $meta = [];

    /**
     * ItemResponse constructor.
     *
     * @param Manager $manager
     */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
        $this->manager->setSerializer(new JsonApiSerializerCustom());
    }

    /**
     * @param object $entity
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function item($entity)
    {
        $entityBaseName = $this->getEntityBaseClassName($entity);
        $data = new Item($entity, $this->getTransformer($entityBaseName), $this->getType($entityBaseName));

        return $this->outputToJson($this->setMetaAndCreateData($data));
    }

    /**
     * @param object $entity
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function collection($entity)
    {
        $entityBaseName = $this->getEntityBaseClassName($entity[0]);
        $data = new Collection($entity, $this->getTransformer($entityBaseName), $this->getType($entityBaseName));

        return $this->outputToJson($this->setMetaAndCreateData($data));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function nullResource()
    {
        return $this->outputToJson([
            'data' => [],
            'links' => ['self' => Request::url()]
        ]);
    }

    /**
     * @param object $entity
     *
     * @return Response
     */
    public function insertSuccess($entity)
    {
        return $this->setStatusCode(Response::HTTP_CREATED)->item($entity);
    }

    /**
     * @param object $entity
     *
     * @return Response
     */
    public function updateSuccess($entity)
    {
        return $this->setStatusCode(Response::HTTP_OK)->item($entity);
    }

    /**
     * @param Item|Collection $data
     *
     * @return array
     */
    protected function setMetaAndCreateData($data)
    {
        $data->setMeta($this->getMeta());

        return $this->manager->createData($data)->toArray();
    }

    /**
     * @param string $entityBaseName
     *
     * @return object
     */
    protected function getTransformer($entityBaseName)
    {
        $transformer = 'App\Http\Controllers\Api\Transformers\\' . $entityBaseName . 'Transformer';

        return new $transformer;
    }

    /**
     * @param string $entityBaseName
     *
     * @return string
     */
    protected function getType($entityBaseName)
    {
        $re = '/(?<=[a-z])(?=[A-Z])/x';
        $a = preg_split($re, $entityBaseName);
        $entity = join($a, "_");

        return strtolower($entity);
    }

    /**
     * @param object $entity
     *
     * @return string
     */
    protected function getEntityBaseClassName($entity)
    {
        $chunkEntityPath = explode('\\', get_class($entity));

        return array_pop($chunkEntityPath);
    }
}
