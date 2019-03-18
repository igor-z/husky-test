<?php

namespace api\models;

use common\models\Token;
use common\models\User;
use yii\base\Model;

class AuthForm extends Model
{
	public $username;
	public $password;

	private $_user;

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['username', 'password'], 'required'],
			['password', 'validatePassword'],
		];
	}

	public function validatePassword($attribute, $params)
	{
		if (!$this->hasErrors()) {
			$user = $this->getUser();
			if (!$user || !$user->validatePassword($this->password)) {
				$this->addError($attribute, 'Incorrect username or password.');
			}
		}
	}

	public function auth() : ?Token
	{
		if (!$this->validate())
			return null;

		$token = new Token();
		$token->user_id = $this->getUser()->id;
		$token->generateToken(time() + 3600 * 24);
		return $token->save() ? $token : null;
	}

	protected function getUser() : ?User
	{
		if ($this->_user === null) {
			$this->_user = User::findByUsername($this->username);
		}

		return $this->_user;
	}
}