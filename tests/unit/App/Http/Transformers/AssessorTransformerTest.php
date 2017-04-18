<?php

use App\Http\Controllers\Api\Transformers\AssessorTransformer;
use App\Modules\Assessor\Assessor;
use Ramsey\Uuid\Uuid;

class AssessorTransformerTest extends BaseTestCase
{
    /** @test */
    public function it_transform_assessor_into_an_api_payload()
    {
        $assessor = entity(Assessor::class)->make(['id' => Uuid::uuid4()]);

        $transformer = new AssessorTransformer();

        $result = $transformer->transform($assessor);

        $expectedKeys = [
            'id',
            'name',
            'email',
            'mobile',
            'notes',
            'type',
            'links'
        ];

        $this->assertArrayHasOnlyKeys($expectedKeys, $result);
    }
}
