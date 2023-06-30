<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
		</div>
		</main>
<div class="arrow__top" data-scroll="body">
        <div class="arrow__top--icon">
            <svg width="12" height="21" viewBox="0 0 12 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6.53033 0.469669C6.23744 0.176777 5.76256 0.176777 5.46967 0.469669L0.696698 5.24264C0.403805 5.53553 0.403805 6.01041 0.696699 6.3033C0.989592 6.59619 1.46447 6.59619 1.75736 6.3033L6 2.06066L10.2426 6.3033C10.5355 6.59619 11.0104 6.59619 11.3033 6.3033C11.5962 6.01041 11.5962 5.53553 11.3033 5.24264L6.53033 0.469669ZM6.75 21L6.75 1L5.25 1L5.25 21L6.75 21Z" fill="black"/>
            </svg>
        </div>
    </div>
    <div class="overlay__blur"></div>
    <!--Footer-->
    <footer class="footer">
        <div class="container">
            <div class="footer__body">
            <?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"footer_menu", 
	array(
		"ROOT_MENU_TYPE" => "bottom",
		"MAX_LEVEL" => "2",
		"CHILD_MENU_TYPE" => "submenu",
		"USE_EXT" => "Y",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "Y",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
		),
		"COMPONENT_TEMPLATE" => "footer_menu"
	),
	false
);?>
            </div>
        </div>
        <div class="footer__bottom">
            <div class="container">
                <div class="row footer__bottom--items">
                    <div class="footer__bottom--item footer__bottom--left col-xl-3 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <?$APPLICATION->IncludeComponent(
					"bitrix:main.include",
					"",
					array(
						"AREA_FILE_SHOW" => "file", 
						"PATH" => SITE_TEMPLATE_PATH."/includes/footer/caption.php" 
					));?>
                    </div>
                    <div class="footer__bottom--item footer__bottom--middle col-xl-7 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?$APPLICATION->IncludeComponent(
					"bitrix:main.include",
					"",
					array(
						"AREA_FILE_SHOW" => "file", 
						"PATH" => SITE_TEMPLATE_PATH."/includes/footer/polytics.php" 
					));?>
                    </div>
                    <div class="footer__bottom--item footer__bottom--right col-xl-2 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <?$APPLICATION->IncludeComponent(
					"bitrix:main.include",
					"",
					array(
						"AREA_FILE_SHOW" => "file", 
						"PATH" => SITE_TEMPLATE_PATH."/includes/footer/developer.php" 
					));?>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>