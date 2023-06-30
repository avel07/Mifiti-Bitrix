<?
namespace BasketHelper;
    // При вызове необходимо подключать модули каталога и sale.
    class Basket {
        public static function addItem(int $productId, int $quantity){
            $arResult = false;
            // Метод сам проверит на доступность к добавлению элемента в корзину.
            // Также прибавит количество, спасибо ORM. НЕОБХОДИМО ПОМНИТЬ, ЧТО В ORM НЕ ДОБАВИТЬ КАСТОМНУЮ ЦЕНУ!
            $addBasket = \Bitrix\Catalog\Product\Basket::addProduct([
                'PRODUCT_ID' => $productId,
                'QUANTITY' => $quantity,
                // Если нужны свойства в корзине и в последствии в заказе, то можем их добавить.
                'PROPS' => [],
            ]);
            if (!$addBasket->isSuccess()) {
                echo $addBasket->getErrorMessages();
                return false;
            }
            else{
                $arResult = true;
            }
            return $arResult;
        }
        // Удаляем элемент корзины
        public static function deleteItem(string $productId){
            $arResult = false;
            $basket = \Bitrix\Sale\Basket::loadItemsForFUser(
                \Bitrix\Sale\Fuser::getId(),
                \Bitrix\Main\Context::getCurrent()->getSite()
            );
            $basketItems = $basket->getBasketItems();
            foreach($basketItems as $basketItem){
                if($basketItem->getId() == $productId){
                    $item = $basketItem->getId();
                    $basket->getItemById($item)->delete();
                    $arResult = true;
                    $basket->save();
                }
            }
            return $arResult;
        }
        public static function changeQuantity($productId, $quantity){
            $arResult = false;
            $basket = \Bitrix\Sale\Basket::loadItemsForFUser(
                \Bitrix\Sale\Fuser::getId(),
                \Bitrix\Main\Context::getCurrent()->getSite()
            );
            $basketItems = $basket->getBasketItems();
            foreach($basketItems as $basketItem){
                if($basketItem->getField('PRODUCT_ID') == $productId){
                    $basketItem->setField('QUANTITY', $quantity);
                    $arResult = true;
                    $basket->save();
                }
                else{
                    echo 'Элемента - '.$productId.' в корзине не найдено';
                    return false;
                }
                return $arResult;
            }
        }
        // Получаем количество товаров в корзине
        public static function getCount(){
            $arResult = false;
            $result = Sale\Internals\BasketTable::getList(array(
                'filter' => array(
                    'FUSER_ID' => Sale\Fuser::getId(), 
                    'ORDER_ID' => null,
                    'LID' => SITE_ID,
                    'CAN_BUY' => 'Y',
                ),
                'select' => array('BASKET_COUNT'),
                'runtime' => array(
                    new \Bitrix\Main\Entity\ExpressionField('BASKET_COUNT', 'COUNT(*)'),
                )
            ))->fetch();
        }
        // Получаем информацию о корзине
        public static function getInfo(){
            $basket = \Bitrix\Sale\Basket::loadItemsForFUser(
                \Bitrix\Sale\Fuser::getId(),
                \Bitrix\Main\Context::getCurrent()->getSite()
            );
            $context = new \Bitrix\Sale\Discount\Context\Fuser($basket->getFUserId());
            $discounts = \Bitrix\Sale\Discount::buildFromBasket($basket, $context);
            if($discounts){
                $r = $discounts->calculate();
                if (!$r->isSuccess())
                {
                    $basket = $r->getErrorMessages();
                }
                $result = $r->getData();
                if (isset($result['BASKET_ITEMS']))
                {
                    $r = $basket->applyDiscount($result['BASKET_ITEMS']);
                    if (!$r->isSuccess())
                    {
                        $basket = $r->getErrorMessages();
                    }
                }
            }
            return $basket;
        }
        // Функция чтобы вытягивать все добавленные в корзину свойства по ID товара.
        public static function getBasketProperty($basketItemID){
            $basketPropRes = Bitrix\Sale\Internals\BasketPropertyTable::getList(array(
                'filter' => array(
                   "BASKET_ID" => $basketItemID,
                ),
             ));
             while ($property = $basketPropRes->fetch()) {
                $arResult[] = $property;
            }
            return $arResult;
        }
    }
?>