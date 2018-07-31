<?php
/**
 * billing
 *
 * @author Serhii Borodai <clarifying@gmail.com>
 */

namespace Infrastructure\Middleware;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

class RequestResponseLog implements MiddlewareInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {

        $this->logger = $logger;
    }

    /**
     * Process an incoming server request and return a response, optionally delegating
     * response creation to a handler.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
//        $this->logger->debug(
//            sprintf('%s %s %s H: %s C: %s Q: %s A: %s',
//                $request->getMethod(),
//                $request->getUri(),
//                $request->getBody()->getContents(),
//                json_encode($request->getHeaders()),
//                json_encode($request->getCookieParams()),
//                json_encode($request->getQueryParams()),
//                json_encode($request->getAttributes())
//            )
//        );

        $response =  $handler->handle($request);

//        $this->logger->debug(sprintf('[%s] %s', $response->getStatusCode(), $response->getBody()));

        return $response;
    }
}