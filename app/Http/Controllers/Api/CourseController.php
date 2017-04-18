<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Response\ApiResponse;
use App\Http\Response\ErrorResponse;
use App\Modules\Course\Services\CourseService;

class CourseController extends ApiController
{
    /**
     * @var ApiResponse
     */
    private $response;
    /**
     * @var CourseService
     */
    private $course;

    /**
     * CourseController constructor.
     *
     * @param CourseService $course
     * @param ApiResponse $response
     */
    public function __construct(CourseService $course, ApiResponse $response)
    {
        $this->course = $course;
        $this->response = $response;
    }

    /**
     * @param string $id
     *
     * @return \Symfony\Component\HttpFoundation\Response | ErrorResponse
     */
    public function show($id)
    {
        $course = $this->course->findOneById($id);

        if (!$course) {
            return $this->response->error()->respondBadRequest();
        }

        return $this->response->fractal()->item($course);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function all()
    {
        $course = $this->course->findAll();

        if (!$course) {
            return $this->response->fractal()->nullResource();
        }

        return $this->response->fractal()->collection($course);
    }
}
