<?php
namespace api\controllers;

use api\models\AuthForm;
use Yii;
use yii\rest\Controller;

class AuthController extends Controller
{
	public function actionIndex()
	{
		$model = new AuthForm();
		$model->load(Yii::$app->request->bodyParams, '');
		if ($token = $model->auth()) {
			return $token;
		} else {
			return $model;
		}
	}

	protected function verbs()
	{
		return [
			'index' => ['post'],
		];
	}
}