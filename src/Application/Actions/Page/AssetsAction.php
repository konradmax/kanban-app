<?php
declare(strict_types=1);

namespace App\Application\Actions\Page;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class AssetsAction extends Action
{

    protected function action(): Response
    {
        $assetType = (int) $this->resolveArg('assettype');
        $assetName = (int) $this->resolveArg('assetname');
        return file_get_contents();

    }
}
