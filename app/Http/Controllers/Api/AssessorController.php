<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Response\ApiResponse;
use App\Http\Response\ErrorResponse;
use App\Modules\Assessor\Services\AssessorService;
use Illuminate\Http\Request;

class AssessorController extends ApiController
{
    /**
     * @var ApiResponse
     */
    protected $response;

    /**
     * @var AssessorService
     */
    protected $assessor;

    /**
     * AssessorController constructor.
     *
     * @param AssessorService $assessor
     * @param ApiResponse $response
     */
    public function __construct(AssessorService $assessor, ApiResponse $response)
    {
        $this->assessor = $assessor;
        $this->response = $response;
    }

    /**
     * @param string $id
     *
     * @return \Symfony\Component\HttpFoundation\Response | ErrorResponse
     */
    public function show($id)
    {
        $assessor = $this->assessor->findOneById($id);

        if (!$assessor) {
            return $this->response->error()->respondBadRequest();
        }

        return $this->response->fractal()->item($assessor);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function all()
    {
        $assessor = $this->assessor->findAll();

        if (!$assessor) {
            return $this->response->fractal()->nullResource();
        }

        return $this->response->fractal()->collection($assessor);
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request)
    {
        $assessor = $this->assessor->insert($request->all());

        return $this->response->fractal()->insertSuccess($assessor);
    }

    /**
     * @param Request $request
     * @param string $id
     *
     * @return \Symfony\Component\HttpFoundation\Response | ErrorResponse
     */
    public function update(Request $request, $id)
    {
        $assessor = $this->assessor->findOneById($id);

        if (!$assessor) {
            return $this->response->error()->respondBadRequest();
        }

        $assessor = $this->assessor->update($assessor, $request->all());

        return $this->response->fractal()->updateSuccess($assessor);
    }

    /**
     * @param string $id
     *
     * @return \Symfony\Component\HttpFoundation\Response | ErrorResponse
     */
    public function findAllCourse($id)
    {
        $assessor = $this->assessor->findOneById($id);

        if (!$assessor) {
            return $this->response->error()->respondBadRequest();
        }

        if (!$assessor->getAssessorCourse()[0]) {
            return $this->response->fractal()->nullResource();
        }

        return $this->response->fractal()->collection($assessor->getAssessorCourse());
    }
}
