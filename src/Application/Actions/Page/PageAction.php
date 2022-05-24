<?php
declare(strict_types=1);

namespace App\Application\Actions\Page;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Views\PhpRenderer;
use App\Authentication\Service\AuthService;

class PageAction extends Action
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

    protected function action(): Response
    {
        $news = $this->newsModel->readAll();

        return $this->phpRenderer->render($this->response, "homepage.php", ['news'=>$news]);

    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function getHeaderView($isLoggedIn=false,$isAdminUser=false)
    {
        return $this->phpRenderer
            ->fetch(
                "common/_header.php",
                [
                    'is_logged_in'=>$isLoggedIn,
                    'is_admin'=>$isAdminUser,
                ]
            );
    }
}
