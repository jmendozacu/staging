<?php
/**
 * LaPoste_ExpeditorINet
 * 
 * @category    LaPoste
 * @package     LaPoste_ExpeditorINet
 * @copyright   Copyright (c) 2010 La Poste
 * @author 	    Smile (http://www.smile.fr) & Jibé
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class LaPoste_ExpeditorINet_Model_Config_Source_FileExtension
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'.txt', 'label'=>Mage::helper('expeditorinet')->__('.txt')),
            array('value'=>'.csv', 'label'=>Mage::helper('expeditorinet')->__('.csv'))
        );
    }
}
