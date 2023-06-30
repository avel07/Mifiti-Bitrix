<?php
// Языковые файлы.
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
// События.
use Bitrix\Main\EventManager;
// Loader;
use Bitrix\Main\Loader;

// Объявим UserClass.
define("SITE_USER_CLASS_PATH", "/local/php_interface/classes");
// Объявим пространство ajax
define("SITE_AJAX_PATH", "/local/ajax");
// Подключим классы.
Loader::registerAutoLoadClasses(null, [
   '\Security\ajax' => SITE_USER_CLASS_PATH.'/Security.php',
   '\CatalogHelper\favorites' => SITE_USER_CLASS_PATH.'/CatalogHelper.php',
   '\BasketHelper\Basket' => SITE_USER_CLASS_PATH.'/BasketHelper.php',
   '\SmsHelper\Sms' => SITE_USER_CLASS_PATH.'/SmsHelper.php',
]);

$eventManager = EventManager::getInstance();

// Тут хранятся функции и классы всех событий.
require_once __DIR__ . '/EventHandlerFunctions.php';

$eventManager->addEventHandlerCompatible("main", "OnEndBufferContent", "deleteKernel");

?>