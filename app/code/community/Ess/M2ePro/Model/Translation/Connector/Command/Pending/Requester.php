<?php

/*
 * @author     M2E Pro Developers Team
 * @copyright  2011-2015 ESS-UA [M2E Pro]
 * @license    Commercial use is forbidden
 */

abstract class Ess_M2ePro_Model_Translation_Connector_Command_Pending_Requester
    extends Ess_M2ePro_Model_Connector_Command_Pending_Requester
{
    /**
     * @var Ess_M2ePro_Model_Account|null
     */
    protected $account = NULL;

    // ########################################

    public function __construct(array $params = array(),
                                Ess_M2ePro_Model_Account $account = NULL)
    {
        $this->account = $account;
        parent::__construct($params);
    }

    //########################################

    protected function buildRequestInstance()
    {
        $request = parent::buildRequestInstance();

        $requestData = $request->getData();
        if (!is_null($this->account)) {
            $requestData['account'] = $this->account->getChildObject()->getTranslationHash();
        }
        $request->setData($requestData);

        return $request;
    }

    //########################################

    protected function getProcessingParams()
    {
        $params = parent::getProcessingParams();

        if (!is_null($this->account)) {
            $params['account_id'] = $this->account->getId();
        }

        return $params;
    }

    protected function getResponserParams()
    {
        $params = parent::getResponserParams();

        if (!is_null($this->account)) {
            $params['account_id'] = $this->account->getId();
        }

        return $params;
    }

    //########################################
}
