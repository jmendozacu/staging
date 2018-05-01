<?php

/*
 * @author     M2E Pro Developers Team
 * @copyright  2011-2015 ESS-UA [M2E Pro]
 * @license    Commercial use is forbidden
 */

class Ess_M2ePro_Adminhtml_Wizard_RemovedEbay3rdPartyController
    extends Ess_M2ePro_Controller_Adminhtml_Ebay_WizardController
{
    //########################################

    protected function getNick()
    {
        return 'removedEbay3rdParty';
    }

    //########################################

    public function installationAction()
    {
        Mage::helper('M2ePro/Magento')->clearMenuCache();

        $this->setStatus(Ess_M2ePro_Helper_Module_Wizard::STATUS_COMPLETED);

        return $this->_redirect('*/adminhtml_ebay_listing/index/');
    }

    public function congratulationAction()
    {
        return $this->_redirect('*/adminhtml_ebay_listing/index/');
    }

    //########################################
}
