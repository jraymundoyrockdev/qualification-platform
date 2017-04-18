<?php

namespace App\Resolvers;

use Illuminate\Http\Request as PayloadRequest;
use Illuminate\Support\Facades\Request;

trait RequestResolver
{
    /**
     * @param PayloadRequest $request
     *
     * @return null|string
     */
    public function getUriLastSegment(PayloadRequest $request)
    {
        return $request->segment(count($request->segments()));
    }

    /**
     * Return root with api/ path concat
     *
     * @return string
     */
    public function getBaseApiRoot()
    {
        return Request::root() . '/api';
    }

    /**
     * Return root with api/ path concat
     *
     * @return string
     */
    public function getFullUrl()
    {
        return Request::fullUrl();
    }

    /**
     * @param array $request
     *
     * @return string
     */
    public function filterRequestAttributes($request)
    {
        return $request['data']['attributes'];
    }

    /**
     * @param array $request
     * @param string $relationship
     *
     * @return string
     */
    public function filterRequestRelationships($request, $relationship)
    {
        return $request['data']['relationships'][$relationship]['data'];
    }
}
