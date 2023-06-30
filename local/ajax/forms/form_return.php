<?require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");?>
<?
$postData = \Bitrix\Main\Application::getInstance()->getContext()->getRequest(); // Получаем запрос.
try {
    $data = \Bitrix\Main\Web\Json::decode($postData->getInput()); // Если это json, то он его декодирует.
        if(\Security\ajax::checkSessid($data)){
        $arResult['status'] = false;
        // Если вдруг введут номер или еще какой-либо символ.
        $orderID = intval(preg_replace('/[^0-9]/', '', $data['form_text_5']));
        // Проверим оплаченные заказы на существование и на оплату.
        Bitrix\Main\Loader::includeModule("sale");
        if(!\Bitrix\Sale\Order::loadByAccountNumber($orderID)){
            $arResult['text'] = 'Заказа №'.$orderID.' не найдено!';
            echo \Bitrix\Main\Web\Json::encode($arResult, JSON_UNESCAPED_UNICODE);
            return false;
        }
        elseif(!\Bitrix\Sale\Order::loadByAccountNumber($orderID)->isPaid()){
            $arResult['text'] = 'Заказ №'.$orderID.' не оплачен!';
            echo \Bitrix\Main\Web\Json::encode($arResult, JSON_UNESCAPED_UNICODE);
            return false;
        }
        // Проверим EMAIL на валидность.
        if (!filter_var($data['form_email_4'], FILTER_VALIDATE_EMAIL)) {
            $arResult['text'] = 'Неправильно введен EMAIL';
            echo \Bitrix\Main\Web\Json::encode($arResult, JSON_UNESCAPED_UNICODE);
            return false;
        }
        // Если все ок, то отправим форму
        if(Bitrix\Main\Loader::includeModule("form")){
            // Добавим ответы к вопросам формы.
            if ($resultID = CFormResult::Add($data['WEB_FORM_ID'], $data))
            {
                if(CFormResult::Mail($resultID)){
                    $arResult['text'] = "Заявление №".$resultID." успешно создано";
                    $arResult['status'] = true;
                }
                else{
                    global $strError;
                    $arResult['text'] = "Заявление №".$resultID." успешно создано, но почтовый шаблон не отправился! Ошибка - ".$strError;
                    $arResult['status'] = true;
                }

            }
            // Обработаем возможную ошибку.
            else
            {
                global $strError;
                $arResult['text'] = $strError;
            }  
        }
    }
    echo \Bitrix\Main\Web\Json::encode($arResult, JSON_UNESCAPED_UNICODE);
}
catch (Exception $e) {
    echo \Bitrix\Main\Web\Json::encode($e->getMessage(), JSON_UNESCAPED_UNICODE);
}
?>
<?require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_after.php';?>