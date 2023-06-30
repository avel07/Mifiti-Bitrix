<?require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");?>
<?
$GLOBALS['APPLICATION']->RestartBuffer();
\Bitrix\Main\Loader::includeModule('iblock');
use Bitrix\Main\Application;
use Bitrix\Main\Web\Cookie;

$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest(); // Получаем запрос.
try {
    $data = \Bitrix\Main\Web\Json::decode($request->getInput()); // Если это json, то он его декодирует.
} catch (Exception $e) {
    $arResult['text'] = $e->getMessage(); // Иначе выведет ошибку
}
$arResult['status'] = false;
// Добавление фаворита.
function addFavorites($id){
    global $arResult;
    global $request;
    // Если пользователь не зарегистрирован
    if(!\Bitrix\Main\Engine\CurrentUser::get()->getId()){
        $request = Application::getInstance()->getContext()->getRequest(); // Получаем запрос.
        $host = new \Bitrix\Main\Web\Uri($request->getRequestUri()); // Получаем домен куда привязать куки.
        $host = $host->getHost();
        // Получаем данные по куки.
        $arFavorites = $request->getCookie("favorites");
        // Преобразовываем в массив.
        $arFavorites = unserialize($arFavorites);
        // Если сериализованые куки являются строкой, то преобразуем в массив. (Такое случается, когда элемент один).
        if(is_string($arFavorites)){
            $arFavorites = array(0 => $arFavorites);
        }
        // Проверим вообще на существование элемента.
        $item = \Bitrix\Iblock\Elements\ElementcatalogTable::getByPrimary($id, [
            'select' => ['ID'],
            'filter' => ['=ID' => $id]
        ])->fetch();
        if(!$item){
            $arResult['text'] = 'Элемента с ID - '.$id.' не найдено!';
            $arResult['items'] = count($arFavorites);
            return false;
        }
        // Если куки найдены
        if($arFavorites){
            // Если в куки нет данного ID
            if(!in_array($id, $arFavorites)){
                $arFavorites[] = $id;
                $cookie = new Cookie("favorites", serialize($arFavorites), time()+86400*30);
                $cookie->setDomain($host);
                Application::getInstance()->getContext()->getResponse()->addCookie($cookie);
                $arResult['text'] = 'Товар - '.$id.' успешно добавлен в избранное.';
                $arResult['status'] = true;
            }
            else{
                $arResult['text'] = 'Ошибка, товар - '.$id.' уже есть в избранном.';
            }
        }
        // Если кук нету, то создаем новые и добавляем туда один элемент.
        else{
            $arFavorites[] = $id;
            $cookie = new Cookie("favorites", serialize($arFavorites), time()+86400*30);
            $cookie->setDomain($host);
            Application::getInstance()->getContext()->getResponse()->addCookie($cookie);
            $arResult['text'] = 'Товар - '.$id.' успешно добавлен в избранное.';
            $arResult['status'] = true;
        }
    }
    // Если пользователь зарегистрирован
    else{
        $arFavorites = [];
        $user = Bitrix\Main\UserTable::getList([ // Получаем данные по пользователю 
            'select' => [
                'ID',
                'UF_FAVORITES' // Пользовательское поле фаворитов
            ],
            'filter' => [
                '=ID' => \Bitrix\Main\Engine\CurrentUser::get()->getId() 
            ],
        ])->fetch();
        // Проверим вообще на существование элемента.
        $item = \Bitrix\Iblock\Elements\ElementcatalogTable::getByPrimary($id, [
            'select' => ['ID'],
            'filter' => ['=ID' => $id]
        ])->fetch();
        $arFavorites = $user['UF_FAVORITES'];
        $userID = $user['ID'];
        if(!$item){
            $arResult['text'] = 'Элемента с ID - '.$id.' не найдено!';
            $arResult['items'] = count($arFavorites);
            return false;
        }
        // Если это у нас массив, то проверяем наличие элемента. Если его нет, то добавляем.
        if(is_array($arFavorites)){
            if(!in_array($id, $arFavorites)){ // Если ID нет в избранном, то 
                $arFavorites[] = $id; // Просто добавляем этот элемент в массив.
                $fakeUser = new CUser;
                $fakeUser->Update($user['ID'], array('UF_FAVORITES' => $arFavorites));
                $arResult['text'] = 'Товар - '.$id.' успешно добавлен в избранное.';
                $arResult['status'] = true;
            }
            else{
                $arResult['text'] = 'Ошибка! Товар - '.$id.' уже в избранном!';
                $arResult['status'] = false;
            }
        }
        // Если это не массив, то соответственно просто добавляем элемент без проверки, т.к. это первый раз для юзера.
        else{
            $arFavorites[] = $id; // Просто добавляем этот элемент в массив.
            $fakeUser = new CUser;
            $fakeUser->Update($user['ID'], array('UF_FAVORITES' => $arFavorites));
            $arResult['text'] = 'Товар - '.$id.' успешно добавлен в избранное.';
            $arResult['status'] = true;
        }
    }
    $arResult['items'] = count($arFavorites);
}
// Удаление Фаворита
function removeFavorites($id){
    global $arResult;
    global $request;
    // Если пользователь не зарегистрирован.
    if(!\Bitrix\Main\Engine\CurrentUser::get()->getId()){
        $request = Application::getInstance()->getContext()->getRequest(); // Получаем запрос.
        $host = new \Bitrix\Main\Web\Uri($request->getRequestUri()); // Получаем домен куда привязать куки.
        $host = $host->getHost();
        // Получаем данные по куки.
        $arFavorites = $request->getCookie("favorites");
        // Преобразовываем в массив.
        $arFavorites = unserialize($arFavorites);
        // Если сериализованые куки являются строкой, то преобразуем в массив. (Такое случается, когда элемент один).
        if(is_string($arFavorites)){
            $arFavorites = array(0 => $arFavorites);
        }
        // Если куки найдены
        if($arFavorites){
            // Если в куки нет данного ID
            if(!in_array($id, $arFavorites)){
                $arResult['text'] = 'Ошибка, товара - '.$id.' нет в избранном.';
            }
            else{
                $key = array_search($id, $arFavorites); // Находим элемент, который нужно удалить из избранного
                unset($arFavorites[$key]); // Удаляем
                $cookie = new Cookie("favorites", serialize($arFavorites), time()+86400*30);
                $cookie->setDomain($host);
                Application::getInstance()->getContext()->getResponse()->addCookie($cookie);
                $arResult['text'] = 'Товар, - '.$id.' успешно удален.';
                $arResult['status'] = true;
            }
        }
        else{
            $arResult['text'] = 'Товаров в избранном нет.';
        }
    }
    // Если пользователь зарегистрирован.
    else{
        $user = Bitrix\Main\UserTable::getList([ // Получаем данные по пользователю 
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
        if(in_array($id, $arFavorites)){
            $key = array_search($id, $arFavorites); // Находим элемент, который нужно удалить из избранного
            unset($arFavorites[$key]); // Удаляем
            $fakeUser = new CUser;
            $fakeUser->Update($userID, array('UF_FAVORITES' => $arFavorites));
            $arResult['text'] = 'Товар - '.$id.' успешно удален из избранного.';
            $arResult['status'] = true;
        }
        else{
            $arResult['text'] = 'Товар - '.$id.' в избранном не найден.';
        }
    }
    $arResult['items'] = count($arFavorites);
}
if($data['action'] === 'add'){
    addFavorites($data['id']);
}
elseif($data['action'] === 'delete'){
    removeFavorites($data['id']);
}
echo \Bitrix\Main\Web\Json::encode($arResult, JSON_UNESCAPED_UNICODE);
?>
<?require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_after.php';?>