<?php
/**
 * created : 14 oct. 2009
 * 
 * @category SQLI
 * @package Tatva_MarketPlaces
 * @author emchaabelasri
 * @copyright SQLI - 2009 - http://www.tatva.com
 * 
 * EXIG : REF-005
 * REG  : MARK-32106, MARK-32106
 */

/**
 * Description of the class
 * @package Tatva_MarketPlaces
 */
class Tatva_MarketPlaces_Model_Pixmania_Import_Media  extends  Tatva_MarketPlaces_Model_Pixmania_Import_Abstract {

	
	protected $_codeStep = 'MEDIA';
	
	protected function init(){
		$this->setMethod( Zend_Http_Client::POST );
		$this->setUrlParam( 'd' , 'webServices_Server' );
		$this->setUrlParam( 'c' , 'ServerRest' );		
		$this->setPostParameters( array( 
									   'rm'=>'importFileContr',
									   'rf'=>'importMedia',
									   'sl'=>Tatva_MarketPlaces_Model_Pixmania_Import_Abstract::KEY,
									   'FILENAME'=> $this->getCsvMedia()						 
		                                ) 
		                         );
	}
	
	protected function getCsvMedia(){
		return Mage::getModel( 'tatvamarketplaces/pixmania_catalogDivision_media')->runDivision();
	}	
	
	
}
