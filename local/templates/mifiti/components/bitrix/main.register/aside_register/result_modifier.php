<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

    $names = array(
        'LOGIN' => 'Телефон',
        'PASSWORD' => 'Пароль',
        'CONFIRM_PASSWORD' => 'Подтверждение пароля',
        'EMAIL' => 'Эл. Почта',
    );
    $types = array(
        'LOGIN' => 'tel',
        'PASSWORD' => 'password',
        'CONFIRM_PASSWORD' => 'password',
        'EMAIL' => 'email',
    );
    foreach($arResult['SHOW_FIELDS'] as $key => $field){
        $arResult['INPUTS'][$key] = array(
            'NAME' => $names[$field],
            'TYPE' => $types[$field],
            'ID' => $field,
            'REQUIRED' => $arResult['REQUIRED_FIELDS_FLAGS'][$field], 
        );
    }

