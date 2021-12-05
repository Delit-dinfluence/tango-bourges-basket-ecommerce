<?php
/**
 * 2007-2020 ETS-Soft
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 wesite only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses. 
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 * 
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please contact us for extra customization service at an affordable price
 *
 *  @author ETS-Soft <etssoft.jsc@gmail.com>
 *  @copyright  2007-2020 ETS-Soft
 *  @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */
 
include_once('../../config/config.inc.php');
include_once('../../init.php');

if (!defined('_PS_VERSION_'))
	exit;

include_once('ybc_nivoslider.php');

$context = Context::getContext();
$home_slider = new Ybc_nivoslider();
$slides = array();

if (!Tools::isSubmit('secure_key') || Tools::getValue('secure_key') != $home_slider->secure_key || !Tools::getValue('action'))
	die(1);

if (Tools::getValue('action') == 'updateSlidesPosition' && Tools::getValue('slides'))
{

	$slides = Tools::getValue('slides');
    $res = true;
	foreach ($slides as $position => $id_slide)
	{
		$res &= Db::getInstance()->execute('
			UPDATE `'._DB_PREFIX_.'ybcnivoslider_slides` SET `position` = '.(int)$position.'
			WHERE `id_homeslider_slides` = '.(int)$id_slide
		);

	}
	$home_slider->clearCache();
    die(json_encode(array('res'=>$res)));
}