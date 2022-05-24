<?php
declare(strict_types=1);

namespace App\Tasks\Actions;

use App\Application\Actions\Page\PageAction;
use App\Authentication\Service\AuthService;
use App\News\Domain\TagsModel;
use App\Tasks\Domain\TasksModel;
use App\Tasks\Domain\SwimlanesModel;
use App\Users\Model\UserModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Views\PhpRenderer;

class CreateTasksAction extends PageAction
{
    /**
     * @var TasksModel
     */
    protected TasksModel $tasksModel;

    /**
     * @var UserModel
     */
    protected UserModel $userModel;

    /**
     * @var TagsModel
     */
    protected TagsModel $tagsModel;

    /**
     * @var SwimlanesModel
     */
    protected SwimlanesModel $swimlanesModel;

    const FORMNAME_CREATE = "form_tasks_create";

    /**
     * @param AuthService $authService
     * @param LoggerInterface $logger
     * @param PhpRenderer $phpRenderer
     * @param SwimlanesModel $swimlanesModel
     * @param TagsModel $tagsModel
     * @param TasksModel $tasksModel
     * @param UserModel $userModel
     */
    public function __construct(
        AuthService $authService,
        LoggerInterface $logger,
        PhpRenderer $phpRenderer,
        SwimlanesModel $swimlanesModel,
        TagsModel $tagsModel,
        TasksModel $tasksModel,
        UserModel $userModel
    ) {
        parent::__construct($authService, $logger, $phpRenderer);

        $this->tasksModel = $tasksModel;
        $this->tagsModel = $tagsModel;
        $this->userModel = $userModel;
        $this->swimlanesModel = $swimlanesModel;
    }

    protected function action(): Response
    {
        $messages = null;
        $isAdminUser = $this->request->getAttribute(AuthService::ATTR_ISADMIN);
        $isLoggedIn = $this->request->getAttribute(AuthService::ATTR_ISLOGGEDIN);

        $usersList = $this->userModel->readAll();
        $statesList = $this->swimlanesModel->readAll();

        if(! $isAdminUser) {
            return $this->phpRenderer->render(
                $this->response,
                "common/403.php",
                [
                    'messages'=>$messages,
                    'header'=>$this->getHeaderView($isLoggedIn,$isAdminUser)
                ]
            );
        }


        $postBody = $this->request->getParsedBody();

        if(isset($postBody['form_name'])&&$postBody['form_name']===self::FORMNAME_CREATE) {
            $postData = [
//                'date_created'=>date('Y-m-d H:i:s'),
                'description'=>htmlspecialchars(trim($postBody['description'])),
                'title'=>htmlspecialchars(trim($postBody['title'])),
                'user_id'=>htmlspecialchars(trim($postBody['user_id'])),
                'state'=>htmlspecialchars(trim($postBody['state'])),
                'status'=>1,
            ];

            $this->tasksModel->create($postData);
        }

        $tagsList = $this->tagsModel->readAll();

        return $this->phpRenderer->render(
            $this->response,
            "tasks/tasks-create.php",
            [
                'users_list' =>$usersList,
                'tags_list'=>$tagsList,
                'states_list'=>$statesList,
                'header'=>$this->getHeaderView($isLoggedIn,$isAdminUser)
            ]
        );

    }
}
