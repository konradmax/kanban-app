<?php
declare(strict_types=1);

namespace App\News\Actions;

use App\Application\Actions\Action;
use App\Authentication\Service\AuthService;
use App\Domain\User\UserRepository;
use App\News\Domain\NewsModel;
use App\News\Domain\TagsModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Views\PhpRenderer;

class DeleteNewsAction extends Action
{
    protected NewsModel $newsModel;
    protected TagsModel $tagsModel;
    protected PhpRenderer $phpRenderer;
    protected AuthService $authService;

    const FORMNAME_DELETE = "form_news_delete";

    public function __construct(
        LoggerInterface $logger,
        NewsModel $newsModel,
        TagsModel $tagsModel,
        PhpRenderer $phpRenderer,
        AuthService $authService
    ) {
        parent::__construct($logger);

        $this->newsModel = $newsModel;
        $this->tagsModel = $tagsModel;
        $this->phpRenderer = $phpRenderer;
        $this->authService = $authService;
    }

    protected function action(): Response
    {
        $isAdminUser = $this->request->getAttribute(AuthService::ATTR_ISADMIN);

        if(! $isAdminUser) {
            $this->authService->forbidden();
        }


        $postBody = $this->request->getParsedBody();

        if(isset($postBody['form_name'])&&$postBody['form_name']===self::FORMNAME_DELETE) {
            $idGet = $this->resolveArg('id');
            $idPost = $postBody['news_id'];

            if($idGet!=$idPost) {
                $_SESSION['messages']['warning'][]="Malformed Form.";
                $this->authService->redirect();
            } else {
                $this->newsModel->delete($idPost);
                $_SESSION['messages']['success'][]="News Item deleted..";
                $this->authService->redirect('news');
            }
        }

    }
}
