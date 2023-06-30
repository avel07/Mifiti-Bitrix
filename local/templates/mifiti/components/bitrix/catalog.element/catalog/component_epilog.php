<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$arResult['CACHE_TMP'] = preg_replace_callback(
    "/#FAVORITES#/",
    function ($matches) use ($APPLICATION, $arParams, $arResult, $USER) {
         $favorite = \CatalogHelper\favorites::isFavorite($arResult['ID']) ? "active" : "";
         $returnStr = '<div class="catalog__element--info__basket--favorite '.$favorite.'" data-favorite="'.$arResult['ID'].'"><svg width="30" height="26" viewBox="0 0 30 26" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.1339 4.02526C15.6246 3.56348 16.0293 3.14514 16.4726 2.77105C21.1072 -1.13638 28.1619 1.36158 29.2528 7.31806C29.7186 9.86349 29.0251 12.1241 27.3019 14.0613C27.1884 14.1885 27.0661 14.3083 26.9463 14.429C23.2552 18.12 19.5642 21.8102 15.8732 25.5005C15.3543 26.0194 15.0196 26.0194 14.5007 25.4989C10.7928 21.7829 7.08248 18.0685 3.37698 14.3502C0.269211 11.2335 0.18313 6.45484 3.17103 3.29478C6.05836 0.242526 11.0688 0.092085 14.1443 2.97298C14.4879 3.29478 14.7912 3.65922 15.1331 4.02446L15.1339 4.02526Z" fill="none" stroke="white" /></svg></div>';
        return $returnStr;
    },
    $arResult['CACHE_TMP']
);
echo $arResult['CACHE_TMP'];
?>