<?php
declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use App\Authentication\Service\AuthJWTService as AuthService;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Slim\Views\PhpRenderer;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        PhpRenderer::class => function (ContainerInterface $c) {
            $phpRenderer = new PhpRenderer();
            $phpRenderer->setTemplatePath(__DIR__ . '/../templates');
            $phpRenderer->setLayout('_layouts/blue.php');

            return $phpRenderer;
        },

        AuthService::class =>  \DI\autowire(AuthService::class)
    ]);
};
