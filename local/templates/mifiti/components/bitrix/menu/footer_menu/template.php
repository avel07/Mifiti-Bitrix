<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
    <nav class="footer__menu" itemscope itemtype="https://schema.org/SiteNavigationElement">
                    <ul class="row footer__menu--items">
                        <?foreach($arResult as $arItem):?>
                        <li class="<?=$arItem['LINK'] === '/catalog/' ? 'col-lg-4' : 'col-lg-2';?> col-md-6 col-sm-12 col-xs-12">
                            <div class="footer__menu--item <?=$arItem['SELECTED'] ? 'active' : '';?>">
                                <ul class="footer__menu--item__title">
									<?if(!$arItem['PARAMS']['LINK']):?>
									<li itemprop="name"><a href="<?=$arItem['LINK']?>" itemprop="url"><?=$arItem['TEXT']?></a></li>
									<?else:?>
									<li itemprop="name"><?=$arItem['TEXT']?></li>
									<?endif;?>
								</ul>
                                <?if($arItem['CHILDREN']):?>
                                <div class="footer__menu--item__toggle" data-toggle="collapse" data-target="next">
                                    <svg width="14" height="27" viewBox="0 0 14 27" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 26L13 13.5L1 1" stroke="#1D1D1D" />
                                    </svg>
                                </div>
                                <ul class="footer__menu--item__links collapse">
                                    <?foreach($arItem['CHILDREN'] as $child):?>
                                    <li class="footer__menu--item__link <?=$child['SELECTED'] ? 'active' : '';?>" itemprop="name"><a href="<?=$child['LINK']?>" itemprop="url"><?=$child['TEXT']?></a></li>
                                    <?endforeach;?>
                                </ul>
                                <?endif;?>
                            </div>
                        </li>
                        <?endforeach;?>
                    </ul>
                </nav>
<?endif;?>