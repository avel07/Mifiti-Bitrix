<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?
/**
 * @var array $arParams
 * @var array $arResult
 * @var string $templateFolder
 * @var string $templateName
 * @var CMain $APPLICATION
 * @var CBitrixBasketComponent $component
 * @var CBitrixComponentTemplate $this
 * @var array $giftParameters
 */
?>
<div class="header__basket--icon">
	<svg width="37" height="30" viewBox="0 0 37 30" fill="none" xmlns="http://www.w3.org/2000/svg">
		<path
			d="M10.1741 24.6279C7.65672 23.8862 7.25499 20.6371 8.99434 19.2719C8.99213 19.2465 8.99875 19.2101 8.98551 19.1979C7.80902 18.1616 7.54304 16.7666 7.37418 15.2999C7.00226 12.0607 6.59832 8.82478 6.15686 5.59331C5.87212 3.50411 3.98931 1.87623 1.87693 1.79346C1.53259 1.78021 1.18825 1.79787 0.843918 1.78132C0.334034 1.75814 0.0194948 1.43808 0.000732882 0.948064C-0.0169254 0.434869 0.285473 0.0905316 0.804186 0.036453C3.76306 -0.27036 6.50672 1.3818 7.59381 4.15415C7.71852 4.472 7.91387 4.42896 8.13901 4.42896C16.8159 4.42896 25.4927 4.42896 34.1685 4.42896C34.7744 4.42896 35.3803 4.42344 35.9862 4.43006C36.7654 4.43779 37.1439 4.94878 36.911 5.69594C35.7191 9.5289 34.5316 13.363 33.3198 17.1893C32.7073 19.124 31.0661 20.2905 29.0156 20.2916C23.0658 20.2961 17.1161 20.2916 11.1663 20.2939C10.215 20.2939 9.66204 20.8181 9.69405 21.68C9.71943 22.3632 10.2006 22.8731 10.8838 22.9316C11.0339 22.9448 11.1862 22.9382 11.3385 22.9382C17.7981 22.9382 24.2566 22.936 30.7163 22.9404C32.4313 22.9404 33.8341 24.0021 34.2347 25.5792C34.7236 27.5029 33.5537 29.4376 31.6268 29.8889C29.6921 30.3425 27.8082 29.1407 27.3822 27.1839C27.2188 26.4323 27.2817 25.7083 27.6172 25.0108C27.657 24.9292 27.6857 24.842 27.7342 24.7195H16.2629C16.8037 25.7359 16.8677 26.7458 16.4439 27.7699C16.1349 28.5171 15.6394 29.1153 14.9408 29.5281C13.6495 30.2929 11.9687 30.1108 10.8716 29.1076C9.88939 28.2092 9.12567 26.429 10.1719 24.6279H10.1741ZM34.909 6.21576H8.05955C8.05955 6.34158 8.04962 6.43759 8.06065 6.5314C8.46238 9.72535 8.863 12.9193 9.27025 16.1121C9.46228 17.612 10.5207 18.5357 12.0614 18.5369C17.6933 18.5413 23.3252 18.5402 28.956 18.5369C30.3366 18.5369 31.2714 17.8393 31.6853 16.5194C32.2978 14.5659 32.9059 12.6103 33.5162 10.6557C33.9753 9.18898 34.4367 7.72224 34.909 6.21576ZM30.82 24.736C29.8014 24.7371 29.0553 25.4722 29.0597 26.4687C29.0641 27.4565 29.83 28.2081 30.83 28.2048C31.8365 28.2015 32.5892 27.4532 32.5881 26.4588C32.5859 25.4556 31.8453 24.7349 30.82 24.736ZM13.1794 24.736C12.1574 24.7426 11.4257 25.4722 11.4334 26.4787C11.4411 27.472 12.207 28.2158 13.2092 28.2048C14.2124 28.1937 14.9706 27.4333 14.9606 26.4489C14.9507 25.4501 14.2002 24.7294 13.1794 24.736Z"
			fill="#1D1D1D" />
	</svg>
</div>
<div class="header__basket--close">
	<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
		<path d="M1.0002 30.9991L30.9993 1" stroke="white" stroke-width="1.5" stroke-linecap="round" />
		<path d="M1.0002 1.00093L30.9993 31" stroke="white" stroke-width="1.5" stroke-linecap="round" />
	</svg>
</div>
<div class="header__basket--title">
	<span>Моя корзина</span>
</div>
    <div class="header__basket--body" data-scrolled="up">
                <div class="header__basket--items">
                <?if(!$arResult['EMPTY_BASKET']):?>
                    <?foreach($arResult['BASKET_ITEM_RENDER_DATA'] as $key => $arItem):?>
                <div class="header__basket--item show">
                        <div class="header__basket--item__image">
                            <img src="<?=$arItem['IMAGE_URL'] ? $arItem['IMAGE_URL'] : SITE_TEMPLATE_PATH.'/img/empty_photo.svg' ;?>" alt="<?=$arItem['NAME']?>">
                        </div>
                        <div class="header__basket--item__body">
                            <div class="header__basket--item__body--title">
                                <div class="header__basket--item__body--name">
                                    <a href="<?=$arItem['DETAIL_PAGE_URL']?>"><span><?=$arItem['NAME']?></span></a>
                                </div>
                                <div class="header__basket--item__body--delete" data-id="<?=$arItem['ID']?>">
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1.00007 10.9997L10.9998 1" stroke="#1D1D1D" stroke-linecap="round" />
                                        <path d="M1.00007 1.00031L10.9998 11" stroke="#1D1D1D" stroke-linecap="round" />
                                    </svg>
                                </div>
                            </div>
                            <div class="header__basket--item__body--properties">
                            <?if($arItem['NOT_AVAILABLE']):?>
                                <div class="header__basket--item__body--property error">
                                    Товар недоступен!!!
                                </div>
                            <?else:?>
                                <?foreach($arItem['PROPS'] as $arProperty):?>
                                <div class="header__basket--item__body--property">
                                    <div class="header__basket--item__body--property__name"><?=$arProperty['NAME']?></div>
                                    <div class="header__basket--item__body--property__value"><?=$arProperty['VALUE']?></div>
                                </div>
                            <?endforeach;?>
                            <?endif;?>
                            </div>
                            <div class="header__basket--item__body--prices">
                                <div class="header__basket--item__body--price <?=$arItem['SHOW_DISCOUNT_PRICE'] ? 'price__old' : '';?>">
                                <?=$arItem['FULL_PRICE']?> р.
                                </div>
                                <?if($arItem['SHOW_DISCOUNT_PRICE']):?>
                                    <div class="header__basket--item__body--price price__discount">
                                    <?=$arItem['PRICE']?> р.
                                    </div>
                                <?endif;?>
                            </div>
                        </div>
                    </div>
                    <?endforeach;?>
                <?else:?>
                    <h3><?=$arResult['ERROR_MESSAGE']?></h3>
                <?endif;?>
                </div>
            </div>
            <div class="header__basket--order <?=$arResult['EMPTY_BASKET'] ? 'hide' : '';?>">
                <div class="header__basket--order__info">
                    <div class="header__basket--order__title">
                        Итого:
                    </div>
                    <div class="header__basket--order__value">
                        <?=$arResult['TOTAL_RENDER_DATA']['PRICE']?> р.
                    </div>
                </div>
                <a href="/personal/order/make/">
                    <div class="header__basket--order__button">
                        Оформить заказ
                    </div>
                </a>
            </div>