<?php


class MDN_Mpm_Model_Mysql4_PricingLog_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('Mpm/PricingLog');
    }
}