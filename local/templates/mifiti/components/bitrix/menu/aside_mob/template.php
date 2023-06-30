<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
	<nav itemscope itemtype="https://schema.org/SiteNavigationElement">
	<ul class="header__menu--mob__items">
		<?foreach($arResult as $arItem):?>
                    <li class="header__menu--mob__item" itemprop="name">
                            <a href="<?=$arItem['LINK']?>" itemprop="url" class="header__menu--mob__item--link <?=$arItem['SELECTED'] ? 'active' : '';?>">
							<?=$arItem['TEXT']?></a>
						<?if($arItem['CHILDREN']):?>
                        <div class="header__menu--mob__toggle" data-toggle="collapse" data-target="next">
                            <svg width="27" height="13" viewBox="0 0 27 13" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 1L13.5 12L26 1" stroke="#1D1D1D" />
                            </svg>
                        </div>
                        <ul class="header__menu--mob__submenu collapse catalog__lvl-1">
							<?foreach($arItem['CHILDREN'] as $child):?>
                            <li class="header__menu--mob__submenu--link <?=$child['SELECTED'] ? 'active' : '';?>" itemprop="name"><a href="<?=$child['LINK']?>" itemprop="url"><?=$child['TEXT']?></a></li>
							<?endforeach;?>
                        </ul>
						<?endif;?>
                    </li>
					<?endforeach;?>
                </ul>
		</nav>
<?endif;?>