<?php
declare(strict_types=1);

namespace App\Application\Actions\Page;

use App\Application\Actions\Action;
use App\Domain\User\UserRepository;
use App\News\Domain\NewsModel;
use App\News\Domain\TagsModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use App\Authentication\Service\AuthService;
use Slim\Views\PhpRenderer;

class HomepageAction extends PageAction
{
    /**
     * @var TagsModel
     */
    protected TagsModel $tagsModel;

    protected NewsModel $newsModel;

    /**
     * @param AuthService     $authService
     * @param LoggerInterface $logger
     * @param NewsModel       $newsModel
     * @param PhpRenderer     $phpRenderer
     * @param TagsModel       $tagsModel
     */
    public function __construct(
        AuthService $authService,
        LoggerInterface $logger,
        NewsModel $newsModel,
        PhpRenderer $phpRenderer,
        TagsModel $tagsModel
    ) {
        parent::__construct($authService, $logger, $phpRenderer);

        $this->newsModel = $newsModel;
        $this->tagsModel = $tagsModel;
    }

    /**
     * @return Response
     * @throws \Throwable
     */
    protected function action(): Response
    {
        // Check User Authorization and Authentication
        $isAdminUser = $this->request->getAttribute(AuthService::ATTR_ISADMIN);
        $isLoggedIn = $this->request->getAttribute(AuthService::ATTR_ISLOGGEDIN);

        // If user is logged in then display News List.
        // If user is NOT logged in then display the Register and Login forms.
        if($isLoggedIn) {
            // User is logged in.
            // Read all Tags
            $tagsList = $this->tagsModel->readAll();
            // Render Filter form
            $forms['form_filter'] = $this->phpRenderer->fetch(
                "forms/form-filter.php",
                [
                    'tags_list'=>$tagsList
                ]
            );

            // Fetch News template with data:
            $newsListTemplate = $this->phpRenderer->fetch(
                "news/news-list.php",
                [
                    'news_list'=>$this->newsModel->readAll(),
                    'is_admin'=>$isAdminUser,
                    'forms'=>$forms,
                ]
            );

        } else {
            // User not logged in.
            $newsListTemplate=null;

            // Fetch LOGIN form view:
            $forms['form_login'] = ($isLoggedIn)
                ?null
                :$this->phpRenderer->fetch("forms/form-login.php");
            // Fetch REGISTER form view:
            $forms['form_register'] = ($isLoggedIn)
                ?null
                :$this->phpRenderer->fetch("forms/form-register.php");

        }

        // FORMS
        $forms['form_login'] = ($isLoggedIn)?$isLoggedIn:$this->phpRenderer->fetch("forms/form-login.php");
        $forms['form_register'] = ($isLoggedIn)?$isLoggedIn:$this->phpRenderer->fetch("forms/form-register.php");



        return $this->phpRenderer->render(
            $this->response,
            "pages/homepage.php",
            [
                'news_list'=>$newsListTemplate,
                'forms'=>$forms,
                'is_logged_in'=>$isLoggedIn,
                'is_admin'=>$isAdminUser,
                'header'=>$this->getHeaderView($isLoggedIn, $isAdminUser)
            ]
        );

    }
}
