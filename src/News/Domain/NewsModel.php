<?php
declare(strict_types=1);

namespace App\News\Domain;

use App\Common\Domain\CommonModel;

class NewsModel extends CommonModel
{
    protected $table = "news";
}
