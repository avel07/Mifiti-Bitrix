<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();?>
<?
if (!empty($arResult)) {
    $parentID = false;
    $subParentID = false;
    foreach($arResult as $i => $arItem) {
        if ($arItem['DEPTH_LEVEL'] == 1) {
            $parentID = $i;
            $arResult[$i]['CHILDREN'] = array();
        } elseif ($arItem['DEPTH_LEVEL']==2 && $parentID!==false) {
            $arResult[$parentID]['CHILDREN'][$i] = $arItem;
            $subParentID = $i;
            unset($arResult[$i]);
        } elseif ($arItem['DEPTH_LEVEL']==3 && isset($arResult[$parentID]['CHILDREN'][$subParentID])) {
            if (!isset($arResult[$parentID]['CHILDREN'][$subParentID]['CHILDREN'])) {
                $arResult[$parentID]['CHILDREN'][$subParentID]['CHILDREN'] = array();
            }
            $arResult[$parentID]['CHILDREN'][$subParentID]['CHILDREN'][] = $arItem;
            unset($arResult[$i]);
        }
    }
    $arResult = array_values($arResult);
}