<?php

/*
 * @author     M2E Pro Developers Team
 * @copyright  2011-2015 ESS-UA [M2E Pro]
 * @license    Commercial use is forbidden
 */

class Ess_M2ePro_Block_Adminhtml_Common_Buy_Account_Edit_Tabs_ListingOther extends Mage_Adminhtml_Block_Widget
{
    //########################################

    public function __construct()
    {
        parent::__construct();

        // Initialization block
        // ---------------------------------------
        $this->setId('buyAccountEditTabsListingOther');
        // ---------------------------------------

        $this->setTemplate('M2ePro/common/buy/account/tabs/listing_other.phtml');
    }

    protected function _beforeToHtml()
    {
        /** @var Ess_M2ePro_Helper_Magento_Attribute $magentoAttributeHelper */
        $magentoAttributeHelper = Mage::helper('M2ePro/Magento_Attribute');

        $generalAttributes = $magentoAttributeHelper->getGeneralFromAllAttributeSets();

        $this->attributes = $magentoAttributeHelper->filterByInputTypes(
            $generalAttributes, array(
                'text', 'textarea', 'select'
            )
        );

        return parent::_beforeToHtml();
    }

    //########################################
}