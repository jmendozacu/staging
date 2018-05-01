<?php

/*
 * @author     M2E Pro Developers Team
 * @copyright  2011-2015 ESS-UA [M2E Pro]
 * @license    Commercial use is forbidden
 */

class Ess_M2ePro_Model_Amazon_Synchronization_OtherListings_Update_Blocked_Requester
    extends Ess_M2ePro_Model_Amazon_Connector_Inventory_Get_Blocked_ItemsRequester
{
    //########################################

    protected function getProcessingRunnerModelName()
    {
        return 'Amazon_Synchronization_OtherListings_Update_Blocked_ProcessingRunner';
    }

    //########################################
}