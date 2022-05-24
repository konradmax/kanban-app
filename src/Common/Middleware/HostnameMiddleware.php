<?php
declare(strict_types=1);

namespace App\Common\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Laminas\Uri\UriFactory as UriFactory;

class HostnameMiddleware implements Middleware
{

    public const ATTR_NAME = "hostname";

    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        $request = $request->withAttribute(self::ATTR_NAME, $request->getUri()->getHost());

        return $handler->handle($request);
    }
}
