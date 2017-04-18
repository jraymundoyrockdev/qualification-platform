<?php

use App\Resolvers\ProvidesUuidValidation;

class ProvidesUuidValidationTest extends BaseTestCase
{
    use ProvidesUuidValidation;

    /** @test */
    public function it_returns_false_if_uuid_is_invalid()
    {
        $sampleUuid = '879ac89a-5021-41f8-a860-invalidUuid';

        $result = $this->isValidUuid($sampleUuid);

        $this->assertFalse($result);
    }

    /** @test */
    public function it_returns_true_if_uuid_is_valid()
    {
        $sampleUuid = '879ac89a-5021-41f8-a860-0bb5b85d8fa5';

        $result = $this->isValidUuid($sampleUuid);

        $this->assertTrue($result);
    }
}
