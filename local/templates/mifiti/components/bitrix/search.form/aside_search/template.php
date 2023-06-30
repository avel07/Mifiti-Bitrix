<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);?>
<form action="<?=$arResult["FORM_ACTION"]?>" method="GET" id="search_form">
    <div class="form__block">
        <label class="form__label" for="search">Введите название товара или артикул</label>
        <input class="form__input" name="search" id="search" type="text" value="<?=\Bitrix\Main\Application::getInstance()->getContext()->getRequest()->get('search')?>" data-required required>
        <span class="form__error">Заполните обязательные поля</span>
    </div>
    <button class="btn btn__main--black header__search__submit" type="submit">
        Найти
    </button>
</form>