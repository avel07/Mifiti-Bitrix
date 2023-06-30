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
$this->setFrameMode(true);
?>
<div class="catalog__filter">
	<div class="container">
		<div class="catalog__filter--block row">
		<form name="<?=$arResult["FILTER_NAME"]."_form"?>" action="<?=$arResult["FORM_ACTION"]?>" method="get" class="catalog__filter--form col-xxl-10 col-xl-9 col-lg-9 col-md-8">
		<?foreach($arResult["HIDDEN"] as $arItem):?>
			<input type="hidden" name="<?=$arItem["CONTROL_NAME"]?>" id="<?=$arItem["CONTROL_ID"]?>" value="<?=$arItem["HTML_VALUE"]?>" />
		<?endforeach;?>
				<div class="catalog__filter--mob">
					<div class="catalog__filter--mob__title">
						Фильтры
					</div>
					<div class="catalog__filter--mob__close">
						<svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M1 23.9993L24 1" stroke="#1D1D1D" stroke-linecap="round"></path>
							<path d="M1 1.0007L24 24" stroke="#1D1D1D" stroke-linecap="round"></path>
						</svg>
					</div>
				</div>
				<div class="catalog__filter--items">
					<?//Фильтр по цене?>
					<?foreach($arResult["ITEMS"] as $key=>$arItem):?>
						<?
						$key = $arItem["ENCODED_ID"];
						if(isset($arItem["PRICE"])):
							if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)
								continue;
						?>
						<div class="catalog__filter--item">
						<div class="catalog__filter--item__title">Цена
							<div class="catalog__filter--item__icon">
								<svg width="17" height="9" viewBox="0 0 17 9" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<path d="M1 1L8.5 8L16 1" stroke="#1D1D1D" />
								</svg>
							</div>
						</div>
						<div class="catalog__filter--item__body collapse">
							<div class="catalog__filter--item__body--items catalog__filter--item__body--price">
								<div
									class="catalog__filter--item__body--item catalog__filter--item__body--item__price form__block">
									<label for="<?=$arItem["VALUES"]["MIN"]["CONTROL_ID"]?>" class="form__label">Мin цена (р.)</label>
									<input type="text" class="form__input"
									name="<?=$arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
									id="<?=$arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
									value="<?=$arItem["VALUES"]["MIN"]["HTML_VALUE"] > 0 ? $arItem["VALUES"]["MIN"]["HTML_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"]?>"
									data-min-price="<?=$arItem['VALUES']['MIN']['VALUE']?>"
									>
								</div>
								<div
									class="catalog__filter--item__body--item catalog__filter--item__body--item__price form__block">
									<label for="<?=$arItem["VALUES"]["MAX"]["CONTROL_ID"]?>" class="form__label">Max цена (р.)</label>
									<input type="text" class="form__input"
									name="<?=$arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
									id="<?=$arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
									value="<?=$arItem["VALUES"]["MAX"]["HTML_VALUE"] > 0 ? $arItem["VALUES"]["MAX"]["HTML_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"]?>"
									data-max-price="<?=$arItem['VALUES']['MAX']['VALUE']?>"
									>
								</div>
							</div>
							<div class="catalog__filter--item__body--submit">
								<input type="submit" name="set_filter" class="btn btn__main--black" value="Применить">
							</div>
						</div>
					</div>
						<?endif;?>
					<?endforeach;?>
					<?//Фильтр по свойствам?>
					<?foreach($arResult["ITEMS"] as $key=>$arItem):?>
					<?if(empty($arItem["VALUES"])|| isset($arItem["PRICE"])) continue;?>
					<?if($arItem["DISPLAY_TYPE"] == "A"&& ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)) continue;?>
					<?$arCur = current($arItem["VALUES"]);?>
						<?switch ($arItem["DISPLAY_TYPE"]){
						case 'A':
						break;
						case 'B':
						break;
						default://Показываем только чекбоксы?>
						<div class="catalog__filter--item">
							<div class="catalog__filter--item__title"><?=$arItem['NAME']?>
								<div class="catalog__filter--item__icon">
									<svg width="17" height="9" viewBox="0 0 17 9" fill="none"
										xmlns="http://www.w3.org/2000/svg">
										<path d="M1 1L8.5 8L16 1" stroke="#1D1D1D" />
									</svg>
								</div>
							</div>
							<div class="catalog__filter--item__body collapse">
								<div class="catalog__filter--item__body--items">
							<?foreach($arItem['VALUES'] as $key => $arValue):?>
								<div class="catalog__filter--item__body--item">
									<input type="checkbox"
									value="<?=$arValue["HTML_VALUE"]?>"
									name="<?=$arValue["CONTROL_NAME"]?>"
									id="<?=$arValue["CONTROL_ID"]?>"
									<?=$arValue['CHECKED'] ? 'checked': ''?>
									>
									<label for="<?=$arValue['CONTROL_ID']?>"><?=$arValue['VALUE']?></label>
								</div>
							<?endforeach;?>
								</div>
								<div class="catalog__filter--item__body--submit">
									<input type="submit" name="set_filter" class="btn btn__main--black" value="Применить">
								</div>
							</div>
						</div>
						<?};?>
					<?endforeach;?>
				</div>
				<div class="catalog__filter--mob__submit">
					<input type="submit" name="set_filter" class="btn btn__main--black" value="Применить и закрыть">
				</div>
			</form>
			<div class="catalog__filter--open col-sm-4 col-xs-4">
				<div class="catalog__filter--open__icon">
					<svg width="13" height="10" viewBox="0 0 13 10" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd"
							d="M7.48409 2.59259H0.555556C0.248731 2.59259 0 2.34386 0 2.03704C0 1.73021 0.248731 1.48148 0.555556 1.48148H7.48409C7.72591 0.62648 8.51202 0 9.44444 0C10.3769 0 11.163 0.62648 11.4048 1.48148H12.4074C12.7142 1.48148 12.963 1.73021 12.963 2.03704C12.963 2.34386 12.7142 2.59259 12.4074 2.59259H11.4048C11.163 3.44759 10.3769 4.07407 9.44444 4.07407C8.51202 4.07407 7.72591 3.44759 7.48409 2.59259ZM8.51852 2.03704C8.51852 1.52566 8.93307 1.11111 9.44444 1.11111C9.95582 1.11111 10.3704 1.52566 10.3704 2.03704C10.3704 2.54841 9.95582 2.96296 9.44444 2.96296C8.93307 2.96296 8.51852 2.54841 8.51852 2.03704Z"
							fill="#1D1D1D" />
						<path fill-rule="evenodd" clip-rule="evenodd"
							d="M5.47888 8.51852H12.4074C12.7142 8.51852 12.963 8.26979 12.963 7.96296C12.963 7.65614 12.7142 7.40741 12.4074 7.40741H5.47888C5.23705 6.5524 4.45095 5.92593 3.51852 5.92593C2.58609 5.92593 1.79999 6.5524 1.55816 7.40741H0.555556C0.248731 7.40741 0 7.65614 0 7.96296C0 8.26979 0.248731 8.51852 0.555556 8.51852H1.55816C1.79999 9.37352 2.58609 10 3.51852 10C4.45095 10 5.23705 9.37352 5.47888 8.51852ZM2.59259 7.96296C2.59259 7.45159 3.00714 7.03704 3.51852 7.03704C4.02989 7.03704 4.44444 7.45159 4.44444 7.96296C4.44444 8.47434 4.02989 8.88889 3.51852 8.88889C3.00714 8.88889 2.59259 8.47434 2.59259 7.96296Z"
							fill="#1D1D1D" />
					</svg>
				</div>
				<div class="catalog__filter--open__title">
					Фильтры
				</div>
			</div>
			<?if($arResult['CHECKED_ITEMS']):?>
			<a href="<?=$arResult['FORM_ACTION']?>" class="catalog__filter--deleteAll col-xxl-2 col-xl-3 col-lg-3 col-md-4 col-sm-8 col-xs-8">
				<div class="catalog__filter--deleteAll__icon">
					<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M0.999821 10.9997L10.9995 1" stroke="#1D1D1D" stroke-linecap="round" />
						<path d="M0.999822 1.00031L10.9995 11" stroke="#1D1D1D" stroke-linecap="round" />
					</svg>
				</div>
				<div class="catalog__filter--deleteAll__title">Очистить все фильтры</div>
			</a>
			<?endif;?>
		</div>
		<?if($arResult['CHECKED_ITEMS']):?>
		<div class="catalog__filter--selected">
			<div class="catalog__filter--selected__items">
				<?foreach($arResult['CHECKED_ITEMS'] as $key => $arItem):?>
					<?if($key !== 'PRICES'):?>
					<?foreach($arItem as $arValue):?>
					<div class="catalog__filter--selected__item" data-filter="<?=$arValue['CONTROL_ID']?>">
						<div class="catalog__filter--selected__item--name"><?=$arValue['VALUE']?></div>
						<div class="catalog__filter--selected__item--remove">
							<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M0.999821 10.9997L10.9995 1" stroke="#1D1D1D" stroke-linecap="round" />
								<path d="M0.999822 1.00031L10.9995 11" stroke="#1D1D1D" stroke-linecap="round" />
							</svg>
						</div>
					</div>
					<?endforeach;?>
					<?elseif($key === 'PRICES'):?>
					<div class="catalog__filter--selected__item" data-price-min="<?=$arItem['MIN']['VALUE']?>" data-price-max="<?=$arItem['MAX']['VALUE']?>">
						<div class="catalog__filter--selected__item--name"><?=$arItem['MIN']['HTML_VALUE'].' р.'.' - '.$arItem['MAX']['HTML_VALUE'].' р.'?></div>
						<div class="catalog__filter--selected__item--remove">
							<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M0.999821 10.9997L10.9995 1" stroke="#1D1D1D" stroke-linecap="round" />
								<path d="M0.999822 1.00031L10.9995 11" stroke="#1D1D1D" stroke-linecap="round" />
							</svg>
						</div>
					</div>
					<?endif;?>
				<?endforeach;?>
			</div>
		</div>
		<?endif;?>
	</div>
</div>