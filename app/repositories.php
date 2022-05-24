<?php
declare(strict_types=1);

use App\News\Domain\NewsModel;
use App\News\Domain\TagsModel;
use App\Tasks\Domain\SwimlanesModel;
use App\Users\Model\AdminUserModel;
use App\Users\Model\UserModel;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        UserModel::class => \DI\autowire(UserModel::class),
        AdminUserModel::class => \DI\autowire(AdminUserModel::class),
        TagsModel::class => \DI\autowire(TagsModel::class),
        NewsModel::class => \DI\autowire(NewsModel::class),
        SwimlanesModel::class => \DI\autowire(SwimlanesModel::class),
    ]);
};
