<?php

namespace App\Providers;

use App\Modules\Assessor\Assessor;
use App\Modules\Industry\Industry;
use App\Modules\Occupation\Occupation;
use App\Modules\Package\Package;
use App\Modules\Qualification\Qualification;
use App\Modules\RTO\RTO;
use App\Modules\Scientist\Scientist;
use App\Modules\Theory\Theory;
use App\Modules\Unit\Unit;
use App\Repositories\Contracts\AssessorRepository;
use App\Repositories\Contracts\IndustryRepository;
use App\Repositories\Contracts\OccupationRepository;
use App\Repositories\Contracts\PackageRepository;
use App\Repositories\Contracts\QualificationRepository;
use App\Repositories\Contracts\RTORepository;
use App\Repositories\Contracts\ScientistRepository;
use App\Repositories\Contracts\TheoryRepository;
use App\Repositories\Contracts\UnitRepository;
use App\Repositories\Contracts\UserRepository;
use App\Repositories\Doctrines\DoctrineAssessorRepository;
use App\Repositories\Doctrines\DoctrineIndustryRepository;
use App\Repositories\Doctrines\DoctrineOccupationRepository;
use App\Repositories\Doctrines\DoctrinePackageRepository;
use App\Repositories\Doctrines\DoctrineQualificationRepository;
use App\Repositories\Doctrines\DoctrineRTORepository;
use App\Repositories\Doctrines\DoctrineScientistRepository;
use App\Repositories\Doctrines\DoctrineTheoryRepository;
use App\Repositories\Doctrines\DoctrineUnitRepository;
use App\Repositories\Doctrines\DoctrineUserRepository;
use App\Users\User;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IndustryRepository::class, function ($app) {
            return new DoctrineIndustryRepository($app['em'], $app['em']->getClassMetaData(Industry::class));
        });

        $this->app->bind(PackageRepository::class, function ($app) {
            return new DoctrinePackageRepository($app['em'], $app['em']->getClassMetaData(Package::class));
        });

        $this->app->bind(OccupationRepository::class, function ($app) {
            return new DoctrineOccupationRepository($app['em'], $app['em']->getClassMetaData(Occupation::class));
        });

        $this->app->bind(UnitRepository::class, function ($app) {
            return new DoctrineUnitRepository($app['em'], $app['em']->getClassMetaData(Unit::class));
        });

        $this->app->bind(UserRepository::class, function ($app) {
            return new DoctrineUserRepository($app['em'], $app['em']->getClassMetaData(User::class));
        });

        $this->app->bind(RTORepository::class, function ($app) {
            return new DoctrineRTORepository($app['em'], $app['em']->getClassMetaData(RTO::class));
        });

        $this->app->bind(AssessorRepository::class, function ($app) {
            return new DoctrineAssessorRepository($app['em'], $app['em']->getClassMetaData(Assessor::class));
        });

        $this->app->bind(ScientistRepository::class, function ($app) {
            return new DoctrineScientistRepository($app['em'], $app['em']->getClassMetaData(Scientist::class));
        });

        $this->app->bind(TheoryRepository::class, function ($app) {
            return new DoctrineTheoryRepository($app['em'], $app['em']->getClassMetaData(Theory::class));
        });

        $this->app->bind(QualificationRepository::class, function ($app) {
            return new DoctrineQualificationRepository($app['em'], $app['em']->getClassMetaData(Qualification::class));
        });
    }
}
