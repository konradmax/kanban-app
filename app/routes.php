<?php
declare(strict_types=1);

use App\Application\Actions\Page\HomepageAction;
use App\Authentication\Actions\AuthenticateJWTAction;
use App\Authentication\Actions\LoginAction;
use App\Authentication\Actions\LoginProcessAction;
use App\Authentication\Actions\LogoutAction;
use App\Authentication\Actions\RegisterAction;
use App\Authentication\Actions\RegisterProcessAction;
use App\News\Actions\CreateNewsAction;
use App\News\Actions\DeleteNewsAction;
use App\News\Actions\FilterNewsAction;
use App\News\Actions\ListNewsAction;
use App\Tasks\Actions\CreateTasksAction;
use App\Tasks\Actions\UpdateTasksStatesAction;
use App\Tasks\Actions\UpdateTasksAction;
use App\Tasks\Actions\DeleteTasksAction;
use App\Tasks\Actions\FilterTasksAction;
use App\Tasks\Actions\ListTasksAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    # Pages:
    $app->get('/', HomepageAction::class);

    # Register:
    $app->group('/register', function (Group $group) {
        $group->get('', RegisterAction::class);
        $group->post('/process', RegisterProcessAction::class);
    });
    # Login:
    $app->group('/login', function (Group $group) {
        $group->get('', LoginAction::class);
        $group->post('/process', LoginProcessAction::class);
    });
    # Logout
    $app->get('/logout', LogoutAction::class);

    # News:
    $app->group('/news', function (Group $group) {
        $group->get('', ListNewsAction::class);
        $group->get('/create', CreateNewsAction::class);
        $group->post('/create', CreateNewsAction::class);
        $group->post('/delete/{id}', DeleteNewsAction::class);
        // Filter
        $group->post('/filter', FilterNewsAction::class);
    });
    # Tasks:
    $app->group('/tasks', function (Group $group) {
        $group->get('', ListTasksAction::class);
        $group->get('/create', CreateTasksAction::class);
        $group->post('/update', UpdateTasksStatesAction::class);
        $group->post('/create', CreateTasksAction::class);
        $group->post('/delete/{id}', DeleteTasksAction::class);
        // Filter
        $group->post('/filter', FilterNewsAction::class);
    });
    # API Authentication:
    $app->group('/api',function(Group $group){
        $group->post('/login', AuthenticateJWTAction::class);
    });

};
