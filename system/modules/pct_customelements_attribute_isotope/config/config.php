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
 * Register attribute
 */
$GLOBALS['PCT_CUSTOMELEMENTS']['ATTRIBUTES']['isotope'] = array
(
	'label'		=> &$GLOBALS['TL_LANG']['PCT_CUSTOMELEMENTS']['ATTRIBUTES']['isotope'],
	'class'		=> 'PCT\CustomElements\Attributes\Isotope',
	'icon'		=> 'fa fa-shopping-cart',
#	'backendWildcardSize' => array('50','50','center center'),
);

/**
 * Hooks
 */
$GLOBALS['CUSTOMELEMENTS_HOOKS']['processWildcardValue'][] = array('PCT\CustomElements\Attributes\Isotope','processWildcardValue');
