<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {
    public $id;
    
    public function getId() {
        return $this->id;
    }
    
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate() {
		$obUser=Users::model()->findByAttributes(array('login'=>$this->username));
        if(!$obUser)
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        elseif($obUser->password!==Users::genHash($this->password))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else {
			$this->errorCode=self::ERROR_NONE;
            $this->id=$obUser->id;
        }
		return !$this->errorCode;
	}
}