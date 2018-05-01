<?php

/*
 * @author     M2E Pro Developers Team
 * @copyright  2011-2015 ESS-UA [M2E Pro]
 * @license    Commercial use is forbidden
 */

class Ess_M2ePro_Model_Ebay_Listing_Product_Action_Type_Revise_Response
    extends Ess_M2ePro_Model_Ebay_Listing_Product_Action_Type_Response
{
    //########################################

    public function processSuccess(array $response, array $responseParams = array())
    {
        $data = array(
            'status' => Ess_M2ePro_Model_Listing_Product::STATUS_LISTED
        );

        if ($this->getConfigurator()->isDefaultMode()) {
            $data['synch_status'] = Ess_M2ePro_Model_Listing_Product::SYNCH_STATUS_OK;
            $data['synch_reasons'] = NULL;
        }

        $data = $this->appendStatusHiddenValue($data);
        $data = $this->appendStatusChangerValue($data, $responseParams);

        $data = $this->appendOnlineBidsValue($data);
        $data = $this->appendOnlineQtyValues($data);
        $data = $this->appendOnlinePriceValues($data);
        $data = $this->appendOnlineInfoDataValues($data);

        $data = $this->appendOutOfStockValues($data);
        $data = $this->appendItemFeesValues($data, $response);
        $data = $this->appendStartDateEndDateValues($data, $response);
        $data = $this->appendGalleryImagesValues($data, $response, $responseParams);

        $data = $this->appendIsVariationMpnFilledValue($data);
        $data = $this->appendVariationsThatCanNotBeDeleted($data, $response);

        if (isset($data['additional_data'])) {
            $data['additional_data'] = Mage::helper('M2ePro')->jsonEncode($data['additional_data']);
        }

        $this->getListingProduct()->addData($data)->save();

        $this->updateVariationsValues(true);
        $this->updateEbayItem();

        if ($this->getEbayAccount()->isPickupStoreEnabled() && $this->getConfigurator()->isVariationsAllowed()) {
            $this->runAccountPickupStoreStateUpdater();
        }
    }

    public function processAlreadyStopped(array $response, array $responseParams = array())
    {
        $responseParams['status_changer'] = Ess_M2ePro_Model_Listing_Product::STATUS_CHANGER_COMPONENT;

        $data = array(
            'status' => Ess_M2ePro_Model_Listing_Product::STATUS_STOPPED
        );

        $data = $this->appendStatusChangerValue($data, $responseParams);
        $data = $this->appendStartDateEndDateValues($data, $response);

        if (!isset($data['additional_data'])) {
            $data['additional_data'] = $this->getListingProduct()->getAdditionalData();
        }

        $data['additional_data']['ebay_item_fees'] = array();
        $data['additional_data'] = Mage::helper('M2ePro')->jsonEncode($data['additional_data']);

        $this->getListingProduct()->addData($data)->save();
    }

    //########################################

    /**
     * @return string
     */
    public function getSuccessfulMessage()
    {
        if ($this->getConfigurator()->isDefaultMode()) {
            // M2ePro_TRANSLATIONS
            // Item was successfully Revised
            return 'Item was successfully Revised';
        }

        $sequenceString = '';

        if ($this->getConfigurator()->isVariationsAllowed() && $this->getRequestData()->isVariationItem()) {
            // M2ePro_TRANSLATIONS
            // Variations
            $sequenceString .= 'Variations,';
        } else {
            if ($this->getConfigurator()->isQtyAllowed()) {
                // M2ePro_TRANSLATIONS
                // QTY
                $sequenceString .= 'QTY,';
            }

            if ($this->getConfigurator()->isPriceAllowed()) {
                // M2ePro_TRANSLATIONS
                // Price
                $sequenceString .= 'Price,';
            }
        }

        if ($this->getConfigurator()->isTitleAllowed()) {
            // M2ePro_TRANSLATIONS
            // Title
            $sequenceString .= 'Title,';
        }

        if ($this->getConfigurator()->isSubtitleAllowed()) {
            // M2ePro_TRANSLATIONS
            // Subtitle
            $sequenceString .= 'Subtitle,';
        }

        if ($this->getConfigurator()->isDescriptionAllowed()) {
            // M2ePro_TRANSLATIONS
            // Description
            $sequenceString .= 'Description,';
        }

        if ($this->getConfigurator()->isImagesAllowed()) {
            // M2ePro_TRANSLATIONS
            // Images
            $sequenceString .= 'Images,';
        }

        if (empty($sequenceString)) {
            // M2ePro_TRANSLATIONS
            // Item was successfully Revised
            return 'Item was successfully Revised';
        }

        // M2ePro_TRANSLATIONS
        // was successfully Revised
        return ucfirst(trim($sequenceString,',')).' was successfully Revised';
    }

    //########################################

    protected function appendOnlineBidsValue($data)
    {
        if ($this->getEbayListingProduct()->isListingTypeFixed()) {
            return parent::appendOnlineBidsValue($data);
        }
        return $data;
    }

    protected function appendOnlineQtyValues($data)
    {
        $data = parent::appendOnlineQtyValues($data);

        $data['online_qty_sold'] = (int)$this->getEbayListingProduct()->getOnlineQtySold();
        isset($data['online_qty']) && $data['online_qty'] += $data['online_qty_sold'];

        return $data;
    }

    protected function appendOnlinePriceValues($data)
    {
        $data = parent::appendOnlinePriceValues($data);

        // if auction item has bids, we do not know correct online_current_price after revise action
        if ($this->getRequestData()->hasPriceStart() &&
            $this->getEbayListingProduct()->isListingTypeAuction() &&
            $this->getEbayListingProduct()->getOnlineBids()) {
            unset($data['online_current_price']);
        }

        return $data;
    }

    // ---------------------------------------

    protected function appendItemFeesValues($data, $response)
    {
        if (!isset($data['additional_data'])) {
            $data['additional_data'] = $this->getListingProduct()->getAdditionalData();
        }

        if (isset($response['ebay_item_fees'])) {

            foreach ($response['ebay_item_fees'] as $feeCode => $feeData) {

                if ($feeData['fee'] == 0) {
                    continue;
                }

                if (!isset($data['additional_data']['ebay_item_fees'][$feeCode])) {
                    $data['additional_data']['ebay_item_fees'][$feeCode] = $feeData;
                } else {
                    $data['additional_data']['ebay_item_fees'][$feeCode]['fee'] += $feeData['fee'];
                }
            }
        }

        return $data;
    }

    // ---------------------------------------

    private function updateEbayItem()
    {
        $data = array(
            'account_id'     => $this->getAccount()->getId(),
            'marketplace_id' => $this->getMarketplace()->getId(),
            'product_id'     => (int)$this->getListingProduct()->getProductId(),
            'store_id'       => (int)$this->getListing()->getStoreId()
        );

        if ($this->getRequestData()->isVariationItem() && $this->getRequestData()->getVariations()) {

            $variations = array();
            $requestMetadata = $this->getRequestMetaData();

            foreach ($this->getRequestData()->getVariations() as $variation) {

                $channelOptions = $variation['specifics'];
                $productOptions = $variation['specifics'];

                if (empty($requestMetadata['variations_specifics_replacements'])) {

                    $variations[] = array(
                        'product_options' => $productOptions,
                        'channel_options' => $channelOptions,
                    );
                    continue;
                }

                foreach ($requestMetadata['variations_specifics_replacements'] as $productValue => $channelValue) {

                    if (!isset($productOptions[$channelValue])) {
                        continue;
                    }

                    $productOptions[$productValue] = $productOptions[$channelValue];
                    unset($productOptions[$channelValue]);
                }

                $variations[] = array(
                    'product_options' => $productOptions,
                    'channel_options' => $channelOptions,
                );
            }

            $data['variations'] = Mage::helper('M2ePro')->jsonEncode($variations);
        }

        $object = $this->getEbayListingProduct()->getEbayItem();
        $object->addData($data)->save();

        return $object;
    }

    //########################################
}