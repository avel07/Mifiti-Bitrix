<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
echo '<pre>';
// var_dump($arResult);
echo '</pre>';
if ($arResult["isFormErrors"] == "Y"):?><?=$arResult["FORM_ERRORS_TEXT"];?><?endif;?>
<?=$arResult["FORM_NOTE"]?>
<?if($arResult['isFormNote']):?>
<form class="return__sections">
                    <div class="return__section">
                        <div class="return__section--title">
                            Заполните форму
                        </div>
                        <div class="return__section--body">
						<?=bitrix_sessid_post();?>
						<input type="hidden" name="WEB_FORM_ID" value="<?=$arResult['arForm']['ID']?>">
							<?foreach($arResult['QUESTIONS'] as $key => $arItem):?>
							<div class="form__block col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <label class="form__label" for="personal__<?=strtolower($key)?>"><?=$arItem['CAPTION']?><?=$arItem['REQUIRED'] === 'Y' ? '*': ''?></label>
                                <input class="form__input" type="<?=$arItem['STRUCTURE'][0]['FIELD_TYPE']?>" id="personal__<?=strtolower($key)?>" <?=$arItem['REQUIRED'] === 'Y' ? 'data-required required ': ''?> name="form_<?=$arItem['STRUCTURE'][0]['FIELD_TYPE']?>_<?=$arItem['STRUCTURE'][0]['ID']?>" <?=$key === 'PHONE' ? 'data-mask="phone" placeholder="+7(___)___-__-__"': '';?>>
								<?=$arItem['REQUIRED'] === 'Y' ? '<span class="form__error">Заполните обязательные поля</span>': ''?>
                            </div>
							<?endforeach;?>
                        </div>
                    </div>
                            <div class="form__block user__agreement">
                                <input class="form__input" type="checkbox" id="order__agreement" data-required required>
                                <label class="form__label" for="order__agreement">Я разрешаю MI FI TI использовать мои личные данные в соответствии с пользовательским соглашением</label>
                                <span class="form__error">Примите пользовательское соглашение</span>
                            </div>
							<div class="form__block">
								<span class="form__result"></span>
							</div>
                    <button type="submit" id="return__submit" class="btn btn__main--black btn__main--black__bg return__submit">Отправить запрос</button>
                </form>
<?else:?>
	<?ShowError('В форме нет вопросов.')?>
<?endif;?>