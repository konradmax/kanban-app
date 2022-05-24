<?php

namespace App\Infrastructure\Persistence\Service;

use App\Users\Model\UserModel;
use App\Users\Model\AdminUserModel;
use App\Application\Settings\SettingsInterface;

class EloquentDBService
{

    protected $userModel;

    const ATTR_ISLOGGEDIN = 'is_logged_in';
    const ATTR_ISADMIN = 'is_admin_user';
    const ATTR_USERID = 'user_id';
    const ATTR_USERNAME = 'username';

    public function __construct(UserModel $userModel,AdminUserModel $adminUserModel, SettingsInterface $settings)
    {
        $this->userModel = $userModel;
        $this->adminUserModel = $adminUserModel;
        $this->settings = $settings;
    }


    public function authenticate($username,$password)
    {
        $result = $this->userModel->read(
            [
                'username'=>$username,
                'password'=>$password
            ]
        );
        return ($result);
    }

    /**
     * Login User
     *
     * @param  $id
     * @param  $username
     * @return bool
     */
    public function login($id,$username)
    {
        $_SESSION[self::ATTR_USERID] = $id;
        $_SESSION[self::ATTR_USERNAME] = $username;
        $_SESSION[self::ATTR_ISLOGGEDIN] = 1;

        return true;
    }

    public function logout()
    {
        unset($_SESSION[self::ATTR_USERID], $_SESSION[self::ATTR_USERNAME], $_SESSION[self::ATTR_ISLOGGEDIN]);
    }

    public function isLoggedIn()
    {
        if(array_key_exists(self::ATTR_ISLOGGEDIN, $_SESSION)&& $_SESSION[self::ATTR_ISLOGGEDIN]==1) {
            return true;
        }

        return false;
    }

    public function getCurrentUserData()
    {
        return [
            self::ATTR_USERID => $_SESSION[self::ATTR_USERID],
            self::ATTR_USERNAME=>$_SESSION[self::ATTR_USERNAME]
        ];
    }

    public function getCurrentUserId()
    {
        if(array_key_exists(self::ATTR_USERID, $_SESSION)) {
            return $_SESSION[self::ATTR_USERID];
        }
        return null;
    }

    public function isAdmin(): bool
    {
        $result = $this->adminUserModel->read(
            [
                'user_id'=>$this->getCurrentUserId(),
            ]
        );

        return ( ! empty($result))?true:false;
    }

    public function redirect($url=null)
    {
        header('Location: ' . $_SERVER['WEB_ADDR'] . '/' . $url);
        exit;
    }

    public function forbidden()
    {
        header('HTTP/1.0 403 Forbidden');

        $viewSettings = $this->settings->get('view');
        $contents = file_get_contents($viewSettings['template_path'] . '/../templates/403.php', true);

        exit($contents);
    }
}