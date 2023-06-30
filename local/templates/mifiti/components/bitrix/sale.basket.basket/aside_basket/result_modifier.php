<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?
foreach($arResult['BASKET_ITEM_RENDER_DATA'] as $key => $arItem){
if(!$arItem['NOT_AVAILABLE']){
    if(\CCatalogSku::GetProductInfo($arItem['PRODUCT_ID'])){
        $element = \Bitrix\Iblock\Elements\ElementcatalogSkuTable::getList([
            'select' => ['ID', 'DETAIL_PICTURE', 'TSVET.ITEM', 'RAZMER.ITEM'],
            'filter' => [
                'ID' => $arItem['PRODUCT_ID'],
            ],
            "cache" => ["ttl" => 3600],
            ])->fetchObject();
            if($element){
                $arProperties = [
                    0 => [
                    'NAME' => $element->getTsvet() ? 'Цвет' : '',
                    'VALUE' => $element->getTsvet() ? $element->getTsvet()->getItem()->getValue() : ''
                    ],
                    1 => [
                    'NAME' => $element->getRazmer() ? 'Размер' : '',
                    'VALUE' => $element->getRazmer() ? $element->getRazmer()->getItem()->getValue() : ''
                    ],
                    2 => [
                    'NAME' => 'Количество',
                    'VALUE' => $arItem['QUANTITY']
                    ]
                ];
            $arResult['ITEMS'][$key]['PROPERTIES'] = $arProperties;
        }
    }
    // Если это не ТП
    else{
        $element = \Bitrix\Iblock\Elements\ElementcatalogTable::getList([
            'select' => ['ID', 'DETAIL_PICTURE'],
            'filter' => [
                'ID' => $arItem['PRODUCT_ID'],
            ],
            "cache" => ["ttl" => 3600],
            ])->fetchObject();
            if($element){
                $arProperties = [
                    0 => [
                    'NAME' => 'Количество',
                    'VALUE' => $arItem['QUANTITY']
                    ]
                ];
        }
    }
    if($element){
        $arProperties = [
            0 => [
            'NAME' => $element->getTsvet() ? 'Цвет' : '',
            'VALUE' => $element->getTsvet() ? $element->getTsvet()->getItem()->getValue() : ''
            ],
            1 => [
            'NAME' => $element->getRazmer() ? 'Размер' : '',
            'VALUE' => $element->getRazmer() ? $element->getRazmer()->getItem()->getValue() : ''
            ],
            2 => [
            'NAME' => 'Количество',
            'VALUE' => $arItem['QUANTITY']
            ]
        ];
    }
    $arResult['BASKET_ITEM_RENDER_DATA'][$key]['PROPS'] = $arProperties;
}
}
?>