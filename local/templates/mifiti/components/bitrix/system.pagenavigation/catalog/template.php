<?php

if (!defined('B_PROLOG_INCLUDED') || (B_PROLOG_INCLUDED !== true)) {
    die();
}

if (!$arResult["NavShowAlways"]) {
    if (
       (0 == $arResult["NavRecordCount"])
       ||
       ((1 == $arResult["NavPageCount"]) && (false == $arResult["NavShowAll"]))
    ) {
        return;
    }
}

$navQueryString      = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
$navQueryStringFull  = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");

?>
<div class="pager">
	<div class="container">
		<div class="row pager__items">
		<?if($arResult['NavPageNomer'] !== intval($arResult['nEndPage'])):?>
		<div class="pager__link"><a href="<?=$arResult['sUrlPath']?>?<?=$navQueryString?>PAGEN_<?=$arResult['NavNum']?>=<?=$arResult['NavPageNomer'] + 1?>" class="btn btn__main--black btn__main--black__bg section__link--button">Показать еще</a></div>
		<?endif;?>
		<?if($arResult['NavPageNomer']!== 1):?>
		<div class="pager__item pager__item--prev">
				<a href="<?=$arResult['sUrlPath']?>?<?=$navQueryString?>PAGEN_<?=$arResult['NavNum']?>=<?=$arResult['NavPageNomer'] - 1?>">
					<svg width="21" height="12" viewBox="0 0 21 12" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M0.46967 5.46967C0.176777 5.76256 0.176777 6.23744 0.46967 6.53033L5.24264 11.3033C5.53553 11.5962 6.01041 11.5962 6.3033 11.3033C6.59619 11.0104 6.59619 10.5355 6.3033 10.2426L2.06066 6L6.3033 1.75736C6.59619 1.46447 6.59619 0.989594 6.3033 0.6967C6.01041 0.403807 5.53553 0.403807 5.24264 0.696701L0.46967 5.46967ZM21 5.25L1 5.25L1 6.75L21 6.75L21 5.25Z" fill="#6B6364"></path>
					</svg>
				</a>
		</div>
		<?endif;?>
			<?while ($arResult['nStartPage'] <= $arResult["nEndPage"]):?>
				<?if($arResult['nStartPage'] == $arResult["NavPageNomer"]):?>
					<div class="pager__item active"><?=$arResult['nStartPage']?></div>
					<?else:?>
					<div class="pager__item"><a href="<?=$arResult['sUrlPath']?>?<?=$navQueryString?>PAGEN_<?=$arResult['NavNum']?>=<?=$arResult['nStartPage']?>"><?=$arResult['nStartPage']?></a></div>
				<?endif;?>
				<?$arResult["nStartPage"]++?>
			<?endwhile;?>
			<?if($arResult['NavPageNomer'] !== intval($arResult['NavPageCount'])):?>
			<div class="pager__item pager__item--next">
				<a href="<?=$arResult['sUrlPath']?>?<?=$navQueryString?>PAGEN_<?=$arResult['NavNum']?>=<?=$arResult['NavPageNomer'] + 1?>">
					<svg width="21" height="12" viewBox="0 0 21 12" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M20.5303 5.46967C20.8232 5.76256 20.8232 6.23744 20.5303 6.53033L15.7574 11.3033C15.4645 11.5962 14.9896 11.5962 14.6967 11.3033C14.4038 11.0104 14.4038 10.5355 14.6967 10.2426L18.9393 6L14.6967 1.75736C14.4038 1.46447 14.4038 0.989594 14.6967 0.6967C14.9896 0.403807 15.4645 0.403807 15.7574 0.696701L20.5303 5.46967ZM6.55671e-08 5.25L20 5.25L20 6.75L-6.55671e-08 6.75L6.55671e-08 5.25Z" fill="#6B6364"></path>
					</svg>
				</a>
			</div>
			<?endif;?>
		</div>
	</div>
</div>
