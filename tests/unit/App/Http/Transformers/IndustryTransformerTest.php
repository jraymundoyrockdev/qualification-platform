<?php

use App\Http\Controllers\Api\Transformers\IndustryTransformer;
use App\Modules\Industry\Industry;
use Ramsey\Uuid\Uuid;

class IndustryTransformerTest extends BaseTestCase
{
    /** @test */
    public function it_transform_industry_into_an_api_payload()
    {
        $industry = entity(Industry::class)->make(['id' => Uuid::uuid4()]);

        $transformer = new IndustryTransformer();

        $result = $transformer->transform($industry);

        $expectedKeys = [
            'id',
            'code',
            'title',
            'description',
            'parent_code',
            'active',
            'links'
        ];

        $this->assertArrayHasOnlyKeys($expectedKeys, $result);
    }
}
