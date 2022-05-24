<?php
declare(strict_types=1);

namespace App\News\Actions;

use App\Application\Actions\Page\PageAction;
use App\Application\Middleware\IsAjaxMiddleware;
use App\Authentication\Service\AuthService;
use App\News\Domain\NewsModel;
use App\News\Domain\TagsModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Views\PhpRenderer;

class ListNewsAction extends PageAction
{
    /**
     * @var TagsModel
     */
    protected TagsModel $tagsModel;

    /**
     * @var TagsModel
     */
    protected NewsModel $newsModel;

    /**
     * @param AuthService     $authService
     * @param LoggerInterface $logger
     * @param PhpRenderer     $phpRenderer
     * @param TagsModel       $tagsModel
     */
    public function __construct(
        AuthService $authService,
        NewsModel $newsModel,
        LoggerInterface $logger,
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
        $messages=null;
        // Check User Authorization and Authentication
        $isAdminUser = $this->request->getAttribute(AuthService::ATTR_ISADMIN);
        $isLoggedIn = $this->request->getAttribute(AuthService::ATTR_ISLOGGEDIN);

        if(! $isLoggedIn) {
            $_SESSION['messages']['warning'][] = "Must be logged in;";

            $this->response->withStatus(403);

            return $this->phpRenderer->render(
                $this->response,
                "common/403.php",
                [
                    'messages'=>$messages,
                    'header'=>$header
                ]
            );
        }

        $newsList = $this->newsModel->readAll();
        $tagsList = $this->tagsModel->readAll();

        if($this->request->getAttribute(IsAjaxMiddleware::ISAJAX)) {
            return $this->respondWithData(
                [
                    'news_list'=>$newsList,
                    'tags_list'=>$tagsList
                ]
            );
        }

        $forms['form_filter'] = $this->phpRenderer->fetch(
            "forms/form-filter.php",
            [
                'tags_list'=>$tagsList
            ]
        );

        return $this->phpRenderer->render(
            $this->response,
            "news/news-list.php",
            [
                'news_list'=>$newsList,
                'tags_list'=>$tagsList,
                'is_logged_in'=>$isLoggedIn,
                'forms'=>$forms,
                'is_admin'=>$isAdminUser,
                'messages'=>$messages,
                'header'=>$this->getHeaderView($isLoggedIn, $isAdminUser)
            ]
        );

    }
}
