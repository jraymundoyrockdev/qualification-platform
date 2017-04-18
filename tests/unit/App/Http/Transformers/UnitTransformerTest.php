<?php

use App\Http\Controllers\Api\Transformers\UnitTransformer;
use App\Modules\Unit\Unit;
use Ramsey\Uuid\Uuid;

class UnitTransformerTest extends BaseTestCase
{
    /** @test */
    public function it_transform_unit_into_an_api_payload()
    {
        $unit = entity(Unit::class)->make(['id' => Uuid::uuid4()]);

        $transformer = new UnitTransformer();

        $result = $transformer->transform($unit);

        $expectedKeys = [
            'id',
            'code',
            'title',
            'group_name',
            'subgroup',
            'links'
        ];

        $this->assertArrayHasOnlyKeys($expectedKeys, $result);
    }
}
