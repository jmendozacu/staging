<?php

class MDN_Mpm_Model_Mysql4_Product_Setting extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('Mpm/Product_Setting', 'id');
    }
}
