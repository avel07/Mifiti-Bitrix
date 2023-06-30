<?require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");?>
<?
$postData = \Bitrix\Main\Application::getInstance()->getContext()->getRequest(); // Получаем запрос.
try {
    $data = \Bitrix\Main\Web\Json::decode($postData->getInput()); // Если это json, то он его декодирует.
    // Кастомный класс для проверки сессии и данных на сессию.
    if(\Security\ajax::checkSessid($data)){

        $arResult['status'] = false;

        if($data['action'] === 'sendsms' && !$data['g-recaptcha-response']){
            $arResult['data'] = 'Пожалуйста выполните проверку на робота.';
            echo \Bitrix\Main\Web\Json::encode($arResult, JSON_UNESCAPED_UNICODE);
            return;
        }
        
        if($data['action'] === 'sendsms' && !\Security\ajax::checkClientResponse($data['g-recaptcha-response'])['success']){
            $arResult['data'] = 'Проверка на робота не пройдена!';
            echo \Bitrix\Main\Web\Json::encode($arResult, JSON_UNESCAPED_UNICODE);
            return;
        }

        if(!\Bitrix\Main\UserPhoneAuthTable::validatePhoneNumber($data['login'])){
            $arResult['data'] = 'Номер телефона некорректный.';
            echo \Bitrix\Main\Web\Json::encode($arResult, JSON_UNESCAPED_UNICODE);
            return;
        }

        $data['login'] = \Bitrix\Main\UserPhoneAuthTable::normalizePhoneNumber($data['login']);

        $data['login'] = \SmsHelper\Sms::PhoneMask($data['login']);

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
        // Если есть пользователь
        if($user){
            // Но пользователь не активен или заблочен.
            if($user['ACTIVE'] == 'N' && $user['BLOCKED'] == 'Y'){
                $arResult['data'] = 'Пользователь - '.$user['LOGIN'].' неактивен или заблокирован.';
                return \Bitrix\Main\Web\Json::encode($arResult, JSON_UNESCAPED_UNICODE);
            }
            
            // Если всё ок, то отправляем SMS.
            if($data['action'] === 'sendsms'){
                $code = \Bitrix\Main\Security\Random::getInt(1000, 10000);
                $arResult = \SmsHelper\Sms::SendSmsCode($data['login'],  $code);
            }
            // Проверяем SMS.
            elseif($data['action'] === 'checksms'){
                $arResult = \SmsHelper\Sms::CheckSmsCode($data['smscode']);
            }
            // Обновляем поля
            elseif($data['action'] === 'action'){
                // Если нет пользователя
                $update = $USER->Update($user['ID'], array('PASSWORD' => $data['password'], 'CONFIRM_PASSWORD' => $data['confirm_password']));
                if($update){
                    $USER->Authorize($user['ID']);
                    $arResult = [
                        'data' => 'Вы успешно обновили пароль.',
                        'status' => true,
                        'action' => 'update'
                    ];
                }
                else{
                    $arResult['data'] = $USER->LAST_ERROR;
                }   
            }
            else{
                $arResult['data'] = 'Неправильное действие';
            }
        }
        else{
            $arResult['data'] = 'Пользователь - '.$data['login'].' не найден.';
        }
        echo \Bitrix\Main\Web\Json::encode($arResult, JSON_UNESCAPED_UNICODE);
    }
} catch (Exception $e) {
    echo \Bitrix\Main\Web\Json::encode($e->getMessage(), JSON_UNESCAPED_UNICODE);
}
?>
<?require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_after.php';?>