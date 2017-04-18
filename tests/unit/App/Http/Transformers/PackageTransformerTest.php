<?php

use App\Http\Controllers\Api\Transformers\PackageTransformer;
use App\Modules\Package\Package;
use Ramsey\Uuid\Uuid;

class PackageTransformerTest extends BaseTestCase
{
    /** @test */
    public function it_transform_package_into_an_api_payload()
    {
        $package = entity(Package::class)->make(['id' => Uuid::uuid4()]);

        $transformer = new PackageTransformer();

        $result = $transformer->transform($package);

        $expectedKeys = [
            'id',
            'code',
            'title',
            'status',
            'links'
        ];

        $this->assertArrayHasOnlyKeys($expectedKeys, $result);
    }
}
