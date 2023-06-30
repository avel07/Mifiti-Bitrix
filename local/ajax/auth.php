<?require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");?>
<?
$postData = \Bitrix\Main\Application::getInstance()->getContext()->getRequest(); // Получаем запрос.
try {
    $data = \Bitrix\Main\Web\Json::decode($postData->getInput()); // Если это json, то он его декодирует.
    // Кастомный класс для проверки сессии и данных на сессию.
    if(\Security\ajax::checkSessid($data)){
        $data['login'] = Bitrix\Main\UserPhoneAuthTable::normalizePhoneNumber($data['login']);
        $data['login'] = \SmsHelper\Sms::PhoneMask($data['login']);
        $arResult['status'] = false;
        $phoneTable = \Bitrix\Main\UserPhoneAuthTable::getList($parameters = array('filter'=>array('PHONE_NUMBER' => $data['login'])))->fetch();
        if(!$phoneTable){
            $arResult['data'] = 'Пользователя - '.$data['login'].' не найдено!';
            echo \Bitrix\Main\Web\Json::encode($arResult, JSON_UNESCAPED_UNICODE);
            return;
        }
        $user = Bitrix\Main\UserTable::getList([ // Получаем данные по пользователю 
            'select' => [
                'ID',
                'ACTIVE',
                'BLOCKED',
                'PASSWORD',
            ],
            'filter' => [
                'ID' => $phoneTable['USER_ID']
            ],
            'private_fields' => true // Чтобы получить хеш пароля.
        ])->fetch();
        // Если активен и не заблочен.
        if($user['ACTIVE'] == 'Y' && $user['BLOCKED'] == 'N'){
            // Проверяем пароль (вернет true если пароль подходит)
            $checkpass = \Bitrix\Main\Security\Password::equals($user['PASSWORD'], $data['password']);
            if($checkpass){
                $USER->Authorize($user['ID']); 
                $arResult['data'] = 'Вы успешно вошли!';
                $arResult['status'] = true;
            }
            else{
                $arResult['data'] = 'Неправильный пароль!';
            }
        }
        // Если неактивен или заблочен.
        else{
            $arResult['data'] = 'Пользователь - '.$user['LOGIN'].' неактивен или заблокирован.';
        }
        echo \Bitrix\Main\Web\Json::encode($arResult, JSON_UNESCAPED_UNICODE);
    }
} catch (Exception $e) {
    echo \Bitrix\Main\Web\Json::encode($e->getMessage(), JSON_UNESCAPED_UNICODE);
}

?>
<?require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_after.php';?>