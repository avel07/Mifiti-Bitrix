<form id="change_password" data-action="sendsms" method="post">
	<?=bitrix_sessid_post();?>
	<div class="form__block" data-login>
		<label class="form__label" for="login">Телефон</label>
		<input class="form__input" data-mask="phone" name="login" type="tel" id="pass_login" data-required required placeholder="+7(___)___-__-__">
		<span class="form__error">Заполните обязательные поля</span>
	</div>
	<div class="form__block">
		<div id="recaptcha__changepass" class="g-recaptcha"></div>
	</div>
	<div class="form__block">
		<span class="form__result"></span>
	</div>
	<button class="btn btn__main--black header__personal--pass__submit" type="submit">
		Получить SMS
	</button>
</form>