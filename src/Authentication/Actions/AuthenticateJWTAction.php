<?php
declare(strict_types=1);

namespace App\Authentication\Actions;

use App\Application\Actions\Action;
use App\Authentication\Service\AuthService;
use App\Users\Model\UserModel;
use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Views\PhpRenderer;

class AuthenticateJWTAction extends Action
{
    protected AuthService $authService;

    protected PhpRenderer $phpRenderer;

    protected Response $response;

    protected UserModel $userModel;

    private string $key;

    public function __construct(LoggerInterface $logger, AuthService $authService, PhpRenderer $phpRenderer, UserModel $userModel)
    {
        parent::__construct($logger);

        $this->key = $_SERVER['JWT_SECRETKEY'];

        $this->authService = $authService;
        $this->phpRenderer = $phpRenderer;
        $this->userModel = $userModel;
    }




    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {

        $data = $this->request->getParsedBody();
        $isAuthValid = $this->authService->authenticate($data['username'], $data['password']);

        $token = [
            "iss" => "utopian",
            "iat" => time(),
            "exp" => time() + $_SERVER['JWT_EXP'],
            "data" => [
                "user_id" => $isAuthValid['id']
            ]
        ];

        $jwt = JWT::encode($token, $this->key, $_SERVER['JWT_ALG']);

        return $this->respondWithData(
            [
            'success' => true,
            'message' => "Login Successfull",
            'jwt' => $jwt
            ]
        );

    }
}
