<?php

use App\Modules\Course\Course;
use Illuminate\Support\Facades\Artisan;
use Ramsey\Uuid\Uuid;

class CourseControllerTest extends BaseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->withoutMiddleware();

        Artisan::call('doctrine:schema:create');
    }

    /** @test */
    public function it_returns_an_invalid_response_if_course_does_not_exist()
    {
        $unknownId = Uuid::uuid4();

        $this->get('api/course/' . $unknownId);

        $result = $this->getContent();

        $this->assertEquals('Bad Request', $result->errors->title);
        $this->assertResponseStatus(400);
    }

    /** @test */
    public function it_returns_a_valid_api_response_if_course_is_found()
    {
        $uuid = Uuid::uuid4();

        entity(Course::class)->create(['id' => $uuid]);

        $this->get('api/course/' . $uuid);

        $result = $this->getContent();

        $this->assertArrayHasOnlyKeys([
            'code',
            'name',
            'level',
            'training_package',
            'selling_price',
            'initial_price',
            'best_market_price',
            'user_comments',
            'target_market',
            'times_completed',
            'active',
            'status',
            'online',
            'trades',
            'faculty',
            'is_mapped'
        ],
            $this->toArray($result->data->attributes)
        );

        $this->assertEquals($uuid, $result->data->id);
        $this->assertResponseOk();
    }

    /** @test */
    public function it_returns_a_valid_response_and_empty_result_when_no_course_exist()
    {
        $this->get('api/course');

        $result = $this->getContent();

        $this->assertEmpty($result->data);
        $this->assertResponseOk();
    }

    /** @test */
    public function it_returns_a_valid_response_on_existing_course_list()
    {
        entity(Course::class, 3)->create();

        $this->get('api/course');

        $result = $this->getContent();

        $this->assertCount(3, $result->data);
        $this->assertResponseOk();
    }
}