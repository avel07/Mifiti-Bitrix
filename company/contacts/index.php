<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Контакты");
?>
    <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "breadcrumbs", Array(
	"START_FROM" => "0",	// Номер пункта, начиная с которого будет построена навигационная цепочка
		"PATH" => "",	// Путь, для которого будет построена навигационная цепочка (по умолчанию, текущий путь)
		"SITE_ID" => "s1",	// Cайт (устанавливается в случае многосайтовой версии, когда DOCUMENT_ROOT у сайтов разный)
	),
	false
);?>
    <div class="page__title">
        <div class="container">
            <div class="row">
                <h1><?$APPLICATION->ShowTitle()?></h1>
            </div>
        </div>
    </div>
    <div class="shops">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                            <div class="shops__items">
                            <div class="shop__item">
                            <div class="shops__title">
                                <p>Адрес</p>
                            </div>
                            <div class="shops__subtitle">
                            <?$APPLICATION->IncludeComponent(
					"bitrix:main.include",
					"",
					array(
						"AREA_FILE_SHOW" => "file", 
						"PATH" => SITE_TEMPLATE_PATH."/includes/company/contacts/address.php" 
					));?>
                            </div>
                        </div>
                        <div class="shop__item">
                            <div class="shops__title">
                                <p>График работы</p>
                            </div>
                            <div class="shops__subtitle">
                            <?$APPLICATION->IncludeComponent(
					"bitrix:main.include",
					"",
					array(
						"AREA_FILE_SHOW" => "file", 
						"PATH" => SITE_TEMPLATE_PATH."/includes/company/contacts/shophours.php" 
					));?>
                            </div>
                            </div>
                            <div class="shop__item">
                            <div class="shops__title">
                                <p>Телефон</p>
                            </div>
                            <div class="shops__subtitle">
                            <?$APPLICATION->IncludeComponent(
					"bitrix:main.include",
					"",
					array(
						"AREA_FILE_SHOW" => "file", 
						"PATH" => SITE_TEMPLATE_PATH."/includes/company/contacts/phone.php" 
					));?>
                            </div>
                            </div>
                            <div class="shop__item">
                            <div class="shops__title">
                                <p>E-mail</p>
                            </div>
                            <div class="shops__subtitle">
                            <?$APPLICATION->IncludeComponent(
					"bitrix:main.include",
					"",
					array(
						"AREA_FILE_SHOW" => "file", 
						"PATH" => SITE_TEMPLATE_PATH."/includes/company/contacts/email.php" 
					));?>
                            </div>
                            </div>
                            <div class="shop__item">
                                <div class="shops__title">
                                    <p>Реквезиты</p>
                                </div>
                                <div class="shops__subtitle">
                                <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        array(
                            "AREA_FILE_SHOW" => "file", 
                            "PATH" => SITE_TEMPLATE_PATH."/includes/company/contacts/requisites.php" 
                        ));?>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                            <div class="shops__map">
                            <?$APPLICATION->IncludeComponent(
					"bitrix:main.include",
					"",
					array(
						"AREA_FILE_SHOW" => "file", 
						"PATH" => SITE_TEMPLATE_PATH."/includes/company/contacts/map.php" 
					));?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>