<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Class Token
 * @package common\models
 *
 * @property integer $id
 * @property integer $expired_at
 * @property integer $user_id
 * @property string $token
 *
 * @property User $user
 */
class Token extends ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return '{{%token}}';
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUser()
	{
		return $this->hasOne(User::class, ['id' => 'user_id']);
	}

	public function generateToken(int $expiredAt)
	{
		$this->expired_at = $expiredAt;
		$this->token = Yii::$app->security->generateRandomString();
	}

	public function fields()
	{
		return [
			'token' => 'token',
			'expired' => function () {
				return date(DATE_RFC3339, $this->expired_at);
			},
		];
	}
}