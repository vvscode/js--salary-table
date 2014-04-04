<?php
class UserIdentity extends CUserIdentity
{
    protected $_id;

    public function authenticate()
    {
        // Check sessions directory
        $sessionsDir = session_save_path();
        if(!empty($sessionsDir) && !file_exists($sessionsDir)){
            if(!mkdir($sessionsDir)){
                exit('Sessions folder "'.$sessionsDir.'" is inaccessible');
            }
        }

        $user = User::model()->findByAttributes(
            array('login' => $this->username, 'deleted' => 0)
        );
        if ($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else if (!$user->validatePassword($this->password)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {
            $this->_id=$user->id;
            $this->errorCode = self::ERROR_NONE;
        }

        // Check if no users exists
        // then create first users based on entered data
        if ($this->errorCode == self::ERROR_USERNAME_INVALID) {
            if (!UserIdentity::isAnyUserExists()) {
                $user = new User();
                $user->login = $this->username;
                $user->pass = $this->password;
                try {
                    $user->save();
                    $this->_id=$user->id;
                    $this->errorCode = self::ERROR_NONE;
                } catch (Exception $ex) {

                }
            }
        }

        return $this->errorCode == self::ERROR_NONE;
    }

    public static function isAnyUserExists()
    {
        return (bool)User::model()->count();
    }

    public function getId()
    {
        return $this->_id;
    }
}