<?php

/*
 * @author     M2E Pro Developers Team
 * @copyright  2011-2015 ESS-UA [M2E Pro]
 * @license    Commercial use is forbidden
 */

class Ess_M2ePro_Model_StopQueue extends Ess_M2ePro_Model_Abstract
{
    //########################################

    public function _construct()
    {
        parent::_construct();
        $this->_init('M2ePro/StopQueue');
    }

    //########################################

    public function getItemData()
    {
        return $this->getData('item_data');
    }

    public function getDecodedItemData()
    {
        return Mage::helper('M2ePro')->jsonDecode($this->getItemData());
    }

    // ---------------------------------------

    public function getAccountHash()
    {
        return $this->getData('account_hash');
    }

    public function getMarketplaceId()
    {
        return $this->getData('marketplace_id');
    }

    public function getComponentMode()
    {
        return $this->getData('component_mode');
    }

    /**
     * @return bool
     */
    public function isProcessed()
    {
        return (bool)$this->getData('is_processed');
    }

    //########################################

    /**
     * @param Ess_M2ePro_Model_Listing_Product $listingProduct
     * @return bool
     * @throws Ess_M2ePro_Model_Exception_Logic
     */
    public function add(Ess_M2ePro_Model_Listing_Product $listingProduct)
    {
        if (!$listingProduct->isStoppable()) {
            return false;
        }

        $itemData = $this->getItemDataByListingProduct($listingProduct);

        if (is_null($itemData)) {
            return false;
        }

        $marketplaceNativeId = $listingProduct->isComponentModeEbay() ?
                                        $listingProduct->getMarketplace()->getNativeId() : NULL;

        $addedData = array(
            'item_data' => Mage::helper('M2ePro')->jsonEncode($itemData),
            'account_hash' => $listingProduct->getAccount()->getChildObject()->getServerHash(),
            'marketplace_id' => $marketplaceNativeId,
            'component_mode' => $listingProduct->getComponentMode(),
            'is_processed' => 0
        );

        Mage::getModel('M2ePro/StopQueue')->setData($addedData)->save();

        return true;
    }

    private function getItemDataByListingProduct(Ess_M2ePro_Model_Listing_Product $listingProduct)
    {
        $connectorName = ucfirst($listingProduct->getComponentMode()).'_Connector_';
        $connectorName .= $listingProduct->isComponentModeEbay() ? 'Item' : 'Product';
        $connectorName .= '_Stop_Requester';

        $connectorParams = array(
            'logs_action_id' => 0,
            'status_changer' => Ess_M2ePro_Model_Listing_Product::STATUS_CHANGER_UNKNOWN,
        );

        try {

            $dispatcher = Mage::getModel(
                'M2ePro/'.ucfirst($listingProduct->getComponentMode()).'_Connector_Dispatcher'
            );

            $connector = $dispatcher->getCustomConnector($connectorName, $connectorParams);
            $connector->setListingProduct($listingProduct);

            $itemData = $connector->getRequestDataPackage();
        } catch (Exception $exception) {
            return NULL;
        }

        if (!isset($itemData['data'])) {
            return NULL;
        }

        return $itemData['data'];
    }

    //########################################
}