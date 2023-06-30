<form id="register" data-action="sendsms" method="post">
	<?=bitrix_sessid_post();?>
	<div class="form__block" data-login>
		<label class="form__label" for="reg_login">Телефон</label>
		<input class="form__input" data-mask="phone" name="login" type="tel" id="reg_login" data-required required placeholder="+7(___)___-__-__">
		<span class="form__error">Заполните обязательные поля</span>
	</div>
	<div class="form__block user__agreement">
		<input class="form__input" name="agreement" type="checkbox" id="reg__agreement" data-required required>
		<label class="form__label" for="reg__agreement">Я разрешаю MI FI TI использовать мои
			личные данные в соответствии с пользовательским соглашением</label>
		<span class="form__error">Примите пользовательское соглашение</span>
	</div>
	<div class="form__block">
		<div id="recaptcha__register" class="g-recaptcha"></div>
	</div>
	<div class="form__block">
		<span class="form__result"></span>
	</div>
	<button class="btn btn__main--black header__personal--reg__submit" type="submit">
		Получить SMS
	</button>
</form>