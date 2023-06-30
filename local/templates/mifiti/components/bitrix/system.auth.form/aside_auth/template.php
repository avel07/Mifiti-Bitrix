<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

?>
<form id="auth">
	<div class="form__block">
		<label class="form__label" for="auth__phone">Телефон</label>
		<input class="form__input" type="tel" name="login" data-mask="phone" id="auth__phone" data-required
			placeholder="+7(___)___-__-__" required>
		<span class="form__error">Заполните обязательные поля</span>
	</div>
	<div class="form__block">
		<label class="form__label" for="auth__password">Пароль</label>
		<input class="form__input" type="password" name="password" id="auth__password" data-required placeholder
			required>
		<span class="form__error">Заполните обязательные поля</span>
	</div>
	<?=bitrix_sessid_post();?>
	<div class="form__block">
		<span class="form__result"></span>
	</div>
	<button class="btn btn__main--black header__personal--auth__submit" type="submit">
		Войти
	</button>
</form>