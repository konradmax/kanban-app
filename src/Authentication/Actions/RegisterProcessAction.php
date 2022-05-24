<?php
declare(strict_types=1);

namespace App\Authentication\Actions;

use App\Application\Actions\Action;
use App\Authentication\Service\AuthService;
use App\Users\Model\UserModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Views\PhpRenderer;

class RegisterProcessAction extends Action
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
     * @var UserModel
     */
    protected UserModel $userModel;

    const FORMNAME_CREATE = "form_register";

    /**
     * @param AuthService     $authService
     * @param LoggerInterface $logger
     * @param PhpRenderer     $phpRenderer
     * @param UserModel       $userModel
     */
    public function __construct(
        AuthService $authService,
        LoggerInterface $logger,
        PhpRenderer $phpRenderer,
        UserModel $userModel
    ) {
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

        if($isAdminUser || $isLoggedIn) {
            $this->authService->forbidden();
        }

        // If user is logged in then display News List.
        // If user is NOT logged in then display the Register and Login forms.


        if(! $isLoggedIn) {
            // As the User is not logged in it is possible to register.
            $postBody = $this->request->getParsedBody();

            if(!empty($postBody)
                && is_array($_POST)
                && ! empty($_POST['username'])
                && ! empty($_POST['password'])
                && $_POST['password'] === $_POST['password_confirm']
                && strlen($_POST['password']) > 3
                && array_key_exists('form_name', $_POST)
                && $_POST['form_name']==='form_register'
                && ! $this->userModel->checkIfUserExistsByUsername(trim($_POST['username']))
            ) {
                // Register with $this->userModel
                $result = $this->register($postBody);

                if($result) {


                    return $this->phpRenderer->render(
                        $this->response,
                        "pages/homepage.php",
                        [
                            'is_logged_in'=>$isLoggedIn,
                            'header'=>$header,
                            'messages'=>$messages,
                        ]
                    );



                    // User is registered. Redirect to the login form and exit.
                    $_SESSION['messages']['info'][] = "User registered. You can login now.";
                    header("Location: " . $_SERVER['WEB_ADDR'] . "/login");
                    exit;
                }
            } else {
                // There is some errors.
                // check if user already exists
                if($this->userModel->checkIfUserExistsByUsername(trim($postBody['username']))) {
                    $messages['warning'][] = "Username already taken.";
                }
                // Check if passwords the same
                if($_POST['password'] !== $postBody['password_confirm']) {
                    $messages['warning'][] = "Password and Password Confirmation are different.";
                }
                if(empty($messages['warning'])) {
                    $messages['danger'][] = "Empty form.";
                }
            }
        }

        return $this->phpRenderer->render(
            $this->response,
            "forms/form-register.php",
            ['messages'=>$messages,'header'=>$header]
        );
    }

    public function register($postBody)
    {
        $postData = [
            'username'=>$postBody['username'],
            'password'=>$postBody['password'],
            'status'=>1,
            'date_created'=>date('Y-m-d H:i:s')
        ];

        return $this->userModel->create($postData);
    }
}
