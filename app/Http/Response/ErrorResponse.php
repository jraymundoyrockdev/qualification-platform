<?php

namespace App\Http\Response;

use Symfony\Component\HttpFoundation\Response;

class ErrorResponse extends AbstractApiResponse
{
    /**
     * @param string $message
     *
     * @return Response|static
     */
    public function respondErrorNotFound($message = '')
    {
        return $this->setStatusCode(Response::HTTP_NOT_FOUND)->respondWithError($message);
    }

    /**
     * @param string $message
     *
     * @return Response|static
     */
    public function respondBadRequest($message = '')
    {
        return $this->setStatusCode(Response::HTTP_BAD_REQUEST)->respondWithError($message);
    }

    /**
     * @param string $message
     *
     * @return Response|static
     */
    public function respondUnprocessableEntity($message = '')
    {
        return $this->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY)->respondWithError($message);
    }

    /**
     * @param string $message
     *
     * @return Response|static
     */
    public function respondMissingJWT($message = 'JWT not found.')
    {
        return $this->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($message);
    }

    /**
     * @param string $message
     *
     * @return Response|static
     */
    public function respondInvalidJWT($message = 'Invalid JWT.')
    {
        return $this->setStatusCode(Response::HTTP_BAD_REQUEST)->respondWithError($message);
    }

    /**
     * @param string $message
     *
     * @return Response|static
     */
    public function respondExpiredJWT($message = 'JWT already expired.')
    {
        return $this->setStatusCode(Response::HTTP_UNAUTHORIZED)->respondWithError($message);
    }

    /**
     * @param $messageDetail
     *
     * @return Response|static
     */
    private function respondWithError($messageDetail)
    {
        $message = $this->buildErrorMessage(
            Response::$statusTexts[$this->getStatusCode()],
            $messageDetail
        );

        return $this->outputToJson(['errors' => $message]);
    }

    /**
     * @param string $title
     * @param string $detail
     *
     * @return array
     */
    private function buildErrorMessage($title, $detail)
    {
        return [
            'title' => $title,
            'detail' => $detail
        ];
    }
}
