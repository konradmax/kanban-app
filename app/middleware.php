<?php
declare(strict_types=1);

use App\Application\Middleware\SessionMiddleware;
use App\Application\Middleware\IsAjaxMiddleware;
//use App\Authentication\Middleware\AuthenticationJWTServiceMiddleware as AuthenticationServiceMiddleware;
use App\Authentication\Middleware\AuthenticationServiceMiddleware;
use App\Common\Middleware\HostnameMiddleware;
use Slim\App;

return function (App $app) {
    $app->add(HostnameMiddleware::class);
    $app->add(AuthenticationServiceMiddleware::class);
    $app->add(IsAjaxMiddleware::class);
    $app->add(SessionMiddleware::class);
};
