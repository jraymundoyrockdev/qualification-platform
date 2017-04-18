<?php

namespace App\Http\Controllers\Api\Transformers;

use App\Modules\AssessorCourse\AssessorCourse;
use League\Fractal\TransformerAbstract;

class AssessorCourseTransformer extends TransformerAbstract
{
    /**
     * @param AssessorCourse $assessorCourse
     *
     * @return array
     */
    public function transform(AssessorCourse $assessorCourse)
    {
        return [
            'id' => $assessorCourse->getId(),
            'assessor_id' => $assessorCourse->getAssessor()->getId(),
            'course_code' => $assessorCourse->getCourseCode(),
            'cost' => $assessorCourse->getCost(),
            'links' => ['uri' => '/assessor_course/' . $assessorCourse->getId()]
        ];
    }
}
