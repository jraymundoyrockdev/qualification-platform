<?php

use App\Http\Controllers\Api\Transformers\RTOTransformer;
use App\Modules\RTO\RTO;
use Ramsey\Uuid\Uuid;

class RTOTransformerTest extends BaseTestCase
{
    /** @test */
    public function it_transforms_rto_data_into_an_api_payload()
    {
        $rto = factory(RTO::class)->make(['id' => Uuid::uuid4()]);

        $transformer = new RTOTransformer();

        $result = $transformer->transform($rto);

        $expectedKeys = [
            'id',
            'links',
            'code',
            'name',
            'email',
            'signed',
            'rating_price',
            'rating_speed',
            'rating_efficiency',
            'rating_professionalism',
            'user_comments',
            'hidden',
            'phone',
            'website',
            'contact',
            'form'
        ];

        $this->assertArrayHasOnlyKeys($expectedKeys, $result);
    }
}
