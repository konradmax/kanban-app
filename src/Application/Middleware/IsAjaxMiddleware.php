<?php
declare(strict_types=1);

namespace App\Application\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class IsAjaxMiddleware implements Middleware
{

    const ISAJAX = 'isAjax';

    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        $isAjax =  strtolower($request->getHeaderLine('X-Requested-With')) === 'xmlhttprequest';

        $request = $request->withAttribute(self::ISAJAX, $isAjax);

        return $handler->handle($request);
    }
}
