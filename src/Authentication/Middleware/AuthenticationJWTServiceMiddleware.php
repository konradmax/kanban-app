<?php
declare(strict_types=1);

namespace App\Authentication\Middleware;

use App\Authentication\Service\AuthService;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class AuthenticationJWTServiceMiddleware implements Middleware
{
    /**
     * @var AuthService
     */
    public AuthService $authService;

    /**
     * @var string|mixed
     */
    private string $key;

    /**
     * @var string|mixed
     */
    private string $alg;

    /**
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
        $this->key = $_SERVER['JWT_SECRETKEY'];
        $this->alg = $_SERVER['JWT_ALG'];
    }

    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        // check ig jwt header exists
        $jwtAuthHeader = $request->getHeader($_SERVER['JWT_AUTH_HEADER']);
        if(empty($jwtAuthHeader)) {
            return $handler->handle($request);
        }

        $token = substr(reset($jwtAuthHeader), strpos(reset($jwtAuthHeader), "$") + 1);

        if(is_null($token)) {
            return $handler->handle($request);
        }

        $jwt = JWT::decode($token, new Key($this->key, $this->alg));

        if(property_exists($jwt, 'data')&&!empty($jwt->data)) {
            $request = $request->withAttribute(AuthService::ATTR_ISLOGGEDIN, true);
            $request = $request->withAttribute(AuthService::ATTR_USERID, $jwt->data->user_id);
        }

        return $handler->handle($request);
    }
}
