<?php

namespace App\Http\Middleware;

use App\Http\Response\ErrorResponse;
use App\Resolvers\ProvidesUuidValidation;
use App\Resolvers\RequestResolver;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JsonSchema\Validator;
use Symfony\Component\HttpFoundation\Request as RequestFoundation;
use Symfony\Component\HttpFoundation\Response;

class ValidateJsonSchemaMiddleware
{
    use ProvidesUuidValidation, RequestResolver;

    const JSON_EXTENSION = '.json';

    /**
     * @var Validator
     */
    private $validator;
    /**
     * @var ErrorResponse
     */
    private $errorResponse;

    /**
     * ValidateJsonSchemaMiddleware constructor.
     *
     * @param Validator $validator
     * @param ErrorResponse $errorResponse
     */
    public function __construct(Validator $validator, ErrorResponse $errorResponse)
    {
        $this->validator = $validator;
        $this->errorResponse = $errorResponse;
    }

    /**
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $requestMethod = $request->getMethod();
        $jsonPayload = $this->formatAndDecodeRequest($request);

        $validationResult = $this->validateAndGetSchemaError($jsonPayload, $requestMethod);

        if ($validationResult) {
            return $validationResult;
        }

        if ($requestMethod == RequestFoundation::METHOD_PUT) {
            return $this->handleMethodPut($request, $next, $jsonPayload);
        }

        return $next($request);
    }

    private function handleMethodPut($request, Closure $next, $jsonPayload)
    {
        $validateUuidResult = $this->validateAndGetUuidError(
            $this->getUriLastSegment($request),
            $jsonPayload->data->id
        );

        if ($validateUuidResult) {
            return $validateUuidResult;
        }

        return $next($request);
    }

    private function validateAndGetSchemaError($jsonPayload, $requestMethod)
    {
        if (!isset($jsonPayload->data->type)) {
            return $this->errorResponse->respondUnprocessableEntity('Malformed schema');
        }

        if (!$this->isSchemaExist($schemaPath = $this->buildSchemaPath($requestMethod, $jsonPayload->data->type))) {
            return $this->respondSchemaDoesNotExist($jsonPayload->data->type, $requestMethod);
        }

        $this->validator->check($jsonPayload, (object)['$ref' => $schemaPath]);

        if (!$this->validator->isValid()) {
            return $this->errorResponse
                ->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY)
                ->outputToJson([
                    'errors' => $this->collectErrorMessages()
                ]);
        }

        return false;
    }

    /**
     * @param string $requestUuid
     * @param string $jsonPayloadUuid
     *
     * @return bool
     */
    private function validateAndGetUuidError($requestUuid, $jsonPayloadUuid)
    {
        if (!$this->isValidUuid($requestUuid) || !$this->isValidUuid($jsonPayloadUuid)) {
            return $this->errorResponse->respondUnprocessableEntity('Id parameter/attribute is not in uuid format');
        }

        if ($requestUuid != $jsonPayloadUuid) {
            return $this->errorResponse->respondUnprocessableEntity('Id parameter and Id json payload does not match');
        }

        return false;
    }

    /**
     * @param $file
     *
     * @return bool
     */
    private function isSchemaExist($file)
    {
        return file_exists($file);
    }

    /**
     * @param string $url
     * @param string $method
     *
     * @return mixed|JsonResponse
     */
    private function respondSchemaDoesNotExist($url, $method)
    {
        return $this->errorResponse
            ->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->outputToJson([
                'errors' => [
                    'title' => 'Missing Schema',
                    'detail' => sprintf('Schema for %s does not exist.', $url),
                    'method' => $method
                ]
            ]);
    }

    /**
     * @param string $method
     * @param string $schema
     *
     * @return string
     */
    private function buildSchemaPath($method, $schema)
    {
        $pathToSchema = 'file://' . base_path() . '/app/Schemas/';
        $httpMethod = strtolower($method);
        $directory = ucfirst($schema);
        $baseFileName = strtolower($schema);

        return $pathToSchema . $directory . '/' . $baseFileName . '-' . $httpMethod . self::JSON_EXTENSION;
    }

    /**
     * @return array
     */
    private function collectErrorMessages()
    {
        $errorMessages = [];

        foreach ($this->validator->getErrors() as $error) {
            $errorMessages[] = $this->buildNewErrorMessage($error['message'], $error['property']);
        }

        return $errorMessages;
    }

    /**
     * @param string $title
     * @param string $detail
     *
     * @return array
     */
    private function buildNewErrorMessage($title, $detail)
    {
        return [
            'title' => $title,
            'detail' => $detail
        ];
    }

    /**
     * @param Request $request
     *
     * @return object
     */
    private function formatAndDecodeRequest(Request $request)
    {
        $data = json_encode($request->all());

        return json_decode($data);
    }
}
