<?
namespace catalogHelper;
    class favorites {
        public static function isFavorite($id) {
            if($id){
                if(!\Bitrix\Main\Engine\CurrentUser::get()->getId()){
                    $request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest(); // Получаем запрос.
                    $host = new \Bitrix\Main\Web\Uri($request->getRequestUri()); // Получаем домен куда привязать куки.
                    $host = $host->getHost();
                    // Получаем данные по куки.
                    $arFavorites = $request->getCookie("favorites");
                    // Преобразовываем в массив.
                    if($arFavorites){
                        $arFavorites = unserialize($arFavorites);
                        // Если сериализованые куки являются строкой, то преобразуем в массив. (Такое случается, когда элемент один).
                        if(is_string($arFavorites)){
                            $arFavorites = array(0 => $arFavorites);
                        }
                        if(in_array($id, $arFavorites)){
                            return true;
                        }
                        else{
                            return false;
                        }
                    }
                    else{
                        return false;
                    }
                }
                // Если пользователь зарегистрирован
                else{
                    $user = \Bitrix\Main\UserTable::getList([ // Получаем данные по пользователю 
                        'select' => [
                            'ID',
                            'UF_FAVORITES' // Пользовательское поле фаворитов
                        ],
                        'filter' => [
                            '=ID' => \Bitrix\Main\Engine\CurrentUser::get()->getId() 
                        ],
                    ])->fetch();
                    $arFavorites = $user['UF_FAVORITES'];
                    if(is_array($arFavorites)){
                        if(in_array($id, $arFavorites)){
                            return true;
                        }
                        else{
                            return false;
                        }
                    }
                    else{
                        return false;
                    }
                }
            }
            else{
                ShowError('Данные не пришли');
            }
        }
        public static function getAll(){
                if(!\Bitrix\Main\Engine\CurrentUser::get()->getId()){
                    $request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest(); // Получаем запрос.
                    $host = new \Bitrix\Main\Web\Uri($request->getRequestUri()); // Получаем домен куда привязать куки.
                    $host = $host->getHost();
                    // Получаем данные по куки.
                    $arFavorites = $request->getCookie("favorites");
                    // Преобразовываем в массив.
                    if($arFavorites){
                        $arFavorites = unserialize($arFavorites);
                    }
                }
                // Если пользователь зарегистрирован
                else{
                    $user = \Bitrix\Main\UserTable::getList([ // Получаем данные по пользователю 
                        'select' => [
                            'ID',
                            'UF_FAVORITES' // Пользовательское поле фаворитов
                        ],
                        'filter' => [
                            '=ID' => \Bitrix\Main\Engine\CurrentUser::get()->getId() 
                        ],
                    ])->fetch();
                    if($user['UF_FAVORITES']){
                        $arFavorites = $user['UF_FAVORITES'];
                    }
                }
                if($arFavorites){
                    return $arFavorites;
                }
                else{
                    return array();
                }
        }
        public static function findUnavaible(){
            global $arResult;
            $arResult['status'] = false;
            // Получаем все товары в избранном.
            $arFavorites = \CatalogHelper\favorites::getAll();
            // Проверяем элементы на доступность.
            $arAvaible = \Bitrix\Catalog\ProductTable::getList([
                'filter' => ['ID'=> $arFavorites, '=AVAILABLE' => 'Y'],
                'select' => ['ID'],
            ])->fetchAll();
            $avaibleElements = [];
            foreach ($arAvaible as $element) {
                $avaibleElements[] = $element['ID'];
            }
            // Кол-во расхождений ДОСТУПНЫХ товаров в избранном.
            $diffAvaible = array_diff($arFavorites, $avaibleElements);
            $arActive = \Bitrix\Iblock\Elements\ElementCatalogTable::getList([
                'filter' => ['ID' => $arFavorites, '=ACTIVE' => 'Y'],
                'select' => ['ID'],
            ])->fetchAll();
            $activeElements = [];
            foreach ($arActive as $element) {
                $activeElements[] = $element['ID'];
            }
            // Кол-во расхождений АКТИВНЫХ товаров в избранном.
            $diffActive = array_diff($arFavorites, $activeElements);
            // Соединяем.
            $diff = array_merge($diffAvaible, $diffActive);
            // Удаляем дубли.
            $diff = array_unique($diff);
            // Если не зарегистрирован.
            if(!\Bitrix\Main\Engine\CurrentUser::get()->getId()){
                $request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest(); // Получаем запрос.
                $host = new \Bitrix\Main\Web\Uri($request->getRequestUri()); // Получаем домен куда привязать куки.
                $host = $host->getHost();
                foreach($diff as $id){
                // Если сериализованые куки являются строкой, то преобразуем в массив. (Такое случается, когда элемент один).
                    if(is_string($arFavorites)){
                        $arFavorites = array(0 => $arFavorites);
                    }
                    // Если куки найдены
                    if($arFavorites){
                        // Если в куки нет данного ID
                        if(in_array($id, $arFavorites)){
                            $key = array_search($id, $arFavorites); // Находим элемент, который нужно удалить из избранного
                            unset($arFavorites[$key]); // Удаляем
                            $cookie = new \Bitrix\Main\Web\Cookie("favorites", serialize($arFavorites), time()+86400*30);
                            $cookie->setDomain($host);
                            \Bitrix\Main\Application::getInstance()->getContext()->getResponse()->addCookie($cookie);
                            $arResult['status'] = true;
                        }
                    }
                }
            }
            // Если пользователь зарегистрирован
            else{
                $user = \Bitrix\Main\UserTable::getList([ // Получаем данные по пользователю 
                    'select' => [
                        'ID',
                        'UF_FAVORITES' // Пользовательское поле фаворитов
                    ],
                    'filter' => [
                        '=ID' => \Bitrix\Main\Engine\CurrentUser::get()->getId() 
                    ],
                ])->fetch();
                $arFavorites = $user['UF_FAVORITES'];
                $userID = $user['ID'];
                foreach($diff as $id){
                    if(in_array($id, $arFavorites)){
                        $key = array_search($id, $arFavorites); // Находим элемент, который нужно удалить из избранного
                        unset($arFavorites[$key]); // Удаляем
                        $fakeUser = new \CUser;
                        $fakeUser->Update($userID, array('UF_FAVORITES' => $arFavorites));
                        $arResult['status'] = true;
                    }
                }
            }
            return $arResult;
        }
    }
?>