<?php

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->group(['namespace' => 'App\Http\Controllers\Api', 'prefix' => 'api'], function () use ($app) {
    $app->post('api-token-auth', ['uses' => 'AuthenticationController@authenticate']);
});

$app->group(['namespace' => 'App\Http\Controllers\Api', 'prefix' => 'api', 'middleware' => 'jwt-refresh'], function () use ($app) {
    $app->post('api-token-refresh', ['uses' => 'AuthenticationController@refreshToken']);
});


$app->group([
    'namespace' => 'App\Http\Controllers\Api',
    'prefix' => 'api',
  //  'middleware' => 'jwt-auth'
], function () use ($app) {

    $app->get('industry/{id}', ['uses' => 'IndustryController@show']);
    $app->get('industry', ['uses' => 'IndustryController@all']);

    $app->get('package/{id}', ['uses' => 'PackageController@show']);
    $app->get('package', ['uses' => 'PackageController@all']);

    $app->get('occupation/{id}', ['uses' => 'OccupationController@show']);
    $app->get('occupation', ['uses' => 'OccupationController@all']);

    $app->get('scientist/{id}', ['uses' => 'ScientistController@show']);
    $app->get('scientist', ['uses' => 'ScientistController@all']);

    $app->get('rto/{id}', ['uses' => 'RTOController@show']);
    $app->get('rto', ['uses' => 'RTOController@all']);

    $app->get('assessor/{id}', ['uses' => 'AssessorController@show']);
    $app->get('assessor', ['uses' => 'AssessorController@all']);
    $app->get('assessor/{id}/course', ['uses' => 'AssessorController@findAllCourse']);

    $app->get('course/{id}', ['uses' => 'CourseController@show']);
    $app->get('course', ['uses' => 'CourseController@all']);

    $app->get('unit/{id}', ['uses' => 'UnitController@show']);
    $app->get('unit', ['uses' => 'UnitController@all']);

    $app->get('qualification/{id}', ['uses' => 'QualificationController@show']);
    $app->get('qualification', ['uses' => 'QualificationController@all']);

});

$app->group([
    'namespace' => 'App\Http\Controllers\Api',
    'prefix' => 'api',
    'middleware' => ['jwt-auth', 'validate-json-schema']
], function () use ($app) {
    $app->post('scientist', ['uses' => 'ScientistController@create']);
    $app->put('scientist/{id}', ['uses' => 'ScientistController@update']);

    $app->post('assessor', ['uses' => 'AssessorController@create']);
    $app->put('assessor/{id}', ['uses' => 'AssessorController@update']);

    $app->post('qualification-add-from-tga', ['uses' => 'QualificationController@addFromTga']);
});
