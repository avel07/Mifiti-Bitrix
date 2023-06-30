<?require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");?>
<?
$postData = \Bitrix\Main\Application::getInstance()->getContext()->getRequest(); // Получаем запрос.
try {
    $data = \Bitrix\Main\Web\Json::decode($postData->getInput()); // Если это json, то он его декодирует.
    // Кастомный класс для проверки сессии и данных на сессию.
    if(\Security\ajax::checkSessid($data)){

        $arResult['status'] = false;

        // Проверяем на заполненность капчи
        if($data['action'] === 'sendsms' && !$data['g-recaptcha-response']){
            $arResult['data'] = 'Пожалуйста выполните проверку на робота.';
            echo \Bitrix\Main\Web\Json::encode($arResult, JSON_UNESCAPED_UNICODE);
            return;
        }
        
        // Проверяем капчу через POST запрос в Google.
        if($data['action'] === 'sendsms' && !\Security\ajax::checkClientResponse($data['g-recaptcha-response'])['success']){
            $arResult['data'] = 'Проверка на робота не пройдена!';
            echo \Bitrix\Main\Web\Json::encode($arResult, JSON_UNESCAPED_UNICODE);
            return;
        }

        // Смотрим на адекватность телефона (мало ли что и кто придет сюда).
        if(!\Bitrix\Main\UserPhoneAuthTable::validatePhoneNumber($data['login'])){
            $arResult['data'] = 'Номер телефона некорректный.';
            echo \Bitrix\Main\Web\Json::encode($arResult, JSON_UNESCAPED_UNICODE);
            return;
        }

        // Нормализуем телефон.
        $data['login'] = \Bitrix\Main\UserPhoneAuthTable::normalizePhoneNumber($data['login']);
        
        // Сделаем правильную принудительную маску.
        $data['login'] = \SmsHelper\Sms::PhoneMask($data['login']);

        // Проверим на существование юзера, дабы избежать дублей. Т.к. используем метод $USER->Add()
        if(\Bitrix\Main\UserPhoneAuthTable::getList($parameters = array('filter'=>array('PHONE_NUMBER' => $data['login'])))->fetch()){
            $arResult['data'] = 'Пользователь - '.$data['login'].' уже существует!';
            echo \Bitrix\Main\Web\Json::encode($arResult, JSON_UNESCAPED_UNICODE);
            return;
        }

        // Экземпляр Юзера
        $USER = new CUser;

        // Отправим SMS.
        if($data['action'] === 'sendsms'){
            $code = \Bitrix\Main\Security\Random::getInt(1000, 10000);
            $arResult = \SmsHelper\Sms::SendSmsCode($data['login'],  $code);
        }
        elseif($data['action'] === 'checksms'){
            $arResult = \SmsHelper\Sms::CheckSmsCode($data['smscode']);
        }
        elseif($data['action'] === 'action'){
            if(!check_email($data['email'])){
                $arResult['data'] = 'Неправильная почта.';
                echo \Bitrix\Main\Web\Json::encode($arResult, JSON_UNESCAPED_UNICODE);
                return;
            }
            $arUserFields = [
                "LOGIN"             => $data['login'],
                "PASSWORD"          => $data['password'],
                "CONFIRM_PASSWORD"  => $data['confirm_password'],
                "EMAIL"             => $data['email'],
                "ACTIVE"            => "Y",
                "PHONE_NUMBER"      => $data['login']
            ];
            $newUserID = $USER->add($arUserFields);
            if($newUserID){
                $USER->Authorize($newUserID);
                $arResult = [
                    'data' => 'Вы успешно зарегистрировались. Страница обновится через 3 секунды.',
                    'status' => true,
                    'action' => 'update'
                ];
            }
            else{
                $arResult = [
                    'data' => $USER->LAST_ERROR,
                    'status' => $arResult['status'],
                    'login' => $data['login']
                ];
            }

        }
        else{
            $arResult['data'] = 'Неправильное действие';
        }
        echo \Bitrix\Main\Web\Json::encode($arResult, JSON_UNESCAPED_UNICODE);
    }
} catch (Exception $e) {
    echo \Bitrix\Main\Web\Json::encode($e->getMessage(), JSON_UNESCAPED_UNICODE);
}
?>
<?require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_after.php';?>