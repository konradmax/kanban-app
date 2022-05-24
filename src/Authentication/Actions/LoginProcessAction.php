<?php
declare(strict_types=1);

namespace App\Authentication\Actions;

use App\Application\Actions\Action;
use App\Authentication\Service\AuthService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Views\PhpRenderer;

class LoginProcessAction extends Action
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
     * @var Response
     */
    protected Response $response;

    /**
     * @param AuthService $authService
     * @param LoggerInterface $logger
     * @param PhpRenderer $phpRenderer
     */
    public function __construct(
        AuthService $authService,
        LoggerInterface $logger,
        PhpRenderer $phpRenderer
    )
    {
        parent::__construct($logger);

        $this->authService = $authService;
        $this->phpRenderer = $phpRenderer;
    }

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $messages = null;
        $isLoggedIn = $this->request->getAttribute(AuthService::ATTR_ISLOGGEDIN);
        $requestMethod = $this->request->getMethod();

        $header = $this->phpRenderer->fetch("common/_header.php");

        if( ! $isLoggedIn
//            && strtolower($requestMethod)==="post"
        ) {
            $postBody = $this->request->getParsedBody();
            if(!empty($postBody)
                && is_array($_POST)
                && ! empty($_POST['username'])
                && ! empty($_POST['password'])
                && strlen($_POST['password']) > 3
                && array_key_exists('form_name',$_POST)
                && $_POST['form_name']==='form_user_login')
            {
                // user submitted login form
                $username = htmlspecialchars(trim($postBody['username']));
                $password = htmlspecialchars(trim($postBody['password']));

                $isAuthValid = $this->authService->authenticate($username,$password);

                if($isAuthValid) {
                    $this->authService->login($isAuthValid['id'],$isAuthValid['username'],);
                    $this->authService->redirect('news');

                } else {
                    $messages['warning'][] = "Incorrect username or password.";
                }
            } else {
                $messages['warning'][] = "Form was incomplete.";
            }

            $messagesTemplate = $this->phpRenderer->fetch("common/messages.php",['messages'=>$messages]);
            $forms['form_login'] = $this->phpRenderer->fetch(
                "forms/form-login.php",
                [
                    'messages_template'=>$messagesTemplate
                ]
            );

            return $this->phpRenderer->render(
                $this->response,
                "pages/homepage.php",
                [
                    'forms'=>$forms,
                    'is_logged_in'=>$isLoggedIn,
                    'header'=>$header,
                    'messages'=>$messages,
                ]
            );

        } else {


            $this->response->withStatus(403);

            return $this->phpRenderer->render(
                $this->response,
                "common/403.php",
                [
                    'is_logged_in'=>$isLoggedIn,
                    'header'=>$header,
                    'messages'=>$messages,
                ]
            );





            // Just display Login form
            $forms['form_login'] = $this->phpRenderer->fetch("forms/form-login.php");
            $messages['warning'][] = "Form was incomplete.";

            return $this->phpRenderer->render(
                $this->response,
                "pages/homepage.php",
                [
                    'forms'=>$forms,
                    'is_logged_in'=>$isLoggedIn,
                    'header'=>$header,
                    'messages'=>$messages,
                ]
            );
        }
    }
}
