<?php

/*
 * @author     M2E Pro Developers Team
 * @copyright  2011-2015 ESS-UA [M2E Pro]
 * @license    Commercial use is forbidden
 */

class Ess_M2ePro_Model_Amazon_Connector_Account_Add_ProcessingRunner
    extends Ess_M2ePro_Model_Connector_Command_Pending_Processing_Runner_Single
{
    //########################################

    protected function setLocks()
    {
        parent::setLocks();

        $params = $this->getParams();

        /** @var Ess_M2ePro_Model_Account $account */
        $account = Mage::helper('M2ePro/Component_Amazon')->getCachedObject('Account', $params['account_id']);

        $account->addProcessingLock(NULL, $this->getProcessingObject()->getId());
        $account->addProcessingLock('server_synchronize', $this->getProcessingObject()->getId());
        $account->addProcessingLock('adding_to_server', $this->getProcessingObject()->getId());
    }

    protected function unsetLocks()
    {
        parent::unsetLocks();

        $params = $this->getParams();

        /** @var Ess_M2ePro_Model_Account $account */
        $account = Mage::helper('M2ePro/Component_Amazon')->getCachedObject('Account', $params['account_id']);

        $account->deleteProcessingLocks(NULL, $this->getProcessingObject()->getId());
        $account->deleteProcessingLocks('server_synchronize', $this->getProcessingObject()->getId());
        $account->deleteProcessingLocks('adding_to_server', $this->getProcessingObject()->getId());
    }

    //########################################
}