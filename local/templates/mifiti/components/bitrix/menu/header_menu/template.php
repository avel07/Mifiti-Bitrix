<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<nav class="header__menu">
	<ul class="header__menu__items">
		<?foreach($arResult as $arItem):?>
		<li class="header__menu__item <?=$arItem["SELECTED"] ? 'active' : '' ;?>" >
			<a href="<?=$arItem['LINK']?>">
				<?=$arItem['TEXT']?>
			</a>
			<?if($arItem['CHILDREN']):?>
			<div class="header__submenu">
				<div class="container">
					<div class="row header__submenu__items">
						<ul class="col-lg-8 header__submenu__items--links">
							<?foreach($arItem['CHILDREN'] as $child):?>
							<li class="header__submenu__items--link <?=$child['SELECTED'] ? 'active': ''?>"><a href="<?=$child['LINK']?>">
									<?=$child['TEXT']?>
								</a></li>
							<?endforeach;?>
						</ul>
						<div class="col-lg-4">
							<div class="header__submenu__image">
								<img src="<?=SITE_TEMPLATE_PATH?>/img/menu__image.png" alt="Mi Fi Ti"
								width="418"
								height="181"
								>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?endif;?>
		</li>
		<?endforeach;?>
	</ul>
</nav>
<?endif;?>