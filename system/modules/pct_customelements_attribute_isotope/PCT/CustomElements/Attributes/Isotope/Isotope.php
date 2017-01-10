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
namespace PCT\CustomElements\Attributes;

/**
 * Class file
 * Isotope
 */
class Isotope extends \PCT\CustomElements\Core\Attribute
{
	/**
	 * Return the field definition
	 * @return array
	 */
	public function getFieldDefinition()
	{
		$arrEval = $this->getEval();
		
		$arrEval['chosen'] = true;
		
		$arrReturn = array
		(
			'label'			=> array( $this->get('title'),$this->get('description') ),
			'exclude'		=> true,
			'inputType'		=> 'select',
			'eval'			=> $arrEval,
			'foreignKey'	=> 'tl_iso_product.name',
			'relation'		=> array('type'=>'belongsToMany', 'load'=>'lazy'),
			'sql'			=> "int(10) NOT NULL default '0'",
		);
		
		return $arrReturn;
	}


	/**
	 * Generate the attribute in the frontend
	 * @param string
	 * @param mixed
	 * @param array
	 * @param string
	 * @param object
	 * @param object
	 * @return string
	 * called renderCallback method
	 */
	public function renderCallback($strField,$varValue,$objTemplate,$objAttribute)
	{
		if(empty($varValue))
		{
			$objTemplate->empty = true;
			return $objTemplate->parse();
		}
		
		// find the product
		$objProduct = \Isotope\Model\Product::findPublishedByIdOrAlias($varValue);
		if($objProduct === null)
		{
			$objTemplate->empty = true;
			$objTemplate->parse();
		}
		
		// @var object 
		$objModule = new \StdClass;
		$objModule->iso_use_quantity = true;
		$arrConfig = array('module'=>$objModule);	
		
		// unique form name
		$strIdent = 'item_'.$objAttribute->getActiveRecord()->id.'_attr_'.$objAttribute->id.'_product_'.$varValue;
		
		// duplicated attribute
		if($objAttribute->isCopy)
		{
			$strIdent .= '_'.(isset($objAttribute->numCopy) ? $objAttribute->numCopy : $objAttribute->uuid);
		}
		
		$objTemplate->product = $objProduct;
		$objTemplate->attribute = $objAttribute;
		$objTemplate->formID = $strIdent;
		$objTemplate->action = \Environment::get('request');
		$objTemplate->submitLabel = $GLOBALS['TL_LANG']['MSC']['buttonLabel']['add_to_cart'];
		
		// variants
		$arrOptions = deserialize($objAttribute->get('options'));
		$arrVariantAttributes = $objProduct->getVariantAttributes() ?: array();
		$arrVariants = array();
		if(in_array('variants', $arrOptions) && !empty($arrVariantAttributes))
		{
			$arrVariantOptions = array();
			
			$objResult = $objDatabase = \Database::getInstance()->prepare("SELECT * FROM tl_iso_product WHERE id=?")->limit(1)->execute($objProduct->id);
			
			// unregistrer current model	
			$objRegistry = \Contao\Model\Registry::getInstance();
			$objRegistry->unregister($objProduct);
			
			// @var object Helper instance to access protected methods
			$objProductHelper = new \PCT\CustomElements\Attributes\Isotope\ProductHelper($objResult);
			
			foreach ($arrVariantAttributes  as $attribute) 
			{
	            $arrData = $GLOBALS['TL_DCA']['tl_iso_product']['fields'][$attribute];
				if ($arrData['attributes']['customer_defined'] || $arrData['attributes']['variant_option']) 
				{
					$strWidget = $objProductHelper->generateProductOptionWidget($attribute, $arrVariantOptions, array());
					if($strWidget != '') 
	                {
	                    $arrVariants[$attribute] = array_merge($arrData, array
	                    (
	                        'name'    => $attribute,
	                        'html'    => $strWidget,
	                    ));
	                }
				}
	        }
		}
		
		$objTemplate->hasVariants = (count($arrVariants) > 0 ? true : false);
		$objTemplate->variants = $arrVariants;
		\PC::debug($arrVariants);
		
		
		// simulate addToCart
		if(\Input::post('FORM_SUBMIT') == $strIdent)
		{
			// @var object \Isotope\Frontend
			$objIsotopeFrontend = new \Isotope\Frontend;
			$objIsotopeFrontend->addToCart($objProduct,$arrConfig);
		}
		
		return $objTemplate->parse();
	}
	
	
	/**
	 * Generate wildcard value
	 * @param mixed
	 * @param object	DatabaseResult
	 * @param integer	Id of the Element ( >= CE 1.2.9)
	 * @param string	Name of the table ( >= CE 1.2.9)
	 * @return string
	 */
	 public function processWildcardValue($varValue,$objAttribute,$intElement=0,$strTable='')
	 {
		if($objAttribute->get('type') != 'isotope' || empty($varValue))
	 	{
	 		return $varValue;
	 	}
	 	return \Isotope\Model\Product::findByPk($varValue)->name;
	 }
}