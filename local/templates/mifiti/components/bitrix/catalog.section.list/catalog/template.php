<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<div class="catalog catalog__section">
	<div class="container container__nopadding-sm">
		<div class="catalog__section--items">
			<div class="row row__nopadding-sm">
				<?foreach($arResult['SECTIONS'] as $arSection):?>
					<div class="col-lg-4 col-sm-6 col-xs-12">
						<div class="catalog__section--item">
							<a href="<?=$arSection['SECTION_PAGE_URL']?>">
								<div class="catalog__section--image br-sm-1">
									<img src="<?=$arSection['PICTURE']['SRC']?>" alt="<?=$arSection['NAME']?>"
									width="<?=$arSection['PICTURE']['WIDTH']?>"
									height="<?=$arSection['PICTURE']['HEIGHT']?>"
									class="br-sm-1"
									>
								</div>
								<div class="catalog__section--title">
									<?=$arSection['NAME']?>
									<div class="catalog__section--subtitle">
										Перейти в каталог ...
									</div>
								</div>
							</a>
						</div>
					</div>
				<?endforeach;?>
			</div>
		</div>
	</div>
</div>