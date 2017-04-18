<?php

use App\Http\Controllers\Api\Transformers\OccupationTransformer;
use App\Modules\Occupation\Occupation;
use Ramsey\Uuid\Uuid;

class OccupationTransformerTest extends BaseTestCase
{
    /** @test */
    public function it_transform_occupation_into_an_api_payload()
    {
        $occupation = entity(Occupation::class)->make(['id' => Uuid::uuid4()]);

        $transformer = new OccupationTransformer();

        $result = $transformer->transform($occupation);

        $expectedKeys = [
            'id',
            'code',
            'title',
            'description',
            'active',
            'links'
        ];

        $this->assertArrayHasOnlyKeys($expectedKeys, $result);
    }
}
