<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\PageNotFoundException;
use App\Exceptions\NotAValidQualificationException;
use App\Http\Controllers\ApiController;
use App\Http\Response\ApiResponse;
use App\Http\Response\ErrorResponse;
use App\Modules\Qualification\Services\QualificationService;
use App\Resolvers\RequestResolver;
use App\Services\Sync\SyncQualificationService;
use Illuminate\Http\Request;

class QualificationController extends ApiController
{
    use RequestResolver;

    /**
     * @var ApiResponse
     */
    protected $response;

    /**
     * @var QualificationService
     */
    protected $qualification;

    /**
     * @var SyncQualificationService
     */
    protected $syncService;

    /**
     * Qualification Controller constructor.
     *
     * @param QualificationService $qualification
     * @param ApiResponse $response
     * @param SyncQualificationService $syncQualification
     */
    public function __construct(
        QualificationService $qualification,
        ApiResponse $response,
        SyncQualificationService $syncQualification
    )
    {
        $this->qualification = $qualification;
        $this->response = $response;
        $this->syncQualification = $syncQualification;
    }

    /**
     * @param string $id
     *
     * @return \Symfony\Component\HttpFoundation\Response | ErrorResponse
     */
    public function show($id)
    {
        $qualification = $this->qualification->findOneById($id);

        if (!$qualification) {
            return $this->response->error()->respondBadRequest();
        }

        return $this->response->fractal()->item($qualification);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function all()
    {
        $qualification = $this->qualification->findAll();

        if (!$qualification) {
            return $this->response->fractal()->nullResource();
        }

        return $this->response->fractal()->collection($qualification);
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request)
    {
        $qualification = $this->qualification->insert($request->all());

        return $this->response->fractal()->insertSuccess($qualification);
    }

    /**
     * @param Request $request
     * @param string $id
     *
     * @return \Symfony\Component\HttpFoundation\Response | ErrorResponse
     */
    public function update(Request $request, $id)
    {
        $qualification = $this->qualification->findOneById($id);

        if (!$qualification) {
            return $this->response->error()->respondBadRequest();
        }

        $qualification = $this->qualification->update($qualification, $request->all());

        return $this->response->fractal()->updateSuccess($qualification);
    }

    /**
     * @param string $id
     *
     * @return \Symfony\Component\HttpFoundation\Response | ErrorResponse
     */
    public function findAllQualification($id)
    {
        $qualification = $this->qualification->findOneById($id);

        if (!$qualification) {
            return $this->response->error()->respondBadRequest();
        }
    }

    public function addFromTga(Request $request)
    {
        $attributes = $this->filterRequestAttributes($request->all());

        $qualificationCode = $attributes['code'];

        $qualification = $this->qualification->findOneByAttribute('code', $qualificationCode);

        if ($qualification) {
            return $this->response->error()->respondBadRequest('Qualification already exist.');
        }

        try {
            $qualification = $this->syncQualification->sync($qualificationCode);
        } catch (PageNotFoundException $exception) {
            return $this->response->error()->respondBadRequest('Qualification does not exist in TGA.');
        } catch (NotAValidQualificationException $exception) {
            return $this->response->error()->respondBadRequest('Component is not a valid Qualification.');
        }

        return $this->response->fractal()->insertSuccess($qualification);
    }

}
