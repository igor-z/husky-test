<?php
?>

<div class="container">
    <div class="row">
		<div class="col-sm">
			One of three columns
		</div>
		<div class="col-sm">
			One of three columns
		</div>
		<div class="col-sm">
			One of three columns
		</div>
    </div>
</div>

<script>
    <?php ob_start()?>

    (function () {
		$.ajax({
			url: '/api/station',
			data: {
				username: $('#loginform-username').val(),
				password: $('#loginform-password').val()
			},
			headers: {
				'Authorization': 'Bearer ' + localStorage.getItem('accessToken')
			},
 		})
			.success(function (data) {
				alert(data);
			});
    })();

    <?php $this->registerJs(ob_get_clean())?>
</script>