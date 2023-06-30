<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?use Bitrix\Catalog\ProductTable;?>
<?use Bitrix\Main\Localization\Loc;?>
<?/** @var array $arParams */
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
<?ob_start();?>
<?$arItem = $arResult['PRODUCT']['USE_OFFERS'] ? $arResult['OFFERS'][$arResult['OFFER_ID_SELECTED']] : $arResult?>
<?$basePrice = $arItem['ITEM_PRICES'][$arResult['OFFER_ID_SELECTED']]['BASE_PRICE']?>
<?$price = $arItem['ITEM_PRICES'][$arResult['OFFER_ID_SELECTED']]['PRICE']?>
<?$isDiscount =  $basePrice > $price ? true : false?>
<?
$mainId = $this->GetEditAreaId($arResult['ID']);
// ID элементов, для последующего обращения в JS.
$itemIds = array(
	'ID' => $mainId,
	'DISCOUNT_PERCENT_ID' => $mainId.'_dsc_pict',
	'STICKER_ID' => $mainId.'_sticker',
	'BIG_SLIDER_ID' => $mainId.'_big_slider',
	'BIG_IMG_CONT_ID' => $mainId.'_bigimg_cont',
	'SLIDER_CONT_ID' => $mainId.'_slider_cont',
	'OLD_PRICE_ID' => $mainId.'_old_price',
	'PRICE_ID' => $mainId.'_price',
	'DESCRIPTION_ID' => $mainId.'_description',
	'DISCOUNT_PRICE_ID' => $mainId.'_price_discount',
	'PRICE_TOTAL' => $mainId.'_price_total',
	'SLIDER_CONT_OF_ID' => $mainId.'_slider_cont_',
	'QUANTITY_ID' => $mainId.'_quantity',
	'QUANTITY_DOWN_ID' => $mainId.'_quant_down',
	'QUANTITY_UP_ID' => $mainId.'_quant_up',
	'QUANTITY_MEASURE' => $mainId.'_quant_measure',
	'QUANTITY_LIMIT' => $mainId.'_quant_limit',
	'BUY_LINK' => $mainId.'_buy_link',
	'ADD_BASKET_LINK' => $mainId.'_add_basket_link',
	'BASKET_ACTIONS_ID' => $mainId.'_basket_actions',
	'NOT_AVAILABLE_MESS' => $mainId.'_not_avail',
	'COMPARE_LINK' => $mainId.'_compare_link',
	'TREE_ID' => $mainId.'_skudiv',
	'DISPLAY_PROP_DIV' => $mainId.'_sku_prop',
	'DISPLAY_MAIN_PROP_DIV' => $mainId.'_main_sku_prop',
	'OFFER_GROUP' => $mainId.'_set_group_',
	'BASKET_PROP_DIV' => $mainId.'_basket_prop',
	'SUBSCRIBE_LINK' => $mainId.'_subscribe',
	'TABS_ID' => $mainId.'_tabs',
	'TAB_CONTAINERS_ID' => $mainId.'_tab_containers',
	'SMALL_CARD_PANEL_ID' => $mainId.'_small_card_panel',
	'TABS_PANEL_ID' => $mainId.'_tabs_panel'
);
?>
<?// Если товар с ТП?>
        <div class="catalog" id="<?=$itemIds['ID']?>">
            <div class="container container__nopadding-sm">
            <?if($arResult['PRODUCT']['USE_OFFERS']):?>
                <div class="catalog__element row" itemscope itemtype="https://schema.org/Product">
                    <div class="position__sticky col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <div class="catalog__element--gallery">
                            <div class="catalog__element--gallery__thumbs">
                                <div class="swiper swiper-vertical">
                                <div class="swiper-wrapper catalog__element--gallery__thumbs--wrapper">
                                <?if($arItem['PROPERTIES']['MORE_PHOTO']['VALUE']):?>
                                    <?if(count($arItem['PROPERTIES']['MORE_PHOTO']['VALUE']) > 1):?>
                                        <?foreach($arItem['PROPERTIES']['MORE_PHOTO']['THUMBS'] as $thumb):?>
                                        <div class="swiper-slide catalog__element--gallery__thumb">
											<img itemprop="image" src="<?=$thumb['SRC']?>" alt="<?=$arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'] ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'] : $arResult['NAME']?>" title="<?=$arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'] ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'] : $arResult['NAME']?>"
											width="200" height="133"
											>
                                        </div>
                                        <?endforeach;?>
                                    <?endif;?>
                                <?endif;?>
                                </div>
                                    <?if($arItem['PROPERTIES']['MORE_PHOTO']['THUMBS']):?>
                                    <?if(count($arItem['PROPERTIES']['MORE_PHOTO']['THUMBS']) >= 5):?>
                                    <div class="catalog__element--gallery__prev">
                                        <svg width="29" height="14" viewBox="0 0 29 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M28.4286 13L14.7143 1L1.00002 13" stroke="#1D1D1D"/>
                                        </svg>
                                        <div class="background__gradient"></div>
                                    </div>
                                    <div class="catalog__element--gallery__next">
                                        <svg width="29" height="14" viewBox="0 0 29 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L14.7143 13L28.4286 1" stroke="#1D1D1D"/>
                                        </svg>
                                        <div class="background__gradient"></div>
                                    </div>
                                    <?endif;?>
                                    <?endif;?>
                            </div>
                            </div>
                            <div class="catalog__element--gallery__images">
                                <div class="swiper">
                                <div class="swiper-wrapper">
                                    <?if($arItem['PROPERTIES']['MORE_PHOTO']['VALUE']):?>
                                    <?foreach($arItem['PROPERTIES']['MORE_PHOTO']['DATA'] as $photo):?>
                                    <div class="swiper-slide catalog__element--gallery__image">
                                        <a href="<?=$photo['SRC']?>" data-fancybox="gallery">
                                            <img itemprop="image" src="<?=$photo['SRC']?>" alt="<?=$arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'] ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'] : $arResult['NAME']?>" title="<?=$arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'] ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'] : $arResult['NAME']?>"
											width="<?=$photo['WIDTH']?>"
											height="<?=$photo['HEIGHT']?>"
											>
                                        </a>
                                    </div>
                                    <?endforeach;?>
                                    <?else:?>
                                    <div class="swiper-slide catalog__element--gallery__image">
                                        <img src="<?=SITE_TEMPLATE_PATH?>/img/empty_photo_big.svg" alt="Пустое фото"
                                        width="279"
                                        height="382"
                                        >
                                    </div>
                                    <?endif;?>
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <div class="catalog__element--info">
                        <div class="catalog__element--info__head">
                            <!-- <div class="catalog__element--info__stickers">
                                <div class="catalog__item--sticker catalog__item--sticker__new">
                                    NEW
                                </div>
                                <div class="catalog__item--sticker catalog__item--sticker__sale">
                                    SALE
                                </div>
                            </div> -->
                            <div class="catalog__element--info__title">
                                <h1 itemprop="name"><?=$arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] ? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] : $arResult['NAME']?></h1>
                            </div>
                            <div class="catalog__element--info__subtitle">
							<meta itemprop="mpn" content="<?=$arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']?>"/>
                                АРТИКУЛ. <?=$arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']?>
                            </div>
                                <div class="catalog__element--info__prices" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                <?if($arItem['ITEM_PRICES']):?>
									<meta itemprop="priceCurrency" content="RUB"/>
                                    <?if($isDiscount):?>
                                    <div class="catalog__element--info__price price__old">
                                        <?=$basePrice?> р.
                                    </div>
                                    <div class="catalog__element--info__price price__discount" itemprop="price" content="<?=$price?>">
                                        <?=$price?> р.
                                    </div>
                                    <?else:?>
                                    <div class="catalog__element--info__price catalog__item--price" itemprop="price" content="<?=$basePrice?>">
                                        <?=$basePrice?> р.
                                    </div>
                                    <?endif;?>
                                <?endif;?>
                                </div>
                        </div>
                        <div class="catalog__element--info__body">
                            <?if($arResult['SKU_PROPS']):?>
                            <div class="catalog__element--info__sku" id="<?=$itemIds['TREE_ID']?>">
                                <?foreach($arResult['SKU_PROPS']  as $key => $arSkuProp):?>
									<?if (!isset($arResult['OFFERS_PROP'][$arSkuProp['CODE']]))
														continue;
													$propertyId = $arSkuProp['ID'];
													$skuProps[] = array(
														'ID' => $propertyId,
														'SHOW_MODE' => $arSkuProp['SHOW_MODE'],
														'VALUES' => $arSkuProp['VALUES'],
														'VALUES_COUNT' => $arSkuProp['VALUES_COUNT']
													);?>
                                <div class="catalog__element--info__sku--property">
                                    <div class="catalog__element--info__sku--property__title">
                                        <?=$arSkuProp['NAME']?>
                                    </div>
                                    <div class="catalog__element--info__sku--property__properties" data-entity="sku-line-block">
                                        <?foreach($arSkuProp['VALUES'] as $skuValue):?>
                                            <?if(!$skuValue['NA']):?>
                                                <button type="button" class="catalog__element--info__sku--property__item<?=$arItem['TREE']['PROP_'.$arSkuProp['ID']] == $skuValue['ID'] ? ' active' : ''?>" data-treevalue="<?=$propertyId?>_<?=$skuValue['ID']?>" data-onevalue="<?=$skuValue['ID']?>"><?=$skuValue['NAME']?></button>
                                            <?endif;?>
                                        <?endforeach;?>
                                    </div>  
                                </div>   
                                <?endforeach;?>
                            </div>
                            <?endif;?>
                            <div class="catalog__element--info__basket">
                                <div class="catalog__element--info__basket--quantity">
                                    <button type="button" class="quantity__minus">
                                        -
                                    </button>
                                    <input type="text" class="quantity__input" aria-label="quantity_change" data-quantity="<?=$arItem['ID']?>" readonly value="1">
                                    <button type="button" class="quantity__plus">
                                        +
                                    </button>
                                </div>
                                <div class="catalog__element--info__basket--add">
                                    <button type="button" class="btn basket__item--add hover__effect--black" data-basket="<?=$arItem['ID']?>" data-quantity="1">В корзину</button>
                                </div>
                                #FAVORITES#
                            </div>
                        </div>
                        <div class="catalog__element--info__descriptions">
                                <div class="catalog__element--info__description--title collapsed" data-toggle="collapse" data-target="next">
                                    Описание
                                    <div class="catalog__element--info__description--title__icon">
                                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <line x1="12.2646" y1="2.18556e-08" x2="12.2646" y2="25" stroke="#8B8486"/>
                                            <line y1="12.7354" x2="25" y2="12.7354" stroke="#8B8486"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="catalog__element--info__description--body collapse show" itemprop="description">
                                    <?=$arResult['PREVIEW_TEXT']?>
                                </div>
                                <div class="catalog__element--info__description--title" data-toggle="collapse" data-target="next">
                                    Характеристики
                                    <div class="catalog__element--info__description--title__icon">
                                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <line x1="12.2646" y1="2.18556e-08" x2="12.2646" y2="25" stroke="#8B8486"/>
                                            <line y1="12.7354" x2="25" y2="12.7354" stroke="#8B8486"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="catalog__element--info__description--body collapse">
                                    Эффектное платье длины миди прилегающего силуэта, выполненное из приятного к телу плотного материала. Модель имеет глубокий фигурный вырез на тонких бретелях, переходящих в шнуровку на спинке, а также прямую юбку с высоким боковым разрезом. длина миди прилегающий силуэт фигурный вырез регулируемые бретели прямая юбка с разрезом шнуровка на спинке
                                    Эффектное платье длины миди прилегающего силуэта, выполненное из приятного к телу плотного материала. Модель имеет глубокий фигурный вырез на тонких бретелях, переходящих в шнуровку на спинке, а также прямую юбку с высоким боковым разрезом. длина миди прилегающий силуэт фигурный вырез регулируемые бретели прямая юбка с разрезом шнуровка на спинке
                                    Эффектное платье длины миди прилегающего силуэта, выполненное из приятного к телу плотного материала. Модель имеет глубокий фигурный вырез на тонких бретелях, переходящих в шнуровку на спинке, а также прямую юбку с высоким боковым разрезом. длина миди прилегающий силуэт фигурный вырез регулируемые бретели прямая юбка с разрезом шнуровка на спинке
                                 </div>
                                <div class="catalog__element--info__description--title" data-toggle="collapse" data-target="next">
                                    Доставка и оплата
                                    <div class="catalog__element--info__description--title__icon">
                                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <line x1="12.2646" y1="2.18556e-08" x2="12.2646" y2="25" stroke="#8B8486"/>
                                            <line y1="12.7354" x2="25" y2="12.7354" stroke="#8B8486"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="catalog__element--info__description--body collapse">
                                    Эффектное платье длины миди прилегающего силуэта, выполненное из приятного к телу плотного материала. Модель имеет глубокий фигурный вырез на тонких бретелях, переходящих в шнуровку на спинке, а также прямую юбку с высоким боковым разрезом. длина миди прилегающий силуэт фигурный вырез регулируемые бретели прямая юбка с разрезом шнуровка на спинке
                                    Эффектное платье длины миди прилегающего силуэта, выполненное из приятного к телу плотного материала. Модель имеет глубокий фигурный вырез на тонких бретелях, переходящих в шнуровку на спинке, а также прямую юбку с высоким боковым разрезом. длина миди прилегающий силуэт фигурный вырез регулируемые бретели прямая юбка с разрезом шнуровка на спинке
                                </div>
                        </div>
                    </div>
                </div>
                </div>
				<?// ТОВАР БЕЗ ТП?>
                <?else:?>
                <div class="catalog__element row" itemscope itemtype="https://schema.org/Product">
                    <div class="position__sticky col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <div class="catalog__element--gallery">
                            <div class="catalog__element--gallery__thumbs">
                                <div class="swiper">
                                <div class="swiper-wrapper catalog__element--gallery__thumbs--wrapper">
                                <?if($arItem['PROPERTIES']['MORE_PHOTO']['VALUE']):?>
                                    <?if(count($arItem['PROPERTIES']['MORE_PHOTO']['VALUE']) > 1):?>
                                        <?foreach($arItem['PROPERTIES']['MORE_PHOTO']['THUMBS'] as $thumb):?>
                                        <div class="swiper-slide catalog__element--gallery__thumb">
											<img itemprop="image" src="<?=$thumb?>" alt="<?=$arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'] ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'] : $arResult['NAME']?>" title="<?=$arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'] ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'] : $arResult['NAME']?>">
                                        </div>
                                        <?endforeach;?>
                                    <?endif;?>
                                <?endif;?>
                                </div>
                                <?if($arItem['PROPERTIES']['MORE_PHOTO']['THUMBS']):?>
                                <?if(count($arItem['PROPERTIES']['MORE_PHOTO']['THUMBS']) >= 5):?>
                                <div class="catalog__element--gallery__prev">
                                    <svg width="29" height="14" viewBox="0 0 29 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M28.4286 13L14.7143 1L1.00002 13" stroke="#1D1D1D"/>
                                    </svg>
                                    <div class="background__gradient"></div>
                                </div>
                                <div class="catalog__element--gallery__next">
                                    <svg width="29" height="14" viewBox="0 0 29 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L14.7143 13L28.4286 1" stroke="#1D1D1D"/>
                                    </svg>
                                    <div class="background__gradient"></div>
                                </div>
                                <?endif;?>
                                <?endif;?>
                            </div>
                            </div>
                            <div class="catalog__element--gallery__images">
                                <div class="swiper">
                                <div class="swiper-wrapper">
                                    <?if($arItem['PROPERTIES']['MORE_PHOTO']['VALUE']):?>
                                    <?foreach($arItem['PROPERTIES']['MORE_PHOTO']['SRC'] as $photo):?>
                                    <div class="swiper-slide catalog__element--gallery__image">
									<img itemprop="image" src="<?=$photo?>" alt="<?=$arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'] ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'] : $arResult['NAME']?>" title="<?=$arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'] ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'] : $arResult['NAME']?>">
                                    </div>
                                    <?endforeach;?>
                                    <?else:?>
                                    <div class="swiper-slide catalog__element--gallery__image">
                                        <img src="<?=SITE_TEMPLATE_PATH?>/img/empty_photo_big.svg" alt="Пустое фото"
                                        width="279"
                                        height="382"
                                        >
                                    </div>
                                    <?endif;?>
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <div class="catalog__element--info">
                        <div class="catalog__element--info__head">
                            <!-- <div class="catalog__element--info__stickers">
                                <div class="catalog__item--sticker catalog__item--sticker__new">
                                    NEW
                                </div>
                                <div class="catalog__item--sticker catalog__item--sticker__sale">
                                    SALE
                                </div>
                            </div> -->
                            <div class="catalog__element--info__title" itemprop="name">
                                <h1><?=$arResult['NAME']?></h1>
                            </div>
                            <div class="catalog__element--info__subtitle">
                                АРТИКУЛ. <?=$arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']?>
                            </div>
                                <div class="catalog__element--info__prices" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                <?if($arItem['ITEM_PRICES']):?>
									<meta itemprop="priceCurrency" content="RUB"/>
                                    <?if($isDiscount):?>
                                    <div class="catalog__element--info__price price__old">
                                        <?=$basePrice?> р.
                                    </div>
                                    <div class="catalog__element--info__price price__discount" itemprop="price" content="<?=$price?>">
                                        <?=$price?> р.
                                    </div>
                                    <?else:?>
                                    <div class="catalog__element--info__price catalog__item--price" itemprop="price" content="<?=$basePrice?>">
                                        <?=$basePrice?> р.
                                    </div>
                                    <?endif;?>
                                <?endif;?>
                                </div>
                        </div>
                        <div class="catalog__element--info__body">
                            <?if($arResult['SKU_PROPS']):?>
                            <div class="catalog__element--info__sku" id="<?=$itemIds['TREE_ID']?>">
                                <?foreach($arResult['SKU_PROPS']  as $key => $arSkuProp):?>
									<?if (!isset($arResult['OFFERS_PROP'][$arSkuProp['CODE']]))
														continue;
													$propertyId = $arSkuProp['ID'];
													$skuProps[] = array(
														'ID' => $propertyId,
														'SHOW_MODE' => $arSkuProp['SHOW_MODE'],
														'VALUES' => $arSkuProp['VALUES'],
														'VALUES_COUNT' => $arSkuProp['VALUES_COUNT']
													);?>
                                <div class="catalog__element--info__sku--property">
                                    <div class="catalog__element--info__sku--property__title">
                                        <?=$arSkuProp['NAME']?>
                                    </div>
                                    <div class="catalog__element--info__sku--property__properties" data-entity="sku-line-block">
                                        <?foreach($arSkuProp['VALUES'] as $skuValue):?>
                                            <?if(!$skuValue['NA']):?>
                                                <button type="button" class="catalog__element--info__sku--property__item<?=$arItem['TREE']['PROP_'.$arSkuProp['ID']] == $skuValue['ID'] ? ' active' : ''?>" data-treevalue="<?=$propertyId?>_<?=$skuValue['ID']?>" data-onevalue="<?=$skuValue['ID']?>"><?=$skuValue['NAME']?></button>
                                            <?endif;?>
                                        <?endforeach;?>
                                    </div>  
                                </div>   
                                <?endforeach;?>
                            </div>
                            <?endif;?>
                            <div class="catalog__element--info__basket">
                                <div class="catalog__element--info__basket--quantity">
                                    <button type="button" class="quantity__minus">
                                        -
                                    </button>
                                    <input type="text" class="quantity__input" aria-label="quantity_change" data-quantity="<?=$arItem['ID']?>" readonly value="1">
                                    <button type="button" class="quantity__plus">
                                        +
                                    </button>
                                </div>
                                <div class="catalog__element--info__basket--add">
                                    <button type="button" class="btn basket__item--add hover__effect--black" data-basket="<?=$arItem['ID']?>" data-quantity="1">В корзину</button>
                                </div>
                                #FAVORITES#
                            </div>
                        </div>
                        <div class="catalog__element--info__descriptions">
                                <div class="catalog__element--info__description--title collapsed" data-toggle="collapse" data-target="next">
                                    Описание
                                    <div class="catalog__element--info__description--title__icon">
                                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <line x1="12.2646" y1="2.18556e-08" x2="12.2646" y2="25" stroke="#8B8486"/>
                                            <line y1="12.7354" x2="25" y2="12.7354" stroke="#8B8486"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="catalog__element--info__description--body collapse show" itemprop="description">
                                    <?=$arResult['PREVIEW_TEXT']?>
                                </div>
                                <div class="catalog__element--info__description--title" data-toggle="collapse" data-target="next">
                                    Характеристики
                                    <div class="catalog__element--info__description--title__icon">
                                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <line x1="12.2646" y1="2.18556e-08" x2="12.2646" y2="25" stroke="#8B8486"/>
                                            <line y1="12.7354" x2="25" y2="12.7354" stroke="#8B8486"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="catalog__element--info__description--body collapse">
                                    Эффектное платье длины миди прилегающего силуэта, выполненное из приятного к телу плотного материала. Модель имеет глубокий фигурный вырез на тонких бретелях, переходящих в шнуровку на спинке, а также прямую юбку с высоким боковым разрезом. длина миди прилегающий силуэт фигурный вырез регулируемые бретели прямая юбка с разрезом шнуровка на спинке
                                    Эффектное платье длины миди прилегающего силуэта, выполненное из приятного к телу плотного материала. Модель имеет глубокий фигурный вырез на тонких бретелях, переходящих в шнуровку на спинке, а также прямую юбку с высоким боковым разрезом. длина миди прилегающий силуэт фигурный вырез регулируемые бретели прямая юбка с разрезом шнуровка на спинке
                                    Эффектное платье длины миди прилегающего силуэта, выполненное из приятного к телу плотного материала. Модель имеет глубокий фигурный вырез на тонких бретелях, переходящих в шнуровку на спинке, а также прямую юбку с высоким боковым разрезом. длина миди прилегающий силуэт фигурный вырез регулируемые бретели прямая юбка с разрезом шнуровка на спинке
                                 </div>
                                <div class="catalog__element--info__description--title" data-toggle="collapse" data-target="next">
                                    Доставка и оплата
                                    <div class="catalog__element--info__description--title__icon">
                                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <line x1="12.2646" y1="2.18556e-08" x2="12.2646" y2="25" stroke="#8B8486"/>
                                            <line y1="12.7354" x2="25" y2="12.7354" stroke="#8B8486"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="catalog__element--info__description--body collapse">
                                    Эффектное платье длины миди прилегающего силуэта, выполненное из приятного к телу плотного материала. Модель имеет глубокий фигурный вырез на тонких бретелях, переходящих в шнуровку на спинке, а также прямую юбку с высоким боковым разрезом. длина миди прилегающий силуэт фигурный вырез регулируемые бретели прямая юбка с разрезом шнуровка на спинке
                                    Эффектное платье длины миди прилегающего силуэта, выполненное из приятного к телу плотного материала. Модель имеет глубокий фигурный вырез на тонких бретелях, переходящих в шнуровку на спинке, а также прямую юбку с высоким боковым разрезом. длина миди прилегающий силуэт фигурный вырез регулируемые бретели прямая юбка с разрезом шнуровка на спинке
                                </div>
                        </div>
                    </div>
                </div>
                </div>
                <?endif;?>
            </div>
        </div>
<?
$obName = 'ob'.preg_replace('/[^a-zA-Z0-9_]/', 'x', $mainId);
?>
<?php
	$jsParams = array(
		'CONFIG' => array(),
		'PRODUCT_TYPE' => $arResult['PRODUCT']['TYPE'],
		'VISUAL' => $itemIds,
		'OFFERS' => $arResult['OFFERS'],
		'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],
		'TREE_PROPS' => $skuProps,
		'MAIN_BLOCK_OFFERS_PROPERTY_CODE' => $arParams['MAIN_BLOCK_OFFERS_PROPERTY_CODE']
	);
?>
<script>
	var <?=$obName?> = new JCCatalogElement(<?=CUtil::PhpToJSObject($jsParams, false, true)?>);
</script>
<?php
unset($itemIds, $jsParams);
?>
<?// Если товар без ТП?>
<?$arResult['CACHE_TMP'] = @ob_get_clean();?>