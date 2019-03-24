<?php
namespace api\controllers;

use api\models\AuthForm;
use Yii;
use yii\rest\Controller;

class AuthController extends Controller
{
    public function actionLogin()
    {
		$model = new AuthForm();
		$model->load(Yii::$app->request->bodyParams, '');
		if ($token = $model->auth()) {
			return $token;
		} else {
			return $model;
		}
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
    }

    protected function verbs()
    {
		return [
			'login' => ['post'],
			'logout' => ['post'],
		];
    }
}