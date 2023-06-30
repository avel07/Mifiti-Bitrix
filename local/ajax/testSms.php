<?require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");?>
<?
\Bitrix\Main\Loader::includeModule('disprove.smska');
$dsmska = new Dsmska();
$settings = $dsmska->GetSettings(false,["ACTIVE"=>"Y"])[0];

$client = new Client(["LOGIN"=> $settings["LOGIN"], "PASSWORD"=>$settings["PASSWORD"], "OPERATOR"=>1, "TARIF"=>1]);
$post_params = [
'from' => "MIFITI",
'to' => '+79090843231',
'message' => "Тестовое сообщение"
];

$res = $client->makeRequest("sms",$post_params);
echo '<pre>';
var_dump($dsmska->pr($res));
echo '</pre>';
?>
<?require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_after.php';?>