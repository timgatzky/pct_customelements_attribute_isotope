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
 * Namespace
 */
namespace PCT\CustomElements\Attributes\Isotope;

/**
 * Class file
 * ProductHelper
 */
class ProductHelper extends \Isotope\Model\Product\Standard
{
	/**
	 * Public access to generateProductOptionWidget
	 */
	public function generateProductOptionWidget($strField, $arrVariantOptions, $arrAjaxOptions=array())
	{
		return parent::generateProductOptionWidget($strField, $arrVariantOptions, $arrAjaxOptions);
	}
}