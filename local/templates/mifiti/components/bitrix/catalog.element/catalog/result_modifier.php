<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

if($arResult['PRODUCT']['USE_OFFERS']){
    foreach($arResult['OFFERS'] as $key => $arItem){
        // Картинки
            if($arItem['PROPERTIES']['MORE_PHOTO']['VALUE']){
            foreach($arResult['OFFERS'][$key]['PROPERTIES']['MORE_PHOTO']['VALUE'] as $key2 => $photo){
                $arResult['OFFERS'][$key]['PROPERTIES']['MORE_PHOTO']['DATA'][] = [
                    'SRC' => CFile::GetPath($photo),
                    'WIDTH' => CFile::_GetImgParams($photo)['WIDTH'],
                    'HEIGHT' => CFile::_GetImgParams($photo)['HEIGHT'],
                ];
                $thumbData = CFile::ResizeImageGet($photo, array("width"=>200, "height"=>200), BX_RESIZE_IMAGE_PROPORTIONAL_ALT);
                $arResult['OFFERS'][$key]['PROPERTIES']['MORE_PHOTO']['THUMBS'][] = [
                    'SRC' => $thumbData['src']
                ];
            }
            // Поместить детальную карточку в общий массив.
            if($arItem['DETAIL_PICTURE']){
                $arResult['OFFERS'][$key]['PROPERTIES']['MORE_PHOTO']['DATA'][] = [
                    'SRC' => $arItem['DETAIL_PICTURE']['SRC'],
                    'WIDTH' => $arItem['DETAIL_PICTURE']['WIDTH'],
                    'HEIGHT' => $arItem['DETAIL_PICTURE']['HEIGHT'],
                ];
                $thumbData = CFile::ResizeImageGet($arItem['DETAIL_PICTURE'], array("width"=>200, "height"=>200), BX_RESIZE_IMAGE_PROPORTIONAL_ALT);
                $arResult['OFFERS'][$key]['PROPERTIES']['MORE_PHOTO']['THUMBS'][] = [
                    'SRC' => $thumbData['src'],
                ];
            }
        }

        // SEO теги для торговых предложений.
        $arResult['OFFERS'][$key]['SEO'] = [
            'ELEMENT_PREVIEW_PICTURE_FILE_ALT' => $arResult['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_ALT'] ? $arResult['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_ALT'] : $arResult['OFFERS'][$key]['NAME'],
            'ELEMENT_PREVIEW_PICTURE_FILE_TITLE' => $arResult['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'] ? $arResult['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'] : $arResult['OFFERS'][$key]['NAME'],
            'ELEMENT_PREVIEW_PICTURE_FILE_NAME' => $arResult['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_NAME'] ? $arResult['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_NAME'] : $arResult['OFFERS'][$key]['NAME'],
            'ELEMENT_DETAIL_PICTURE_FILE_ALT' => $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'] ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'] : $arResult['OFFERS'][$key]['NAME'],
            'ELEMENT_DETAIL_PICTURE_FILE_TITLE' => $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'] ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'] : $arResult['OFFERS'][$key]['NAME'],
            'ELEMENT_DETAIL_PICTURE_FILE_NAME' => $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_NAME'] ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_NAME'] : $arResult['OFFERS'][$key]['NAME']
        ];
    }
}
elseif ($arResult['PROPERTIES']['MORE_PHOTO']['VALUE']) {
    foreach($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'] as $photo){
        $arResult['PROPERTIES']['MORE_PHOTO']['DATA'][] = [
            'WIDTH' => CFile::_GetImgParams($photo)['WIDTH'],
            'HEIGHT' => CFile::_GetImgParams($photo)['HEIGHT'],
            'SRC' => CFile::GetPath($photo)
        ];
        $arResult['PROPERTIES']['MORE_PHOTO']['THUMBS'][] = [
            'SRC' => CFile::ResizeImageGet($photo, array("width"=>200, "height"=>200), BX_RESIZE_IMAGE_PROPORTIONAL_ALT)['src']
        ];
    }
    // Поместить детальную карточку в общий массив.
    if($arResult['DETAIL_PICTURE']){
        $arResult['PROPERTIES']['MORE_PHOTO']['DATA'][] = [
            'SRC' => CFile::ResizeImageGet($arItem['DETAIL_PICTURE'], array("width"=>200, "height"=>200), BX_RESIZE_IMAGE_PROPORTIONAL_ALT)['src']
        ];
        $arResult['PROPERTIES']['MORE_PHOTO']['THUMBS'][] = [
            'SRC' => $arItem['DETAIL_PICTURE']['SRC']
        ];
    }
}
// Переносим буфер в эпилог
$this->__component->SetResultCacheKeys(array("CACHE_TMP"));
?>
<?//Динамичный link_back вне шаблона компонента?>
<?$this->SetViewTarget('link_back');?>
<div class="link__back">
            <div class="container">
                <a href="<?=$arResult['SECTION']['SECTION_PAGE_URL']?>">
                    <div class="row">
                        <div class="link__back--icon">
                            <svg width="21" height="12" viewBox="0 0 21 12" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M0.469669 5.46967C0.176777 5.76256 0.176777 6.23744 0.469669 6.53033L5.24264 11.3033C5.53553 11.5962 6.01041 11.5962 6.3033 11.3033C6.59619 11.0104 6.59619 10.5355 6.3033 10.2426L2.06066 6L6.3033 1.75736C6.59619 1.46447 6.59619 0.989594 6.3033 0.6967C6.01041 0.403807 5.53553 0.403807 5.24264 0.696701L0.469669 5.46967ZM21 5.25L1 5.25L1 6.75L21 6.75L21 5.25Z"
                                    fill="#1D1D1D" />
                            </svg>
                        </div>
                        <div class="link__back--title">Назад</div>
                    </div>
                </a>
            </div>
        </div>
<?$this->EndViewTarget();?>