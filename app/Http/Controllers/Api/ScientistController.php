<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Response\ApiResponse;
use App\Modules\Scientist\Services\CreateScientistService;
use App\Modules\Scientist\Services\UpdateScientistService;
use App\Repositories\Contracts\ScientistRepository;
use Illuminate\Http\Request;
use JsonSchema\Validator;

class ScientistController extends ApiController
{
    /**
     * @var CreateScientistService
     */
    protected $createScientistService;

    /**
     * @var ScientistRepository
     */
    protected $scientist;

    /**
     * @var response
     */
    private $response;
    /**
     * @var UpdateScientistService
     */
    private $updateScientistService;

    /**
     * ScientistController constructor.
     *
     * @param CreateScientistService $createScientistService
     * @param UpdateScientistService $updateScientistService
     * @param ScientistRepository $scientist
     * @param ApiResponse $response
     */
    public function __construct(
        CreateScientistService $createScientistService,
        UpdateScientistService $updateScientistService,
        ScientistRepository $scientist,
        ApiResponse $response
    ) {
    
        $this->createScientistService = $createScientistService;
        $this->scientist = $scientist;
        $this->response = $response;
        $this->updateScientistService = $updateScientistService;
    }

    public function show($id)
    {
        $scientist = $this->scientist->findOneBy(['id' => $id]);

        if (!$scientist) {
            return $this->response->error()->respondBadRequest();
        }

        return $this->response->fractal()->item($scientist);
    }

    public function all()
    {
        $scientist = $this->scientist->findAll();

        if (!$scientist) {
            return $this->response->fractal()->nullResource();
        }

        return $this->response->fractal()->collection($scientist);
    }

    public function create(Request $request)
    {

        $test = json_encode($request->all());


        $data = json_decode($test);

        // $schema =  'file://'.base_path(). '/app/Schemas/Scientist/scientist-post.json';

        /*        $validator = new Validator();
                $validator->check(
                    $data,
                    (object)['$ref' => 'file://' . base_path(). '/app/Schemas/Scientist/scientist-post.json']
                );

                print_r($validator->getErrors());

                die;*/
        // die;

        $scientist = $this->createScientistService->insert($request->all());

        return $this->response->fractal()->setStatusCode(201)->item($scientist);
    }

    public function update(Request $request, $id)
    {
        $scientist = $this->scientist->findOneBy(['id' => $id]);

        if (!$scientist) {
            return $this->response->error()->respondBadRequest('Scientist does not exist.');
        }

        $scientist = $this->updateScientistService->update($scientist, $request->all());

        return $this->response->fractal()->item($scientist);
    }
}
