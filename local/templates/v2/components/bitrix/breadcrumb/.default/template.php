<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;
//echo pre3($arResult);
//delayed function must return a string
if(empty($arResult))
	return "";

$strReturn = '';

$strReturn .= '<ul class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">';

$itemSize = count($arResult);
for($index = 0; $index < $itemSize; $index++)
{
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
	//$arrow = ($index > 0? '<i class="fa fa-angle-right"></i>' : '');
	$scheme = isset($_SERVER['HTTP_SCHEME']) ? $_SERVER['HTTP_SCHEME'] : (
		((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || 443 == $_SERVER['SERVER_PORT']) ? 'https://' : 'http://'
	);
	$strReturn .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
	$strReturn .= '<a href="' . $scheme . $_SERVER["HTTP_HOST"] . $arResult[$index]["LINK"].'" title="'.$title.'" itemprop="item">'.$title.'</a>';
	$strReturn .= '<meta itemprop="position" content="'.($index + 1).'" />';
	$strReturn .= '<meta itemprop="name" content="'.$title.'" />';
	$strReturn .= '</li>';
}

$strReturn .= '</ul>';

return $strReturn;