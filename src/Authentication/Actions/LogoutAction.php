<?php
declare(strict_types=1);

namespace App\Authentication\Actions;


use App\Application\Actions\Action;
use App\Authentication\Service\AuthService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Views\PhpRenderer;

class LogoutAction extends Action
{
    /**
     * @var AuthService
     */
    protected AuthService $authService;

    /**
     * @var PhpRenderer
     */
    protected PhpRenderer $phpRenderer;

    /**
     * @param AuthService     $authService
     * @param LoggerInterface $logger
     * @param PhpRenderer     $phpRenderer
     */
    public function __construct(
        AuthService $authService,
        LoggerInterface $logger,
        PhpRenderer $phpRenderer
    ) {
        parent::__construct($logger);

        $this->authService = $authService;
        $this->phpRenderer = $phpRenderer;
    }

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $messages=null;
        $isLoggedIn = $this->request->getAttribute(AuthService::ATTR_ISLOGGEDIN);
        $header = $this->phpRenderer->fetch(
            "common/_header.php",
            ['is_logged_in'=>$isLoggedIn]
        );

        if($isLoggedIn) {
            // logout user
            $this->authService->logout();

            $messages['info'][]="User logged out.";

            $messagesTemplate = $this->phpRenderer->fetch("common/messages.php", ['messages'=>$messages]);
            $forms['form_login'] = $this->phpRenderer->fetch(
                "forms/form-login.php",
                [
                    'messages_template'=>$messagesTemplate
                ]
            );
            array_pop($messages['info']);
        } else {

            $messages['warning'][] = "You are not logged in.";
            $messagesTemplate = $this->phpRenderer->fetch("common/messages.php", ['messages'=>$messages]);

            $this->response->withStatus(403);
            return $this->phpRenderer->render(
                $this->response,
                "common/403.php",
                [
                    'is_logged_in'=>$isLoggedIn,
                    'header'=>$header,
                    'messages'=>$messages,
                    'messages_template'=>$messagesTemplate
                ]
            );
        }

        $forms['form_login'] = $this->phpRenderer->fetch(
            "forms/form-login.php",
            [
                'messages_template'=>$messagesTemplate
            ]
        );

        $header = $this->phpRenderer->fetch(
            "common/_header.php",
            ['is_logged_in'=>false]
        );

        return $this->phpRenderer->render(
            $this->response,
            "common/_blank.php",
            [
                'is_logged_in'=>$isLoggedIn,
                'header'=>$header,
                'messages'=>$messages,
                'messages_template'=>$messagesTemplate
            ]
        );
    }
}
