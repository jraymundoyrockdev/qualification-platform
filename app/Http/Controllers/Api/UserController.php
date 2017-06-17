<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Response\ApiResponse;
use App\Http\Response\ErrorResponse;
use App\Modules\User\Services\UserService;
use Illuminate\Http\Request;
use App\Exceptions\UsernameNotAvailableException;

class UserController extends ApiController
{
    const USERNAME_NOT_AVAILABLE = 'USERNAME_NOT_AVAILABLE';

    /**
     * @var ApiResponse
     */
    private $response;
    /**
     * @var User
     */
    private $user;

    /**
     * userController constructor.
     *
     * @param UserService $user
     * @param ApiResponse $response
     */
    public function __construct(UserService $user, ApiResponse $response)
    {
        $this->user = $user;
        $this->response = $response;
    }

    /**
     * @param string $id
     *
     * @return \Symfony\Component\HttpFoundation\Response | ErrorResponse
     */
    public function show($id)
    {
        $user = $this->user->findOneById($id);

        if (!$user) {
            return $this->response->error()->respondBadRequest();
        }

        return $this->response->fractal()->item($user);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function all()
    {
        $user = $this->user->findAll();

        if (!$user) {
            return $this->response->fractal()->nullResource();
        }

        return $this->response->fractal()->collection($user);
    }

    public function create(Request $request)
    {
      try {
          $user = $this->user->insert($request->all());
      } catch (UsernameNotAvailableException $exception) {
          return $this->response->error()->respondUnprocessableEntity(self::USERNAME_NOT_AVAILABLE);
      }
      return $this->response->fractal()->item($user);
    }
}
