<?php

use App\Http\Controllers\Api\Transformers\CourseTransformer;
use App\Modules\Course\Course;
use Ramsey\Uuid\Uuid;

class CourseTransformerTest extends BaseTestCase
{
    /** @test */
    public function it_transform_course_into_an_api_payload()
    {
        $course = entity(Course::class)->make(['id' => Uuid::uuid4()]);

        $transformer = new CourseTransformer();

        $result = $transformer->transform($course);

        $expectedKeys = [
            'id',
            'code',
            'name',
            'level',
            'training_package',
            'selling_price',
            'initial_price',
            'best_market_price',
            'user_comments',
            'target_market',
            'times_completed',
            'active',
            'status',
            'online',
            'trades',
            'faculty',
            'is_mapped',
            'links'
        ];

        $this->assertArrayHasOnlyKeys($expectedKeys, $result);
    }
}
