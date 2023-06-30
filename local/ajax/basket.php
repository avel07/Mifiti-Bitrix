<?require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");?>
<?
$postData = \Bitrix\Main\Application::getInstance()->getContext()->getRequest(); // Получаем запрос.
try {
    $data = \Bitrix\Main\Web\Json::decode($postData->getInput()); // Если это json, то он его декодирует.
    Bitrix\Main\Loader::includeModule("catalog");
    Bitrix\Main\Loader::includeModule("sale");
    Bitrix\Main\Loader::includeModule("iblock");
} catch (Exception $e) {
    echo \Bitrix\Main\Web\Json::encode($arResult[] = $e->getMessage()); // Иначе выведет ошибку
    return false;
}
$arResult['status'] = false;
function addBasketItem($id, $quantity){
    global $arResult;
    $addItem = \BasketHelper\Basket::addItem($id, $quantity);
    $item = CCatalogSku::GetProductInfo($id) ? \Bitrix\Iblock\Elements\ElementcatalogSkuTable::getById($id)->fetch() : \Bitrix\Iblock\Elements\ElementCatalogTable::getById($id)->fetch();
    if($addItem){
        $arResult['status'] = true;
        $arResult['text'] = $item['NAME'].' - успешно добавлен в корзину';
    }
    else{
        $arResult['text'] = 'Произошла ошибка, элемент '.$item['NAME'].' не добавлен в корзину';
    }
    return $arResult;
}
function deleteBasketItem($id){
    global $arResult;
    $deleteItem = \BasketHelper\Basket::deleteItem($id);
    $item = CCatalogSku::GetProductInfo($id) ? \Bitrix\Iblock\Elements\ElementcatalogSkuTable::getById($id)->fetch() : \Bitrix\Iblock\Elements\ElementCatalogTable::getById($id)->fetch();
    if($deleteItem){
        $arResult['status'] = true;
        $arResult['text'] = 'Элемент - '.$item['NAME'].' успешно удален из корзины';
    }
    else{
        $arResult['text'] = 'Ошибка удаления '.$item['NAME'].' - из корзины';
    }
}
function getBasketData(){
    global $arResult;
    $basket = \BasketHelper\Basket::getInfo();
    $basketItems = $basket->getOrderableItems();
    $arResult['BASKET'] = [
        'PRICE' => $basket->getPrice(),
        'BASE_PRICE' => $basket->getBasePrice(),
        'QUANTITY' => count($basket->getQuantityList()),
        'QUANTITY_LIST' => $basket->getQuantityList(),
        'SALE' => $basket->getBasePrice() > $basket->getPrice()
    ];
    foreach ($basketItems as $key => $basketItem) {
        // Если это ТП
        if(\CCatalogSku::GetProductInfo($basketItem->getProductId())){
            $element = \Bitrix\Iblock\Elements\ElementcatalogSkuTable::getList([
                'select' => ['ID', 'DETAIL_PICTURE', 'TSVET.ITEM', 'RAZMER.ITEM'],
                'filter' => [
                    'ID' => $basketItem->getProductId(),
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
                        'VALUE' => $basketItem->getQuantity()
                        ]
                    ];
                $arResult['BASKET']['ITEMS'][$key] = [
                    'ID' => $basketItem->getId(),
                    'NAME' => $basketItem->getField('NAME'),
                    'URL' => $basketItem->getField('DETAIL_PAGE_URL'),
                    'PRICE' => $basketItem->getPrice(),
                    'BASE_PRICE' => $basketItem->getBasePrice(),
                    'SALE' => $basketItem->getBasePrice() > $basketItem->getPrice(),
                    'PICTURE' => $element->getDetailPicture() ? CFile::ResizeImageGet($element->getDetailPicture(), Array("width" => 160, "height" => 160), BX_RESIZE_IMAGE_PROPORTIONAL)['src'] : '',
                    'PROPERTIES' => $arProperties
                ];
            }
        }
        // Если это не ТП
        else{
            $element = \Bitrix\Iblock\Elements\ElementcatalogTable::getList([
                'select' => ['ID', 'DETAIL_PICTURE'],
                'filter' => [
                    'ID' => $basketItem->getProductId(),
                ],
                "cache" => ["ttl" => 3600],
                ])->fetchObject();
                if($element){
                    $arProperties = [
                        0 => [
                        'NAME' => 'Количество',
                        'VALUE' => $basketItem->getQuantity()
                        ]
                    ];
                $arResult['BASKET']['ITEMS'][$key] = [
                    'ID' => $basketItem->getId(),
                    'NAME' => $basketItem->getField('NAME'),
                    'URL' =>  $basketItem->getField('DETAIL_PAGE_URL'),
                    'PRICE' => $basketItem->getPrice(),
                    'BASE_PRICE' => $basketItem->getBasePrice(),
                    'SALE' => $basketItem->getBasePrice() > $basketItem->getPrice(),
                    'PICTURE' => $element->getDetailPicture() ? CFile::ResizeImageGet($element->getDetailPicture(), Array("width" => 160, "height" => 160), BX_RESIZE_IMAGE_PROPORTIONAL)['src'] : '',
                    'PROPERTIES' => $arProperties
                ];
            }
        }
    }
    return $arResult;
}
if($data['action'] === 'add'){
    addBasketItem($data['id'], $data['quantity']);
}
elseif($data['action'] === 'delete'){
    deleteBasketItem($data['id']);
}
getBasketData();
echo \Bitrix\Main\Web\Json::encode($arResult, JSON_UNESCAPED_UNICODE);
?>
<?require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_after.php';?>