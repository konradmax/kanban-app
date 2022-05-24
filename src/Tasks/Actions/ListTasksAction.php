<?php
declare(strict_types=1);

namespace App\Tasks\Actions;

use App\Application\Actions\Action;
use App\Application\Actions\Page\PageAction;
use App\Application\Middleware\IsAjaxMiddleware;
use App\Authentication\Service\AuthService;
use App\Tasks\Domain\SwimlanesModel;
use App\Tasks\Domain\TasksModel;
use App\News\Domain\TagsModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Views\PhpRenderer;
use Monolog\Logger;

class ListTasksAction extends PageAction
{
    /**
     * @var SwimlanesModel
     */
    protected SwimlanesModel $swimlanesModel;

    /**
     * @var TagsModel
     */
    protected TagsModel $tagsModel;

    /**
     * @var TasksModel
     */
    protected TasksModel $tasksModel;


    /**
     * @param AuthService     $authService
     * @param LoggerInterface $logger
     * @param PhpRenderer     $phpRenderer
     * @param SwimlanesModel  $swimlanesModel
     * @param TagsModel       $tagsModel
     * @param TasksModel      $tasksModel
     */
    public function __construct(
        AuthService $authService,
        LoggerInterface $logger,
        PhpRenderer $phpRenderer,
        SwimlanesModel $swimlanesModel,
        TagsModel $tagsModel,
        TasksModel $tasksModel
    ) {
        parent::__construct($authService, $logger, $phpRenderer);

        $this->swimlanesModel = $swimlanesModel;
        $this->tagsModel = $tagsModel;
        $this->tasksModel = $tasksModel;
    }

    /**
     * @return Response
     * @throws \Throwable
     */
    protected function action(): Response
    {
        $messages=null;
        // Check User Authorization and Authentication
        $currentUserId = $this->authService->getCurrentUserId();

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

        $swimlanesList = $this->swimlanesModel->readAll(['status'=>1]);
        $swimlanesListByValue=$this->swimlanesModel->sortByValue($swimlanesList);
        $taskStatusList = array_map(
            function ($c) {
                return $c['value'];
            }, $swimlanesListByValue
        );

        if($this->isAdmin()) {
            $resourceList = $this->tasksModel->readAll();
        } else {
            $resourceList = $this->tasksModel->readAll(['user_id'=>$currentUserId]);
        }


        $resourceListBySwimlane = $this->tasksModel->groupByStatus($resourceList, $taskStatusList);

        $this->logger->log(Logger::DEBUG, "DB found ".count($resourceList)." tasks by user_id:".$currentUserId." ; statuses:".count($swimlanesList));        $tagsList = $this->tagsModel->readAll();

        if($this->request->getAttribute(IsAjaxMiddleware::ISAJAX)) {
            return $this->respondWithData(
                [
                    'resource_list'=>$resourceListBySwimlane,
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
            "tasks/tasks-swimlanes.php",
            [
                'resource_list'=>$resourceList,
                'swimlanes_list'=>$swimlanesList,
                'resource_list_by_swimlane'=>$resourceListBySwimlane,
                'swimlanes_list_by_value'=>$swimlanesListByValue,
                'tags_list'=>$tagsList,
                'is_logged_in'=>$isLoggedIn,
                'forms'=>$forms,
                'is_admin'=>$this->isAdmin(),
                'messages'=>$messages,
                'header'=>$this->getHeaderView($isLoggedIn, $this->isAdmin())
            ]
        );

    }
}
