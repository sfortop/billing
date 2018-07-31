<?php
/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Encryption\Middleware;

use Encryption\DecryptionException;
use Infrastructure\Response\JsonExceptionResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Stream;

class DecryptMiddleware implements MiddlewareInterface
{

    /**
     * Process an incoming server request and return a response, optionally delegating
     * response creation to a handler.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request->getAttribute('encrypted')) {
            $body = $request->getBody()->getContents();
            if (false !== $data = base64_decode($body)) {
                $stream = new Stream('php://memory', 'a+');
                $stream->write($data);
                $request = $request->withBody($stream);
            } else {
                return new JsonExceptionResponse(new DecryptionException());
            }
        }
        return $handler->handle($request);
    }
}