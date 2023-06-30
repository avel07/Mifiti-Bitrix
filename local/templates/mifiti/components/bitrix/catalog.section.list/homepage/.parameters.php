<?
 if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

 $arTemplateParameters = array(
     'TITLE_SECTION' =>  array(
         'NAME'     =>  'Заголовок над элементами',
         'TYPE'     =>  'STRING',
         'SORT'     =>  '10',
     ),
     'SUBTITLE_SECTION' =>  array(
        'NAME'      =>  'Подзаголовок над элементами',
        'TYPE'      =>  'STRING',
        'SORT'      =>  '20',
    ),
    'BUTTON' =>  array(
		"NAME" => 'Показывать кнопку перехода?',
        'REFRESH' => 'Y',
		"TYPE" => "CHECKBOX",
		"SORT" => "30",
		"DEFAULT" => "Y",
    ),
    'BUTTON_TEXT' =>  array(
        'NAME'      =>  'Текст кнопки перехода',
        'TYPE'      =>  'STRING',
        'SORT'      =>  '40',
    ),
    'BUTTON_LINK' =>  array(
        'NAME'      =>  'Ссылка кнопки перехода',
        'TYPE'      =>  'STRING',
        'SORT'      =>  '50',
    ),
 );
 ?>