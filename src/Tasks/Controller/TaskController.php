<?php

namespace Max\Dashboard\Task\Controller;

use Max\Dashboard\Auth\Service\AuthService;
use Max\Dashboard\Task\Model\TasksModel;
use Max\Dashboard\Common\Utilities\Utilities;
use Max\Dashboard\Common\View\CommonView as View;
use \PDO;

class TaskController
{

    /**
     * @var View
     */
    protected View $view;

    /**
     * @var Utilities
     */
    protected Utilities $utilities;

    /**
     * @var TasksModel
     */
    protected TasksModel $taskModel;

    /**
     * @var AuthService
     */
    protected AuthService $authService;

    public function __construct()
    {
        $this->view = new View();
        $this->utilities = new Utilities();
        $this->taskModel = new TasksModel();
        $this->authService = new AuthService();
    }

    /**
     * @return false|string
     */
    public function index()
    {
        $currentUserId = $this->authService->getCurrentUserId();

        $content['page_title'] = "Tasks!";
        $content['tasks'] = $this->taskModel->getTasksByUserGroupByStatus($currentUserId);

        // check for messages
        $content['messages'] = $this->utilities->getMessages();
        $this->utilities->unsetMessages();

        return $this->view->setContent($content)->render("tasks");
    }

    /**
     * @return false|string
     */
    public function update()
    {
        if(isset($_GET['action'])
            && $_GET['action']=='update'
        ) {
            // form has been submitted
            if(isset($_POST['form_name'])&&$_POST['form_name']==="swimlane_update") {
                // user sent swimlane form

                if(isset($_POST["zadanie"])) {
                    foreach($_POST["zadanie"] as $zadanieId=>$statusId){

                        $zadanieId=filter_var($zadanieId, FILTER_SANITIZE_NUMBER_INT);
                        $statusId=filter_var($statusId, FILTER_SANITIZE_NUMBER_INT);

                        $currentUser=$this->authService->getCurrentUserData();

                        // check if tasks status has changed
                        $tasks = $this->taskModel->read(['id'=>$zadanieId,'status'=>$statusId]);

                        if(empty($tasks)) {

                            $isUpdated = $this->taskModel->updateTaskStatus($zadanieId, $statusId);

                        }
                    }
                }
            }

        }

        return $this->index();
    }

    /**
     * @return false|string|void
     */
    public function edit()
    {

        if($_SERVER['REQUEST_METHOD'] === 'POST'
            && array_key_exists('id', $_GET)
            && $_GET['id']>0
        ) {
            // user posted data
            $zadanieId=filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            // TODO: form validation


            $sql = sprintf(
                'SELECT * FROM tasks WHERE id=%d LIMIT 1 ',
                $zadanieId
            );

            $pdo = new PDO($_SERVER['DB_DSN'], $_SERVER['DB_USER'], $_SERVER['DB_PWD']);

            $query = $pdo->query($sql);

            $result = $query->fetchAll();
            $result= reset($result);

            $changed = false;

            // whitelist fields which maybe changed
            $inputChange = ['title','description','status'];

            // check if any data have been changed
            foreach($inputChange as $inputName) {
                if(isset($_POST[$inputName])
                    && isset($result[$inputName])
                    AND $_POST[$inputName]!==$result[$inputName]
                ) {
                    $changed[$inputName] = $_POST[$inputName];
                }
            }

            if($changed) {
                // sql update
                $i=0;
                $sql = "UPDATE tasks SET  ";

                foreach($changed as $changedInputName => $changedInputValue) {
                    if($i!==0) { $sql .=",";
                    }
                    $sql .= " " . $changedInputName.'="'. $changed[$changedInputName] .'"';
                    $i++;
                }

                $sql .= " WHERE id=" . $zadanieId;

                $pdo->query($sql);

                $_SESSION['messages'][] = "Dane zostaly zaktualizowane.";
                header('Location: http://'.$_SERVER['WEB_ADDR'].'/?page=tasks');
                exit;
            }

        } elseif(array_key_exists('id', $_GET)
            && $_GET['id']>0
        ) {

            $content['page_title'] = "Edit Item.";
            $content['form_name'] = "form_item_edit";
            $content['content'] = null;


            $zadanieId=filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

            $sql = sprintf(
                'SELECT * FROM tasks WHERE id=%d LIMIT 1 ',
                $zadanieId
            );
            $pdo = new PDO($_SERVER['DB_DSN'], $_SERVER['DB_USER'], $_SERVER['DB_PWD']);

            $query = $pdo->query($sql);

            $result = $query->fetchAll();
            if(empty($result)) {
                $this->utilities->addMessage("Zadanie nie istnieje.");
                Utilities::redirect();
            }
            // get first item
            $content['result'] = reset($result);

            // display form
            return $this->view->setContent($content)->render("form-task-item");

        }

        return $this->view->setContent('')->render("form-task-item");

        return 'edit';
    }

    /**
     * @return void
     */
    public function create()
    {
        if (isset($_POST['form_name'])) {


            $data = [
                "title"=>Utilities::generateRandomString(8),
                "description"=>Utilities::generateRandomString(50),
                "user_id"=>$this->authService->getCurrentUserId(),
                "status"=>1,
                ];

            $this->taskModel->create($data);
        }

        Utilities::redirect("?page=tasks");
    }

}
