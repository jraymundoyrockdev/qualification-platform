<?php

namespace App\Modules\Course\Services;

use App\Repositories\Contracts\CourseRepository;
use App\Resolvers\RequestResolver;
use App\Services\AbstractModuleService;

class CourseService extends AbstractModuleService
{
    use RequestResolver;

    /**
     * CourseService constructor.
     *
     * @param CourseRepository $course
     */
    public function __construct(CourseRepository $course)
    {
        parent::__construct($course);
    }
}
