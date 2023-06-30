<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

//delayed function must return a string
if(empty($arResult))
	return "";

$strReturn = '';
$strReturn .= '<div class="breadcrumbs">';
$strReturn .= '<div class="container">';
$strReturn .= '<ul class="breadcrumbs__items" itemscope itemtype="https://schema.org/BreadcrumbList">';

$itemSize = count($arResult);
for($index = 0; $index < $itemSize; $index++)
{
	$title = (htmlspecialcharsex($arResult[$index]["TITLE"]));
	if($arResult[$index]["LINK"] <> "" && $index != $itemSize-1)
	{
		$strReturn .= '
			<li class="breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				<a href="'.strtolower($arResult[$index]["LINK"]).'" itemprop="item">
					<span itemprop="name" class="breadcrumbs__item--link">'.$title.'</span>
					<meta itemprop="position" content="'.$index.'">
				</a>
			</li>';
	}
	else{
		$strReturn .= '
		<li class="breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				<span itemprop="name">'.$title.'</span>
				<meta itemprop="position" content="'.$index.'">
		</li>';
	}
}
$strReturn .= '</ul>';
$strReturn .= '</div>';
$strReturn .= '</div>';
return $strReturn;
