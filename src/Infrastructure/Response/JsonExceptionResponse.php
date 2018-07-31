<?php
/**
 * kyc
 *
 * @author Serhii Borodai <clarifying@gmail.com>
 */

namespace Infrastructure\Response;


use Zend\Diactoros\Response\JsonResponse;

class JsonExceptionResponse extends JsonResponse
{

    public function __construct(\Throwable $exception, int $status = 200, array $headers = [], int $encodingOptions = self::DEFAULT_JSON_FLAGS)
    {
        parent::__construct($this->formatException($exception), $status, $headers, $encodingOptions);
    }


    protected function formatException(\Throwable $exception)
    {
        $message = $exception->getMessage();
        if (!$message) {
            $message = (new \ReflectionObject($exception))->getShortName();
        }

        return [
            'error' => true,
            'code' => $exception->getCode(),
            'message' => $message
        ];
    }

}