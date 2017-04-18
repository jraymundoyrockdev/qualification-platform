<?php

use App\Modules\Qualification\Qualification;
use App\Modules\Qualification\Services\QualificationService;
use App\Repositories\Contracts\QualificationRepository;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Artisan;
use Ramsey\Uuid\Uuid;
use App\Exceptions\PageNotFoundException;

class QualificationServiceTest extends BaseTestCase
{
    protected $service;
    protected $repository;

    public function setUp()
    {
        parent::setUp();

        Artisan::call('doctrine:schema:create');

        $this->service = $this->app->make(QualificationService::class);
        $this->repository = $this->app->make(QualificationRepository::class);
    }

    /** @test */
    public function it_returns_a_qualification_on_successful_insert()
    {
        $faker = Faker::create();

        $code = $faker->word;
        $title = $faker->word;
        $description = $faker->sentence;
        $subjectInformation = $faker->sentence;
        $isSuperseded = $faker->randomElement(['no', 'yes']);

        $payload = $this->createAnInsertPayload($code, $title, $description, $subjectInformation, $isSuperseded);

        $result = $this->service->insert($payload);

        $this->assertInstanceOf(Qualification::class, $result);
        $this->assertEquals($code, $result->getCode());
        $this->assertEquals($title, $result->getTitle());
        $this->assertEquals($description, $result->getDescription());
        $this->assertEquals($subjectInformation, $result->getSubjectInformation());
        $this->assertEquals($isSuperseded, $result->getIsSuperseded());

        $databaseResult = $this->repository->findOneBy(['id' => $result->getId()]);

        $this->assertEquals($code, $databaseResult->getCode());
        $this->assertEquals($title, $databaseResult->getTitle());
        $this->assertEquals($description, $databaseResult->getDescription());
        $this->assertEquals($subjectInformation, $databaseResult->getSubjectInformation());
        $this->assertEquals($isSuperseded, $databaseResult->getIsSuperseded());
    }

    /** @test */
    public function it_returns_an_assessor_on_successful_update()
    {
        $qualification = entity(Qualification::class)->create(['id' => Uuid::uuid4()]);

        $faker = Faker::create();

        $code = $faker->word;
        $title = $faker->word;
        $description = $faker->sentence;
        $subjectInformation = $faker->sentence;
        $isSuperseded = $faker->randomElement(['no', 'yes']);

        $payload = $this->createAnUpdatePayload($qualification->getId(), $code, $title, $description, $subjectInformation, $isSuperseded);

        $result = $this->service->update($qualification, $payload);

        $this->assertInstanceOf(Qualification::class, $result);
        $this->assertEquals($code, $result->getCode());
        $this->assertEquals($title, $result->getTitle());
        $this->assertEquals($description, $result->getDescription());
        $this->assertEquals($subjectInformation, $result->getSubjectInformation());
        $this->assertEquals($isSuperseded, $result->getIsSuperseded());

        $databaseResult = $this->repository->findOneBy(['id' => $result->getId()]);

        $this->assertEquals($code, $databaseResult->getCode());
        $this->assertEquals($title, $databaseResult->getTitle());
        $this->assertEquals($description, $databaseResult->getDescription());
        $this->assertEquals($subjectInformation, $databaseResult->getSubjectInformation());
        $this->assertEquals($isSuperseded, $databaseResult->getIsSuperseded());
    }

    /**
     * @param string $code
     * @param string $title
     * @param string $description
     * @param string $subjectInformation
     * @param string $isSuperseded
     *
     * @return array
     */
    private function createAnInsertPayload($code, $title, $description, $subjectInformation, $isSuperseded)
    {
        return [
            'data' => [
                'type' => 'qualification',
                'attributes' => [
                    'code' => $code,
                    'title' => $title,
                    'description' => $description,
                    'subject_information' => $subjectInformation,
                    'is_superseded' => $isSuperseded,
                ]
            ]
        ];
    }

    /**
     * @param uuid $id
     * @param string $code
     * @param string $title
     * @param string $description
     * @param string $subjectInformation
     * @param string $isSuperseded
     *
     * @return array
     */
    private function createAnUpdatePayload($id, $code, $title, $description, $subjectInformation, $isSuperseded)
    {
        return [
            'data' => [
                'id' => $id,
                'type' => 'qualification',
                'attributes' => [
                    'code' => $code,
                    'title' => $title,
                    'description' => $description,
                    'subject_information' => $subjectInformation,
                    'is_superseded' => $isSuperseded,
                ]
            ]
        ];
    }
}
