<?
namespace SmsHelper;
use Dsmska;
use Client;
class Sms {
    public static function SendSmsCode($phone, $code){

        \Bitrix\Main\Loader::includeModule('disprove.smska');
        $dsmska = new Dsmska();
        $settings = $dsmska->GetSettings(false,["ACTIVE"=>"Y"])[0];
         
        $client = new Client(["LOGIN"=> $settings["LOGIN"], "PASSWORD"=>$settings["PASSWORD"], "OPERATOR"=>1, "TARIF"=>1]);
        $post_params = [
        'action' => "post_sms", 
        'sender' => "MIFITI",
        'target' => $phone,
        'message' => 'Ваш SMS код - '.strval($code)
        ];

        // Отправляем сообщение.
        $sendPost = $client->makeRequest("sms",$post_params);
        // Получаем ID сообщения.
        $sendPostMessId = (int)$xml->result->sms["id"];

        // Отправляем запрос на получение данных по SMS.
        $post_params = ["action"=>"status", "sms_id"=> $sendPostMessId];
        $sendPost = $client->makeRequest("status",$post_params);
        // Получаем статус сообщения
        $sendPostStatus = $sendPost->MESSAGES->MESSAGE->SMSSTC_CODE;
        if($sendPostStatus === 'error'){
            $arResult = [
                'data' => 'Ошибка сервиса отправки SMS, пожалуйста сообщите нам об ошибке!',
                'status' => true,
                'sms_status' => $sendPost->MESSAGES->MESSAGE->SMS_STATUS
            ];
        }
        else{
            \Bitrix\Main\Application::getInstance()->getSession()->set('SMS_CODE', $code);
            $arResult = [
                'data' => 'Сообщение успешно отправлено, пожалуйста введите код.',
                'status' => true,
                'action' => 'checksms',
            ];
        }
        return $arResult;
    }

    public static function CheckSmsCode($code){
        if(intval($code) === \Bitrix\Main\Application::getInstance()->getSession()->get('SMS_CODE')){
            $arResult = [
                'data' => 'Код успешно проверен, введите данные для регистрации.',
                'status' => true,
                'action' => 'action',
            ];
        }
        else{
            $arResult = [
                'data' => 'Ошибка проверки SMS',
                'status' => false,
            ];
        }
        return $arResult;
    }
    public static function TimeLimit($time, $phone){
        $now = new DateTime();
        $sms = SmsCodeTable::getList(['filter' => ['PHONE' => $phone,'USED' => 0,'>=TIME' => $now->modify($time)->format('d.m.Y H:i:s')]])->fetch();
        if($sms['ID']){
            $arResult = [
                'data' => 'Следующий код можно отправить через'.$time,
                'status' => false
            ];
        }
        else{
            $arResult = [
                'data' => 'Проверка на время прошла успешно',
                'status' => true
            ];
        }
    }
    // Сделаем свою телефонную маску. Иногда Bitrix нормально не хочет парсить. Маска вида +7__________
    public static function PhoneMask($value){
        $value = trim($value);
        $arResult = preg_replace(
            array(
                '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{3})[-|\s]?\)[-|\s]?(\d{3})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
                '/[\+]?([7|8])[-|\s]?(\d{3})[-|\s]?(\d{3})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
                '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{4})[-|\s]?\)[-|\s]?(\d{2})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
                '/[\+]?([7|8])[-|\s]?(\d{4})[-|\s]?(\d{2})[-|\s]?(\d{2})[-|\s]?(\d{2})/',	
                '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{4})[-|\s]?\)[-|\s]?(\d{3})[-|\s]?(\d{3})/',
                '/[\+]?([7|8])[-|\s]?(\d{4})[-|\s]?(\d{3})[-|\s]?(\d{3})/',					
            ), 
            array(
                '+7$2$3$4$5', 
                '+7$2$3$4$5', 
                '+7$2$3$4$5', 
                '+7$2$3$4$5', 	
                '+7$2$3$4', 
                '+7$2$3$4', 
            ), 
            $value
        );
        return $arResult;
    }
}
?>