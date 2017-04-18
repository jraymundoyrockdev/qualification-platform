<?php

use App\Http\Controllers\Api\Transformers\AssessorCourseTransformer;
use App\Modules\Assessor\Assessor;
use App\Modules\AssessorCourse\AssessorCourse;
use Ramsey\Uuid\Uuid;

class AssessorCourseTransformerTest extends BaseTestCase
{
    /** @test */
    public function it_transform_assessor_course_into_an_api_payload()
    {
        $assessor = entity(Assessor::class)->make(['id' => Uuid::uuid4()]);
        $assessorCourse = entity(AssessorCourse::class)->make(['id' => Uuid::uuid4()]);

        $assessorCourse->setAssessor($assessor);
        $transformer = new AssessorCourseTransformer();

        $result = $transformer->transform($assessorCourse);

        $expectedKeys = [
            'id',
            'assessor_id',
            'course_code',
            'cost',
            'links'
        ];

        $this->assertArrayHasOnlyKeys($expectedKeys, $result);
    }
}
