<?php
declare(strict_types=1);

namespace App\Authentication\Actions;

use App\Application\Actions\Action;
use App\Authentication\Service\AuthService;
use App\Users\Model\UserModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Views\PhpRenderer;

class RegisterAction extends Action
{
    protected AuthService $authService;
    protected PhpRenderer $phpRenderer;
    protected UserModel $userModel;

    const FORMNAME_CREATE = "form_register";

    public function __construct(LoggerInterface $logger, UserModel $userModel, PhpRenderer $phpRenderer, AuthService $authService)
    {
        parent::__construct($logger);

        $this->authService = $authService;
        $this->phpRenderer = $phpRenderer;
        $this->userModel = $userModel;
    }

    protected function action(): Response
    {
        $messages = null;
        $isAdminUser = $this->request->getAttribute(AuthService::ATTR_ISADMIN);
        $isLoggedIn = $this->request->getAttribute(AuthService::ATTR_ISLOGGEDIN);
        $header = $this->phpRenderer->fetch(
            "common/_header.php",
            ['is_logged_in'=>$isLoggedIn]
        );

        if($isLoggedIn) {
            return $this->phpRenderer->render(
                $this->response,
                "common/403.php",
                [
                    'is_logged_in'=>$isLoggedIn,
                    'header'=>$header,
                    'messages'=>$messages,
                //                    'messages_template'=>$messagesTemplate
                ]
            );
        }
        //        if($isAdminUser || $isLoggedIn) {
        //            $this->authService->forbidden();
        //        }

        return $this->phpRenderer->render(
            $this->response,
            "forms/form-register.php",
            [
                'header'=>$header,
                'messages'=>$messages,
            ]
        );
    }
}
