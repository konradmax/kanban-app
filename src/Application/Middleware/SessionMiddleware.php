<?php
declare(strict_types=1);

namespace App\Application\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use App\Authentication\Service\AuthService;

class SessionMiddleware implements Middleware
{

    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        session_start();

        $request = $request->withAttribute(AuthService::ATTR_ISLOGGEDIN, $this->authService->isLoggedIn());
        $request = $request->withAttribute(AuthService::ATTR_ISADMIN, $this->authService->isAdmin());

        return $handler->handle($request);
    }
}
