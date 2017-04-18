<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Response\ApiResponse;
use App\Http\Response\ErrorResponse;
use App\Repositories\Contracts\RTORepository;

class RTOController extends ApiController
{
    /**
     * @var RTORepository
     */
    private $rto;
    /**
     * @var ApiResponse
     */
    private $response;

    /**
     * RTOController constructor.
     * @param RTORepository $rto
     * @param ApiResponse $response
     */
    public function __construct(RTORepository $rto, ApiResponse $response)
    {
        $this->rto = $rto;
        $this->response = $response;
    }

    /**
     * @param string $id
     *
     * @return \Symfony\Component\HttpFoundation\Response|ErrorResponse
     */
    public function show($id)
    {
        $rto = $this->rto->findOneBy(['id' => $id]);

        if (!$rto) {
            return $this->response->error()->respondBadRequest();
        }

        return $this->response->fractal()->item($rto);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function all()
    {
        $rto = $this->rto->findAll();

        if (!$rto) {
            return $this->response->fractal()->nullResource();
        }

        return $this->response->fractal()->collection($rto);
    }
}
