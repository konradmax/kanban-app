<?php
declare(strict_types=1);

namespace App\News\Actions;

use App\Application\Actions\Action;
use App\Application\Actions\Page\PageAction;
use App\Authentication\Service\AuthService;
use App\News\Domain\FilterModel;
use App\News\Domain\NewsModel;
use App\News\Domain\TagsModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Views\PhpRenderer;

class FilterNewsAction extends PageAction
{

    /**
     * @var FilterModel
     */
    protected FilterModel $filterModel;

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
        FilterModel $filterModel,
        LoggerInterface $logger,
        NewsModel $newsModel,
        PhpRenderer $phpRenderer,
        TagsModel $tagsModel
    ) {
        parent::__construct($authService, $logger, $phpRenderer);

        $this->filterModel = $filterModel;
        $this->tagsModel = $tagsModel;
    }

    protected function action(): Response
    {
        $messages=null;
        $isAdminUser = $this->request->getAttribute(AuthService::ATTR_ISADMIN);
        $isLoggedIn = $this->request->getAttribute(AuthService::ATTR_ISLOGGEDIN);

        if(!$isLoggedIn) {
            $_SESSION['messages']['warning'][] = "Must be logged in;";
            $this->authService->forbidden();
        }

        $filterPostData = $this->request->getParsedBody();
        $tagsList = $this->tagsModel->readAll();

        // check for TAGS
        if(array_key_exists('tags', $filterPostData)
            && ! empty($filterPostData['tags'])
            && $filterPostData['tags']==='0'
        ) {
            // None selected
            $filterPostData['tags'] = null;
        }

        $dateStart = ($filterPostData['date']['start'])??null;
        $dateEnd = ($filterPostData['date']['end'])??null;
        $newsList = $this->filterModel->filterByDateAndTags(
            $dateStart,
            $dateEnd,
            $filterPostData['tags']
        );

        $forms['form_filter'] = $this->phpRenderer->fetch(
            "forms/form-filter.php",
            [
                'date_end'=>$dateEnd,
                'date_start'=>$dateStart,
                'tags_list'=>$tagsList,
                'tags_selected'=>$filterPostData['tags']
            ]
        );

        return $this->phpRenderer->render(
            $this->response,
            "news/news-list.php",
            [
                'forms'=>$forms,
                'is_admin'=>$isAdminUser,
                'is_logged_in'=>$isLoggedIn,
                'news_list'=>$newsList,
                'tags_list'=>$tagsList,
                'header'=>$this->getHeaderView($isLoggedIn, $isAdminUser)
            ]
        );
    }
}
