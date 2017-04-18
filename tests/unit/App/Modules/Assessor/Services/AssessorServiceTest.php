<?php

use App\Modules\Assessor\Assessor;
use App\Modules\Assessor\Services\AssessorService;
use App\Repositories\Contracts\AssessorRepository;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Artisan;
use Ramsey\Uuid\Uuid;

class AssessorServiceTest extends BaseTestCase
{
    protected $service;
    protected $repository;

    public function setUp()
    {
        parent::setUp();

        Artisan::call('doctrine:schema:create');

        $this->service = $this->app->make(AssessorService::class);
        $this->repository = $this->app->make(AssessorRepository::class);
    }

    /** @test */
    public function it_returns_an_assessor_on_successful_insert()
    {
        $faker = Faker::create();

        $name = $faker->name;
        $email = $faker->email;
        $mobile = $faker->email;
        $notes = $faker->sentence;
        $type = $faker->randomElement(['full_time_gq', 'part_time_gq', 'rto']);

        $payload = $this->createAnInsertPayload($name, $email, $mobile, $notes, $type);

        $result = $this->service->insert($payload);

        $this->assertInstanceOf(Assessor::class, $result);
        $this->assertEquals($name, $result->getName());
        $this->assertEquals($email, $result->getEmail());
        $this->assertEquals($mobile, $result->getMobile());
        $this->assertEquals($notes, $result->getNotes());
        $this->assertEquals($type, $result->getType());

        $databaseResult = $this->repository->findOneBy(['id' => $result->getId()]);

        $this->assertEquals($name, $databaseResult->getName());
        $this->assertEquals($email, $databaseResult->getEmail());
        $this->assertEquals($mobile, $databaseResult->getMobile());
        $this->assertEquals($notes, $databaseResult->getNotes());
        $this->assertEquals($type, $databaseResult->getType());
    }

    /** @test */
    public function it_returns_an_assessor_on_successful_update()
    {
        $assessor = entity(Assessor::class)->create(['id' => Uuid::uuid4()]);

        $faker = Faker::create();

        $name = $faker->name;
        $email = $faker->email;
        $mobile = $faker->email;
        $notes = $faker->sentence;
        $type = $faker->randomElement(['full_time_gq', 'part_time_gq', 'rto']);

        $payload = $this->createAnUpdatePayload($assessor->getId(), $name, $email, $mobile, $notes, $type);

        $result = $this->service->update($assessor, $payload);

        $this->assertInstanceOf(Assessor::class, $result);
        $this->assertEquals($name, $result->getName());
        $this->assertEquals($email, $result->getEmail());
        $this->assertEquals($mobile, $result->getMobile());
        $this->assertEquals($notes, $result->getNotes());
        $this->assertEquals($type, $result->getType());

        $databaseResult = $this->repository->findOneBy(['id' => $result->getId()]);

        $this->assertEquals($name, $databaseResult->getName());
        $this->assertEquals($email, $databaseResult->getEmail());
        $this->assertEquals($mobile, $databaseResult->getMobile());
        $this->assertEquals($notes, $databaseResult->getNotes());
        $this->assertEquals($type, $databaseResult->getType());
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $mobile
     * @param string $notes
     * @param string $type
     *
     * @return array
     */
    private function createAnInsertPayload($name, $email, $mobile, $notes, $type)
    {
        return [
            'data' => [
                'type' => 'assessor',
                'attributes' => [
                    'name' => $name,
                    'email' => $email,
                    'mobile' => $mobile,
                    'notes' => $notes,
                    'type' => $type,
                ]
            ]
        ];
    }

    /**
     * @param string $id
     * @param string $name
     * @param string $email
     * @param string $mobile
     * @param string $notes
     * @param string $type
     *
     * @return array
     */
    private function createAnUpdatePayload($id, $name, $email, $mobile, $notes, $type)
    {
        return [
            'data' => [
                'id' => $id,
                'type' => 'assessor',
                'attributes' => [
                    'name' => $name,
                    'email' => $email,
                    'mobile' => $mobile,
                    'notes' => $notes,
                    'type' => $type,
                ]
            ]
        ];
    }
}
