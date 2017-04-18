<?php

use App\Resolvers\RequestResolver;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Faker\Factory as Faker;

class RequestResolverTest extends BaseTestCase
{
    use RequestResolver;

    protected $request;

    public function setUp()
    {
        parent::setUp();

        $this->request = $this->app->make(Request::class);
    }

    /** @test */
    public function it_returns_the_last_uri_segment()
    {
        $uuid = Uuid::uuid4();

        $this->request->server->set('REQUEST_URI', 'www.test.com/test/' . $uuid);

        $result = $this->getUriLastSegment($this->request);

        $this->assertEquals($uuid, $result);
    }

    /** @test */
    public function it_returns_the_root()
    {
        $this->request->server->set('SERVER_PORT', '8080');

        $result = $this->getBaseApiRoot();

        $this->assertEquals('http://:8080/api', $result);
    }

    /** @test */
    public function it_filters_the_attributes_key_on_the_payload()
    {
        $payload = ['data' => ['test' => 'test', 'attributes' => ['attributeField']]];

        $result = $this->filterRequestAttributes($payload);

        $this->assertEquals('attributeField', $result[0]);
    }

    /** @test */
    public function it_filters_the_relationship_key_on_the_payload()
    {
        $faker = Faker::create();
        $relationship = $faker->word;

        $payload = ['data' => ['relationships' => [$relationship => ['data' => 'sampleRelationshipData']]]];

        $result = $this->filterRequestRelationships($payload, $relationship);

        $this->assertEquals('sampleRelationshipData', $result);
    }
}