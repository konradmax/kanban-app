<?php
declare(strict_types=1);

namespace App\News\Actions;

use App\Application\Actions\Action;
use App\Application\Actions\Page\PageAction;
use App\Authentication\Service\AuthService;
use App\News\Domain\NewsModel;
use App\News\Domain\TagsModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Views\PhpRenderer;

class CreateNewsAction extends PageAction
{
    /**
     * @var NewsModel
     */
    protected NewsModel $newsModel;

    /**
     * @var TagsModel
     */
    protected TagsModel $tagsModel;

    const FORMNAME_CREATE = "form_news_create";

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

        $this->authService = $authService;
        $this->newsModel = $newsModel;
        $this->phpRenderer = $phpRenderer;
        $this->tagsModel = $tagsModel;
    }

    protected function action(): Response
    {
        $messages = null;
        $isAdminUser = $this->request->getAttribute(AuthService::ATTR_ISADMIN);
        $isLoggedIn = $this->request->getAttribute(AuthService::ATTR_ISLOGGEDIN);

        if(! $isAdminUser) {
            return $this->phpRenderer->render(
                $this->response,
                "common/403.php",
                [
                    'messages'=>$messages,
                    'header'=>$this->getHeaderView()
                ]
            );
        }


        $postBody = $this->request->getParsedBody();

        if(isset($postBody['form_name'])&&$postBody['form_name']===self::FORMNAME_CREATE) {
            $postData = [
                'content'=>htmlspecialchars(trim($postBody['content'])),
                'date_created'=>date('Y-m-d H:i:s'),
                'description'=>htmlspecialchars(trim($postBody['description'])),
                'title'=>htmlspecialchars(trim($postBody['title'])),
            ];

            $this->newsModel->create($postData);
        }

        $tagsList = $this->tagsModel->readAll();

        return $this->phpRenderer->render(
            $this->response,
            "news/news-create.php",
            [
                'tags_list'=>$tagsList,
                'header'=>$this->getHeaderView()
            ]
        );

    }
}
