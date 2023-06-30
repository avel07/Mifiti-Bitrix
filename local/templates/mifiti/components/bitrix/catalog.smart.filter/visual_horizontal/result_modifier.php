<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
foreach($arResult["ITEMS"] as $key=>$arItem){
    if(isset($arItem["PRICE"])){
        if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0) continue;
        $minValue = intval($arItem['VALUES']['MIN']['VALUE']);
        $minHtmlValue = intval($arItem['VALUES']['MIN']['HTML_VALUE']);
        $maxValue = intval($arItem['VALUES']['MAX']['VALUE']);
        $maxHtmlValue = intval($arItem['VALUES']['MAX']['HTML_VALUE']);
        if(($minHtmlValue > 0 && $maxHtmlValue > 0) && ($minValue !== $minHtmlValue || $maxValue !== $maxHtmlValue)){
            $arResult['CHECKED_ITEMS']['PRICES'] = $arItem['VALUES'];
        }
    }
    if(empty($arItem["VALUES"])|| isset($arItem["PRICE"])) continue;
    if($arItem["DISPLAY_TYPE"] == "A"&& ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)) continue;
        switch ($arItem["DISPLAY_TYPE"]){
            case 'A':
                break;
            case 'B':
                break;
            default://Показываем только чекбоксы
                foreach($arItem['VALUES'] as $key2 => $arValue)
                {
                    if($arValue['CHECKED']){
                    $arResult['CHECKED_ITEMS'][$key][] = $arValue;
                    }
                }
        }
    }
?>