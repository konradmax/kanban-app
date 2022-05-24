<?php
declare(strict_types=1);

namespace App\Tasks\Actions;

use App\Application\Actions\Action;
use App\Application\Actions\Page\PageAction;
use App\Authentication\Service\AuthService;
use App\Tasks\Domain\TasksModel;
use App\News\Domain\TagsModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Views\PhpRenderer;

class UpdateTasksStatesAction extends PageAction
{
    /**
     * @var TasksModel
     */
    protected TasksModel $tasksModel;


    /**
     * @var TagsModel
     */
    protected TagsModel $tagsModel;

    const FORMNAME_CREATE = "form_news_create";

    /**
     * @param AuthService     $authService
     * @param LoggerInterface $logger
     * @param TasksModel      $tasksModel
     * @param PhpRenderer     $phpRenderer
     * @param TagsModel       $tagsModel
     */
    public function __construct(
        AuthService $authService,
        LoggerInterface $logger,
        TasksModel $tasksModel,
        PhpRenderer $phpRenderer,
        TagsModel $tagsModel
    ) {
        parent::__construct(
            $authService,
            $logger,
            $phpRenderer
        );

        $this->tasksModel = $tasksModel;
        $this->tagsModel = $tagsModel;
    }

    protected function action(): Response
    {
        $messages = null;
        $isAdminUser = $this->request->getAttribute(AuthService::ATTR_ISADMIN);
        $isLoggedIn = $this->request->getAttribute(AuthService::ATTR_ISLOGGEDIN);

        $postBody = $this->request->getParsedBody();

        if(isset($postBody["tasks"])) {
            foreach($postBody["tasks"] as $taskId=>$stateId)
            {

                $taskId=filter_var($taskId, FILTER_SANITIZE_NUMBER_INT);
                $stateId=filter_var($stateId, FILTER_SANITIZE_NUMBER_INT);

                $currentUser=$this->authService->getCurrentUserData();

                // check if tasks status has changed
                $tasks = $this->tasksModel->read(['id'=>$taskId,'state'=>$stateId]);

                if(empty($tasks)) {
                    $isUpdated = $this->tasksModel->updateTaskState($taskId, $stateId);
                }
            }
        }

        header("Location: " . $_SERVER['WEB_ADDR'] . "/tasks");
        exit;

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
            "tasks/tasks-create.php",
            [
                'tags_list'=>$tagsList,
                'header'=>$this->getHeaderView($isLoggedIn, $isAdminUser)
            ]
        );

    }
}
