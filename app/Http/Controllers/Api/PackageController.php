<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Response\ApiResponse;
use App\Http\Response\ErrorResponse;
use App\Modules\Package\Services\PackageService;

class PackageController extends ApiController
{
    /**
     * @var ApiResponse
     */
    protected $response;
    /**
     * @var PackageService
     */
    protected $package;

    /**
     * CourseController constructor.
     *
     * @param PackageService $package
     * @param ApiResponse $response
     */
    public function __construct(PackageService $package, ApiResponse $response)
    {
        $this->package = $package;
        $this->response = $response;
    }

    /**
     * @param string $id
     *
     * @return \Symfony\Component\HttpFoundation\Response | ErrorResponse
     */
    public function show($id)
    {
        $package = $this->package->findOneById($id);

        if (!$package) {
            return $this->response->error()->respondBadRequest();
        }

        return $this->response->fractal()->item($package);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function all()
    {
        $package = $this->package->findAll();

        if (!$package) {
            return $this->response->fractal()->nullResource();
        }

        return $this->response->fractal()->collection($package);
    }
}
