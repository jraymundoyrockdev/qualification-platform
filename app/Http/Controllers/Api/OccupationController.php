<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Response\ApiResponse;
use App\Http\Response\ErrorResponse;
use App\Modules\Occupation\Services\OccupationService;

class OccupationController extends ApiController
{
    /**
     * @var ApiResponse
     */
    protected $response;
    /**
     * @var OccupationService
     */
    protected $occupation;

    /**
     * CourseController constructor.
     *
     * @param OccupationService $occupation
     * @param ApiResponse $response
     */
    public function __construct(OccupationService $occupation, ApiResponse $response)
    {
        $this->occupation = $occupation;
        $this->response = $response;
    }

    /**
     * @param string $id
     *
     * @return \Symfony\Component\HttpFoundation\Response | ErrorResponse
     */
    public function show($id)
    {
        $occupation = $this->occupation->findOneById($id);

        if (!$occupation) {
            return $this->response->error()->respondBadRequest();
        }

        return $this->response->fractal()->item($occupation);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function all()
    {
        $occupation = $this->occupation->findAll();

        if (!$occupation) {
            return $this->response->fractal()->nullResource();
        }

        return $this->response->fractal()->collection($occupation);
    }
}
