<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?
// заменяем $arResult эпилога значением, сохраненным в шаблоне
if(isset($arResult['arResult'])) {
   $arResult =& $arResult['arResult'];
         // подключаем языковой файл
   global $MESS;
   include_once(GetLangFileName(dirname(__FILE__).'/lang/', '/template.php'));
} else {
   return;
}
?>
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();/** @var array $arParams */
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
<div class="catalog">
	<div class="container container__nopadding-sm">
		<div class="catalog__items catalog__new--items" itemscope itemtype="https://schema.org/ItemList">
			<div class="row row__nopadding-sm">
            <?foreach($arResult['ITEMS'] as $arItem):?>
				<?// Если товар с ТП?>
				<?if($arItem['PRODUCT']['USE_OFFERS']):?>
				<?$arOffer = $arItem['OFFERS'][0]?>
				<?$basePrice = $arOffer['ITEM_PRICES'][0]['BASE_PRICE']?>
				<?$price = $arOffer['ITEM_PRICES'][0]['PRICE']?>
				<?$isDiscount =  $basePrice > $price ? true : false?>
				<div class="col-lg-3 col-sm-6 col-xs-12">
					<div class="catalog__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/Product">
						<div class="catalog__item--body">
								<div class="catalog__item--image">
									<img itemprop="image" src="<?=$arItem['DETAIL_PICTURE']['SRC'] ? $arItem['DETAIL_PICTURE']['SRC'] : SITE_TEMPLATE_PATH.'/img/empty_photo.svg';?>" 
									alt="<?=$arItem['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'] ? $arItem['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'] : $arItem['NAME']?>"
									title="<?=$arItem['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'] ? $arItem['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'] : $arItem['NAME']?>"
									width="<?=$arItem['DETAIL_PICTURE']['SRC'] ? CFile::_GetImgParams($arItem['DETAIL_PICTURE']['ID'])['WIDTH'] : '300';?>"
									height="<?=$arItem['DETAIL_PICTURE']['SRC'] ? CFile::_GetImgParams($arItem['DETAIL_PICTURE']['ID'])['HEIGHT'] : '445';?>"
									>
								</div>
								<div class="catalog__item--button catalog__item--more">
									<a itemprop="url" href="<?=$arItem['DETAIL_PAGE_URL']?>" class="btn btn__main--white">Подробнее</a>
								</div>
								<div class="catalog__item--favorite <?=\CatalogHelper\favorites::isFavorite($arItem['ID']) ? 'active' : '';?>"
									data-favorite="<?=$arItem['ID']?>">
									<svg width="30" height="26" viewBox="0 0 30 26" fill="none"
										xmlns="http://www.w3.org/2000/svg">
										<path
											d="M15.1339 4.02526C15.6246 3.56348 16.0293 3.14514 16.4726 2.77105C21.1072 -1.13638 28.1619 1.36158 29.2528 7.31806C29.7186 9.86349 29.0251 12.1241 27.3019 14.0613C27.1884 14.1885 27.0661 14.3083 26.9463 14.429C23.2552 18.12 19.5642 21.8102 15.8732 25.5005C15.3543 26.0194 15.0196 26.0194 14.5007 25.4989C10.7928 21.7829 7.08248 18.0685 3.37698 14.3502C0.269211 11.2335 0.18313 6.45484 3.17103 3.29478C6.05836 0.242526 11.0688 0.092085 14.1443 2.97298C14.4879 3.29478 14.7912 3.65922 15.1331 4.02446L15.1339 4.02526Z"
											fill="none" stroke="white" />
									</svg>
								</div>
						</div>
						<div class="catalog__item--name" itemprop="name">
							<?=$arItem['NAME']?>
						</div>
						<meta itemprop="description" content="<?=$arItem['PREVIEW_TEXT']?>">
						<div class="catalog__item--bottom">
							<div class="catalog__item--prices" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
							<?if($arOffer['ITEM_PRICES']):?>
								<meta itemprop="priceCurrency" content="RUB"/>
								<?if($isDiscount):?>
								<div class="catalog__item--price price__old">
									<?=$basePrice?> р.
								</div>
								<div class="catalog__item--price price__discount" itemprop="price" content="<?=$price?>">
									<?=$price?> р.
								</div>
								<?else:?>
								<div class="catalog__item--price" itemprop="price" content="<?=$basePrice?>">
									<?=$basePrice?> р.
								</div>
								<?endif;?>
							<?endif;?>
							</div>
							<?if($arItem['PROPERTIES']['STICKERS']):?>
							<div class="catalog__item--stickers">
								<?foreach($arItem['PROPERTIES']['STICKERS']['VALUE'] as $sticker):?>
								<div
									class="catalog__item--sticker catalog__item--sticker__<?=$sticker === 'NEW' ? 'new' : 'sale'?>">
									<?=$sticker?>
								</div>
								<?endforeach;?>
							</div>
							<?endif;?>
						</div>
					</div>
				</div>
				<?// Если товар без ТП?>
				<?else:?>
				<?$basePrice = $arItem['ITEM_PRICES'][0]['BASE_PRICE']?>
				<?$price = $arItem['ITEM_PRICES'][0]['PRICE']?>
				<?$isDiscount =  $basePrice > $price ? true : false?>
				<div class="col-lg-3 col-sm-6 col-xs-12">
					<div class="catalog__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/Product">
						<div class="catalog__item--body">
								<div class="catalog__item--image">
									<img itemprop="image" src="<?=$arItem['DETAIL_PICTURE']['SRC'] ? $arItem['DETAIL_PICTURE']['SRC'] : SITE_TEMPLATE_PATH.'/img/empty_photo.svg';?>"
									alt="<?=$arItem['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'] ? $arItem['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'] : $arItem['NAME']?>"
									title="<?=$arItem['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'] ? $arItem['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'] : $arItem['NAME']?>"
									width="<?=$arItem['DETAIL_PICTURE']['SRC'] ? CFile::_GetImgParams($arItem['DETAIL_PICTURE']['ID'])['WIDTH'] : '300';?>"
									height="<?=$arItem['DETAIL_PICTURE']['SRC'] ? CFile::_GetImgParams($arItem['DETAIL_PICTURE']['ID'])['HEIGHT'] : '445';?>"
									>
								</div>
								<div class="catalog__item--button catalog__item--more">
									<a itemprop="url" href="<?=$arItem['DETAIL_PAGE_URL']?>" class="btn btn__main--white">Подробнее</a>
								</div>
								<div class="catalog__item--favorite <?=\CatalogHelper\favorites::isFavorite($arItem['ID']) ? 'active' : '';?>"
									data-favorite="<?=$arItem['ID']?>">
									<svg width="30" height="26" viewBox="0 0 30 26" fill="none"
										xmlns="http://www.w3.org/2000/svg">
										<path
											d="M15.1339 4.02526C15.6246 3.56348 16.0293 3.14514 16.4726 2.77105C21.1072 -1.13638 28.1619 1.36158 29.2528 7.31806C29.7186 9.86349 29.0251 12.1241 27.3019 14.0613C27.1884 14.1885 27.0661 14.3083 26.9463 14.429C23.2552 18.12 19.5642 21.8102 15.8732 25.5005C15.3543 26.0194 15.0196 26.0194 14.5007 25.4989C10.7928 21.7829 7.08248 18.0685 3.37698 14.3502C0.269211 11.2335 0.18313 6.45484 3.17103 3.29478C6.05836 0.242526 11.0688 0.092085 14.1443 2.97298C14.4879 3.29478 14.7912 3.65922 15.1331 4.02446L15.1339 4.02526Z"
											fill="none" stroke="white" />
									</svg>
								</div>
						</div>
						<div class="catalog__item--name" itemprop="name">
							<?=$arItem['NAME']?>
						</div>
						<meta itemprop="description" content="<?=$arItem['PREVIEW_TEXT']?>">
						<div class="catalog__item--bottom">
							<div class="catalog__item--prices" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
							<?if($arOffer['ITEM_PRICES']):?>
								<meta itemprop="priceCurrency" content="RUB"/>
								<?if($isDiscount):?>
								<div class="catalog__item--price price__old">
									<?=$basePrice?> р.
								</div>
								<div class="catalog__item--price price__discount" itemprop="price" content="<?=$price?>">
									<?=$price?> р.
								</div>
								<?else:?>
								<div class="catalog__item--price" itemprop="price" content="<?=$basePrice?>">
									<?=$basePrice?> р.
								</div>
								<?endif;?>
							<?endif;?>
							</div>
							<?if($arItem['PROPERTIES']['STICKERS']):?>
							<div class="catalog__item--stickers">
								<?foreach($arItem['PROPERTIES']['STICKERS']['VALUE'] as $sticker):?>
								<div
									class="catalog__item--sticker catalog__item--sticker__<?=$sticker === 'NEW' ? 'new' : 'sale'?>">
									<?=$sticker?>
								</div>
								<?endforeach;?>
							</div>
							<?endif;?>
						</div>
					</div>
				</div>
				<?endif;?>
				<?endforeach;?>
			</div>
		</div>
	</div>
</div>
<?if($arResult['NAV_STRING']):?>
	<?=$arResult['NAV_STRING']?>
<?endif;?>