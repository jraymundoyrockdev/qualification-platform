<?php

use App\Modules\Qualification\Qualification;
use App\Modules\Qualification\QualificationBuilder;
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
        $packagingRules = $faker->sentence;
        $currencyStatus = $faker->randomElement(['no', 'yes']);
        $status = $faker->randomElement(['active', 'inactive']);
        $aqfLevel = $faker->word;
        $onlineLearningStatus = $faker->randomElement(['active', 'inactive']);
        $rplStatus = $faker->randomElement(['active', 'inactive']);
        $expirationDate = $faker->date;
        $createdBy = $faker->username;

        $payload = $this->createAnInsertPayload(
            $code,
            $title,
            $description,
            $packagingRules,
            $currencyStatus,
            $status,
            $aqfLevel,
            $onlineLearningStatus,
            $rplStatus,
            $expirationDate,
            $createdBy
        );

        $result = $this->service->insert($payload);

        $this->assertInstanceOf(Qualification::class, $result);
        $this->assertEquals($code, $result->getCode());
        $this->assertEquals($title, $result->getTitle());
        $this->assertEquals($description, $result->getDescription());
        $this->assertEquals($packagingRules, $result->getPackagingRules());
        $this->assertEquals($currencyStatus, $result->getCurrencyStatus());
        $this->assertEquals($status, $result->getStatus());
        $this->assertEquals($aqfLevel, $result->getAqfLevel());
        $this->assertEquals($onlineLearningStatus, $result->getOnlineLearningStatus());
        $this->assertEquals($rplStatus, $result->getRplStatus());
        $this->assertEquals($expirationDate, $result->getExpirationDate());
        $this->assertEquals($createdBy, $result->getCreatedBy());

        $databaseResult = $this->repository->findOneBy(['id' => $result->getId()]);

        $this->assertEquals($code, $databaseResult->getCode());
        $this->assertEquals($title, $databaseResult->getTitle());
        $this->assertEquals($description, $databaseResult->getDescription());
        $this->assertEquals($packagingRules, $databaseResult->getPackagingRules());
        $this->assertEquals($currencyStatus, $databaseResult->getCurrencyStatus());
    }

    /** @test */
    public function it_returns_an_assessor_on_successful_update()
    {
        $qualification = entity(Qualification::class)->create(['id' => Uuid::uuid4()]);

        $faker = Faker::create();

        $code = $faker->word;
        $title = $faker->word;
        $description = $faker->sentence;
        $packagingRules = $faker->sentence;
        $currencyStatus = $faker->randomElement(['no', 'yes']);

        $payload = $this->createAnUpdatePayload($qualification->getId(), $code, $title, $description, $packagingRules, $currencyStatus);

        $result = $this->service->update($qualification, $payload);

        $this->assertInstanceOf(Qualification::class, $result);
        $this->assertEquals($code, $result->getCode());
        $this->assertEquals($title, $result->getTitle());
        $this->assertEquals($description, $result->getDescription());
        $this->assertEquals($packagingRules, $result->getSubjectInformation());
        $this->assertEquals($currencyStatus, $result->getCurrencyStatus());

        $databaseResult = $this->repository->findOneBy(['id' => $result->getId()]);

        $this->assertEquals($code, $databaseResult->getCode());
        $this->assertEquals($title, $databaseResult->getTitle());
        $this->assertEquals($description, $databaseResult->getDescription());
        $this->assertEquals($packagingRules, $databaseResult->getSubjectInformation());
        $this->assertEquals($currencyStatus, $databaseResult->getCurrencyStatus());
    }

    /**
     * @param string $code
     * @param string $title
     * @param string $description
     * @param string $packagingRules
     * @param string $currencyStatus
     * @param string $status
     * @param string $aqfLevel
     * @param string $onlineLearningStatus
     * @param string $rplStatus
     * @param string $expirationDate
     * @param string $createdBy
     * @return array
     */
    private function createAnInsertPayload($code, $title, $description, $packagingRules, $currencyStatus, $status, $aqfLevel, $onlineLearningStatus, $rplStatus, $expirationDate, $createdBy)
    {
        return [
            'data' => [
                'type' => 'qualification',
                'attributes' => [
                    'code' => $code,
                    'title' => $title,
                    'description' => $description,
                    'packaging_rules' => $packagingRules,
                    'currency_status' => $currencyStatus,
                    'status' => $status,
                    'aqf_level' => $aqfLevel,
                    'online_learning_status' => $onlineLearningStatus,
                    'rpl_status' => $rplStatus,
                    'expiration_date' => $expirationDate,
                    'created_by' => $createdBy
                ]
            ]
        ];
    }

    /**
     * @param uuid $id
     * @param string $code
     * @param string $title
     * @param string $description
     * @param string $packagingRules
     * @param string $currencyStatus
     *
     * @return array
     */
    private function createAnUpdatePayload($id, $code, $title, $description, $packagingRules, $currencyStatus)
    {
        return [
            'data' => [
                'id' => $id,
                'type' => 'qualification',
                'attributes' => [
                    'code' => $code,
                    'title' => $title,
                    'description' => $description,
                    'packaging_rules' => $packagingRules,
                    'currency_status' => $currencyStatus,
                ]
            ]
        ];
    }
}
