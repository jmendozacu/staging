<?php
/* * *************************************************************************************************************************
 *  SupplierLog.php
 * ************************************************************************************************************************** */
class MDN_DropShipping_Model_Mysql4_SupplierLog extends Mage_Core_Model_Mysql4_Abstract
{
	
    public function _construct()
    {    
        $this->_init('DropShipping/SupplierLog', 'dssl_id');
    }
    
}
?>