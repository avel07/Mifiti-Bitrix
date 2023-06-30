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
<div class="section__content">
	<div class="swiper">
		<div class="swiper-wrapper">
			<?foreach($arResult["ITEMS"] as $arItem):?>
			<div class="swiper-slide">
				<div class="main__slider--image">
					<picture itemscope itemtype="https://schema.org/ImageObject">
						<source media="(max-width: 767px)" type="image/jpeg" srcset="<?=CFile::GetPath($arItem['PROPERTIES']['IMAGE_MOB']['VALUE'])?>">
						<source media="(min-width: 768px)" type="image/jpeg"
							srcset="<?=$arItem['PREVIEW_PICTURE']['SRC']?>">
						<img itemprop="contentUrl" src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" 
						alt="<?=$arItem['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'] ? $arItem['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'] : $arItem['NAME']?>"
						title="<?=$arItem['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'] ? $arItem['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'] : $arItem['NAME']?>"
						width="<?=CFile::_GetImgParams($arItem['PREVIEW_PICTURE']['ID'])['WIDTH']?>"
						height="<?=CFile::_GetImgParams($arItem['PREVIEW_PICTURE']['ID'])['HEIGHT']?>"
						>
					</picture>
				</div>
				<div class="main__slider--title">
					<h2>
						<?=$arItem['NAME']?>
					</h2>
					<a href="<?=$arItem['PROPERTIES']['BUTTON_LINK']['VALUE']?>"
						class="btn btn__main--white main__slider--button">
						<?=$arItem['PROPERTIES']['BUTTON_TEXT']['VALUE']?>
					</a>
				</div>
			</div>
			<?endforeach;?>
		</div>
		<?if(count($arResult['ITEMS']) > 1):?>
		<div class="slider--arrow slider--arrow__prev main__slider--prev">
			<svg width="41" height="12" viewBox="0 0 41 12" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path
					d="M0.469669 5.46967C0.176777 5.76257 0.176777 6.23744 0.469669 6.53033L5.24264 11.3033C5.53553 11.5962 6.01041 11.5962 6.3033 11.3033C6.5962 11.0104 6.5962 10.5355 6.3033 10.2426L2.06066 6L6.3033 1.75736C6.59619 1.46447 6.59619 0.989596 6.3033 0.696702C6.01041 0.403809 5.53553 0.403809 5.24264 0.696702L0.469669 5.46967ZM41 5.25L1 5.25L1 6.75L41 6.75L41 5.25Z"
					fill="white" />
			</svg>
		</div>
		<div class="slider--arrow slider--arrow__next main__slider--next">
			<svg width="41" height="12" viewBox="0 0 41 12" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path
					d="M40.5303 5.46967C40.8232 5.76257 40.8232 6.23744 40.5303 6.53033L35.7574 11.3033C35.4645 11.5962 34.9896 11.5962 34.6967 11.3033C34.4038 11.0104 34.4038 10.5355 34.6967 10.2426L38.9393 6L34.6967 1.75736C34.4038 1.46447 34.4038 0.989596 34.6967 0.696702C34.9896 0.403809 35.4645 0.403809 35.7574 0.696702L40.5303 5.46967ZM6.55671e-08 5.25L40 5.25L40 6.75L-6.55671e-08 6.75L6.55671e-08 5.25Z"
					fill="white" />
			</svg>
		</div>
		<?endif;?>
	</div>
</div>