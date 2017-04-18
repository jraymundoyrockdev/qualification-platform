<?php

use App\Http\Controllers\Api\Transformers\QualificationTransformer;
use App\Modules\Qualification\Qualification;
use Ramsey\Uuid\Uuid;

class QualificationTransformerTest extends BaseTestCase
{
    /** @test */
    public function it_transform_qualification_into_an_api_payload()
    {
        $qualification = entity(Qualification::class)->make(['id' => Uuid::uuid4()]);

        $transformer = new QualificationTransformer();

        $result = $transformer->transform($qualification);

        $expectedKeys = [
            'id',
            'code',
            'title',
            'description',
            'subject_information',
            'is_superseded',
            'links'
        ];

        $this->assertArrayHasOnlyKeys($expectedKeys, $result);
    }
}
