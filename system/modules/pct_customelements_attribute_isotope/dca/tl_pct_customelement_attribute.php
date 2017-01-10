<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2013 Leo Feyer
 * 
 * @copyright	Tim Gatzky 2017, Premium Contao Webworks, Premium Contao Themes
 * @author		Tim Gatzky <info@tim-gatzky.de>
 * @package		pct_customelements
 * @attribute	Isotope eCommerce
 * @link		http://contao.org
 */

/**
 * Table tl_pct_customelement_attribute
 */
$objDcaHelper = \PCT\CustomElements\Helper\DcaHelper::getInstance()->setTable('tl_pct_customelement_attribute');
$strType = 'isotope';


/**
 * Palettes
 */
$arrPalettes = $objDcaHelper->getPalettesAsArray('default');
$arrPalettes = $objDcaHelper->removeField('eval_tl_class_w50');
$arrPalettes['settings_legend'] = array('options');
$GLOBALS['TL_DCA']['tl_pct_customelement_attribute']['palettes'][$strType] = $objDcaHelper->generatePalettes($arrPalettes);


/**
 * Fields
 */
if($objDcaHelper->getActiveRecord()->type == $strType)
{
	if(\Input::get('act') == 'edit' && \Input::get('table') == $objDcaHelper->getTable())
	{
		// Show template info
		\Message::addInfo(sprintf($GLOBALS['TL_LANG']['PCT_CUSTOMCATALOG']['MSC']['templateInfo_attribute'], 'customelement_attr_isotope'));
	}
	
	$GLOBALS['TL_DCA']['tl_pct_customelement_attribute']['fields']['options'][$strType]['options'] = array('variants');
	$GLOBALS['TL_DCA']['tl_pct_customelement_attribute']['fields']['options'][$strType]['reference'] = &$GLOBALS['TL_LANG']['tl_pct_customelement_attribute']['options'][$type];
}