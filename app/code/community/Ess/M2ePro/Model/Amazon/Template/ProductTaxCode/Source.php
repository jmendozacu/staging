<?php

/*
 * @author     M2E Pro Developers Team
 * @copyright  2011-2015 ESS-UA [M2E Pro]
 * @license    Commercial use is forbidden
 */

class Ess_M2ePro_Model_Amazon_Template_ProductTaxCode_Source
{
    /**
     * @var Ess_M2ePro_Model_Magento_Product $magentoProduct
     */
    private $magentoProduct = null;

    /**
     * @var Ess_M2ePro_Model_Amazon_Template_ProductTaxCode $productTaxCodeTemplateModel
     */
    private $productTaxCodeTemplateModel = null;

    //########################################

    /**
     * @param Ess_M2ePro_Model_Magento_Product $magentoProduct
     * @return $this
     */
    public function setMagentoProduct(Ess_M2ePro_Model_Magento_Product $magentoProduct)
    {
        $this->magentoProduct = $magentoProduct;
        return $this;
    }

    /**
     * @return Ess_M2ePro_Model_Magento_Product
     */
    public function getMagentoProduct()
    {
        return $this->magentoProduct;
    }

    // ---------------------------------------

    /**
     * @param Ess_M2ePro_Model_Amazon_Template_ProductTaxCode $instance
     * @return $this
     */
    public function setProductTaxCodeTemplate(Ess_M2ePro_Model_Amazon_Template_ProductTaxCode $instance)
    {
        $this->productTaxCodeTemplateModel = $instance;
        return $this;
    }

    /**
     * @return Ess_M2ePro_Model_Amazon_Template_ProductTaxCode
     */
    public function getProductTaxCodeTemplate()
    {
        return $this->productTaxCodeTemplateModel;
    }

    //########################################

    /**
     * @return string
     */
    public function getProductTaxCode()
    {
        $result = '';

        switch ($this->getProductTaxCodeTemplate()->getProductTaxCodeMode()) {
            case Ess_M2ePro_Model_Amazon_Template_ProductTaxCode::PRODUCT_TAX_CODE_MODE_VALUE:
                $result = $this->getProductTaxCodeTemplate()->getProductTaxCodeValue();
                break;

            case Ess_M2ePro_Model_Amazon_Template_ProductTaxCode::PRODUCT_TAX_CODE_MODE_ATTRIBUTE:
                $result = $this->getMagentoProduct()->getAttributeValue(
                    $this->getProductTaxCodeTemplate()->getProductTaxCodeAttribute()
                );
                break;
        }

        return $result;
    }

    //########################################
}