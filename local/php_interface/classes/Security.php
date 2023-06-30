<?
namespace Security;
    class ajax {
        
        const PUBLIC_KEY = '6LfQzMImAAAAAL5NZPFToTfSoycOcyjIIlLOr2n1';
        const SECRET_KEY = '6LfQzMImAAAAAEKGdK5tuqYcgWgPeBRGleABpiGl';
        /**
         * Возвращает PublicKey от recaptcha
         * @return PublicKey 
         *  */  
        public static function getPublicKey() {
            return self::PUBLIC_KEY;
        }

        /**
         * Возвращает SecretKey от recaptcha
         * @return SecretKey 
         *  */  
        public static function getSecretKey() { 
            return self::SECRET_KEY;
        }

        /**
         * Возвращает ответ от recaptcha или ошибку!
         * @return response 
         *  */        
        public static function checkClientResponse($CaptchaResponse){
            if ($CaptchaResponse) {
                $url = 'https://www.google.com/recaptcha/api/siteverify';

                $data = [
                    'secret'   => static::getSecretKey(),
                    'response' => $CaptchaResponse,
                ];

                $httpClient = new \Bitrix\Main\Web\HttpClient();

                $response = $httpClient->post($url, $data);

                // if ($response) {
                    // $arResult = \Bitrix\Main\Web\Json::decode($response, true);
                // }

                // if (!$response['success']) {
                //     $arResult = $response['error-codes'];
                // }
                $arResult = \Bitrix\Main\Web\Json::decode($response, true);
            }
            else{
                $arResult = 'Не получен ответ с капчи. Пожалуйста введите капчу!';
            }
            return $arResult;
        }

        /**
         * Возвращает $arResult с ошибкой, если проверка не пройдена
         * @return true|false
         */
        public static function checkSessid($data) {
            if($data){ 
                if($data['sessid'] == bitrix_sessid()){
                    $arResult['status'] = true;
                }
                else{
                    $arResult['status'] = false;
                    $arResult['data'] = 'Ошибка проверки сессии. Пожалуйста обновите страницу!';
                }
            }
            else{
                    $arResult['status'] = false;
                    $arResult['data'] = 'Данные не были получены!';
            }
            if($arResult['status']){
               return true; 
            }
            else{
                echo json_encode($arResult, JSON_UNESCAPED_UNICODE);
                return false;
            }
        }
        // Проверка JSON ли данные.
        public static function isJson($data){
            return is_string($string) && is_array(json_decode($string, true)) ? true : false;
        }

    }
?>