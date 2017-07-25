<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	//Variable Id
	private $_id;
	private $_name;
	private $_lastname;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		//Instancia del modelo Usuarios
		$users = User::model()->find("user_lockoutenabled = 0 AND user_status = 1 AND user_name =?", array(strtolower($this->username)));


		if($users===null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		elseif(md5($this->password)!==$users->user_passwordhash)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
		{
			//Set User Id & Email
			$this->_id = $users->user_id;
			$this->_name = $users->user_firtsname;
			$this->_lastname = $users->user_lastname;
			$this->setState("email",$users->user_email);
			$this->errorCode=self::ERROR_NONE;
		}
		return !$this->errorCode;
	}

	/**
	* GET ID User
	* @return User ID
	*/
	public function getId()
	{
		return $this->_id;
	}

	/**
	* GET Name User
	* @return User Name
	*/
	public function getName()
	{
		return $this->_name;
	}

	/**
	* GET LastName User
	* @return User LastName
	*/
	public function getLastname()
	{
		return $this->_lastname;
	}

}