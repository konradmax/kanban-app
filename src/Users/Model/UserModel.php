<?php

namespace App\Users\Model;

use App\Common\Domain\CommonModel;
//use Illuminate\Database\Eloquent\Model as CommonModel;

class UserModel extends CommonModel
{
    protected $table = "users";

    public function checkIfUserExistsByUsername($username)
    {
        return $this->read(['username'=>$username]);
    }
}
