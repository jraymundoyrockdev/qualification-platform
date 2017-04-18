<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Response\ApiResponse;
use App\Http\Response\ErrorResponse;
use App\Modules\Industry\Services\IndustryService;

class IndustryController extends ApiController
{
    /**
     * @var ApiResponse
     */
    protected $response;
    /**
     * @var IndustryService
     */
    protected $industry;

    /**
     * IndustryController constructor.
     *
     * @param IndustryService $industry
     * @param ApiResponse $response
     */
    public function __construct(IndustryService $industry, ApiResponse $response)
    {
        $this->industry = $industry;
        $this->response = $response;
    }

    /**
     * @param string $id
     *
     * @return \Symfony\Component\HttpFoundation\Response | ErrorResponse
     */
    public function show($id)
    {
        $industry = $this->industry->findOneById($id);

        if (!$industry) {
            return $this->response->error()->respondBadRequest();
        }

        return $this->response->fractal()->item($industry);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function all()
    {
        $industry = $this->industry->findAll();

        if (!$industry) {
            return $this->response->fractal()->nullResource();
        }

        return $this->response->fractal()->collection($industry);
    }
}
