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
            'packaging_rules',
            'currency_status',
            'status',
            'aqf_level',
            'online_learning_status',
            'rpl_status',
            'expiration_date',
            'created_by',
            'links'
        ];

        $this->assertArrayHasOnlyKeys($expectedKeys, $result);
    }
}
