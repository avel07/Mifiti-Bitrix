<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заявление на возврат");
?><?$APPLICATION->IncludeComponent(
	"bitrix:breadcrumb",
	"breadcrumbs",
	Array(
		"PATH" => "",
		"SITE_ID" => "s1",
		"START_FROM" => "0"
	)
);?>
<div class="page__title">
	<div class="container">
		<div class="row">
			<h1><?$APPLICATION->ShowTitle()?></h1>
		</div>
	</div>
</div>
<div class="return">
	<div class="container">
		<div class="row">
			<div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
				<?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new", 
	"return", 
	array(
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHAIN_ITEM_LINK" => "",
		"CHAIN_ITEM_TEXT" => "",
		"EDIT_URL" => "",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"LIST_URL" => "",
		"SEF_MODE" => "N",
		"SUCCESS_URL" => "",
		"USE_EXTENDED_ERRORS" => "Y",
		"WEB_FORM_ID" => "1",
		"COMPONENT_TEMPLATE" => "return",
		"VARIABLE_ALIASES" => array(
			"WEB_FORM_ID" => "WEB_FORM_ID",
			"RESULT_ID" => "",
		)
	),
	false
);?>
			</div>
			<div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
				<div class="return__info">
                <?$APPLICATION->IncludeComponent(
					"bitrix:main.include",
					"",
					array(
						"AREA_FILE_SHOW" => "file", 
						"PATH" => SITE_TEMPLATE_PATH."/includes/help/return/return.php" 
					));?>
				</div>
			</div>
		</div>
	</div>
</div>
 <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>