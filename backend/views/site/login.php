<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
	            'action' => '#',
            ]); ?>
                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>


<script>
	<?php ob_start()?>

	(function () {
		$('#login-form').submit(function (e) {
			e.preventDefault();

			$.post(
				'/api/auth',
				{
					username: $('#loginform-username').val(),
					password: $('#loginform-password').val()
				},
				function (data) {
					if (data.token) {
						localStorage.setItem('accessToken', data.token);
						location.href = '/backend/';
					} else {
						alert(data);
					}
				}
			);
		});
	})();

	<?php $this->registerJs(ob_get_clean())?>
</script>