<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Response\ApiResponse;
use App\Http\Response\ErrorResponse;
use App\Modules\unit\Services\UnitService;

class UnitController extends ApiController
{
    /**
     * @var ApiResponse
     */
    private $response;
    /**
     * @var Unit
     */
    private $unit;

    /**
     * UnitController constructor.
     *
     * @param UnitService $unit
     * @param ApiResponse $response
     */
    public function __construct(UnitService $unit, ApiResponse $response)
    {
        $this->unit = $unit;
        $this->response = $response;
    }

    /**
     * @param string $id
     *
     * @return \Symfony\Component\HttpFoundation\Response | ErrorResponse
     */
    public function show($id)
    {
        $unit = $this->unit->findOneById($id);

        if (!$unit) {
            return $this->response->error()->respondBadRequest();
        }

        return $this->response->fractal()->item($unit);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function all()
    {
        $unit = $this->unit->findAll();

        if (!$unit) {
            return $this->response->fractal()->nullResource();
        }

        return $this->response->fractal()->collection($unit);
    }
}
