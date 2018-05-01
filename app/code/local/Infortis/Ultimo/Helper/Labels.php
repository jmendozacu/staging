<?php

class Infortis_Ultimo_Helper_Labels extends Mage_Core_Helper_Abstract
{
	/**
	 * Get product labels (HTML)
	 *
	 * @return string
	 */
	public function getLabels($product)
	{
            $stock = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product->getId());
            $qty = intval($stock->getQty());
            
		$html = '';
                $store_id=Mage::app()->getStore()->getStoreId();
		$isNew = false;
		if (Mage::getStoreConfig('ultimo/product_labels/new'))
		{	
			$isNew = $this->isNew($product);
		}
		
		$isSale = false;
		if (Mage::getStoreConfig('ultimo/product_labels/sale'))
		{
			$isSale = $this->isOnSale($product);
		}

		if ($isNew == true)
		{
			$html .= '<span class="sticker-wrapper top-right"><span class="sticker new">' . $this->__('New') . '</span></span>';
		}


        $promo=$this->getPromotion($product);

        if($promo['percent']>0 && $promo['type']!='')
        {
            if($promo['type']==1)
            {
                
 $html .="<span class='sticker-wrapper top-left'><img src='".Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN)."frontend/az-boutique/default/images/tatvalabels/labels/promotions/promotion-".$promo['percent'].".png'/></span>";
            }
            else
            {
                 if($store_id=='1' || $store_id=='6' || $store_id=='12')
                {
                     
               // $html .="<span class='sticker-wrapper top-left'><img src='".Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN)."frontend/az-boutique/default/images/tatvalabels/labels/soldes/soldes-".$promo['percent'].".png'/></span>";
                     if($product->getTypeId() == "bundle")
                     {
                         //$bundle_availability = mage::helper('SalesOrderPlanning/ProductAvailabilityStatus')->getForOneProduct($product->getId())->getpa_available_qty();
                         //$availability = mage::helper('AdvancedStock/Product_Base')->getStocks($product->getId());
                         $productAvailabilityStatus = mage::getModel('SalesOrderPlanning/ProductAvailabilityStatus')->load($product->getId(), 'pa_product_id');
                         $msg = Mage::helper('BundleAvailability')->getAvailabilityMessageForBundleviewandlistpage($product->getId());
                         $expl = explode(",",$msg);
                         $stockmsg = $expl[0];
                         //echo $this->__($stockmsg);die();
                         //echo "<pre>";print_r($availability->getData());die();
                         if($stockmsg == trim($this->__("In stock")))
                         {
                             
                                 $html .="<span class='sticker-wrapper top-left'><img src='".Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN)."frontend/az-boutique/default/images/tatvalabels/labels/soldes/soldes-".$promo['percent'].".png'/></span>";     
                         }
                         else
                         {
                                 $html .="<span class='sticker-wrapper top-left'><img src='".Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN)."frontend/az-boutique/default/images/tatvalabels/labels/promotions/promotion-".$promo['percent'].".png'/></span>";
                         }
                            
                         
                        
                     }
                     if($product->getTypeId() == "simple")
                     {
                         //$inStock = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product)->getIsInStock();
                         if($qty>0)
                         {
                              $html .="<span class='sticker-wrapper top-left'><img src='".Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN)."frontend/az-boutique/default/images/tatvalabels/labels/soldes/soldes-".$promo['percent'].".png'/></span>";  
                         }
                         else
                         {
                             $html .="<span class='sticker-wrapper top-left'><img src='".Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN)."frontend/az-boutique/default/images/tatvalabels/labels/promotions/promotion-".$promo['percent'].".png'/></span>";
                         }
                      
                     }
                     
                }
                elseif($store_id=='3' || $store_id=='4')
                {

                  $html .="<span class='sticker-wrapper top-left'><img src='".Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN)."frontend/az-boutique/default/images/tatvalabels/labels/sales/sale-".$promo['percent'].".png'/></span>";
                }
                else
                {

                }

           }
        }
		else
		{

		  $per=$this->isOnSalediscount($product);
          if($per>0)
          {
		    if($store_id=='1' || $store_id=='6' || $store_id=='12')
            {
              $html .="<span class='sticker-wrapper top-left'><img src='".Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN)."frontend/az-boutique/default/images/tatvalabels/flashsale/ventes-flash/vente-flash-".$per.".png'/></span>";
            }
            elseif($store_id=='3' || $store_id=='4')
            {
             $html .="<span class='sticker-wrapper top-left'><img src='".Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN)."frontend/az-boutique/default/images/tatvalabels/flashsale/flash-sales/flash-sale-".$per.".png'/></span>";
            }
            else
            {

            }
          }
		}
		
		return $html;
	}
	
	/**
	 * Check if "new" label is enabled and if product is marked as "new"
	 *
	 * @return  bool
	 */
	public function isNew($product)
	{
		return $this->_nowIsBetween($product->getData('news_from_date'), $product->getData('news_to_date'));
	}
	
	/**
	 * Check if "sale" label is enabled and if product has special price
	 *
	 * @return  bool
	 */
	public function isOnSale($product)
	{
		$specialPrice = number_format($product->getFinalPrice(), 2);
		$regularPrice = number_format($product->getPrice(), 2);

		if ($specialPrice != $regularPrice)
			return $this->_nowIsBetween($product->getData('special_from_date'), $product->getData('special_to_date'));
		else
			return false;
	}


    public function isOnSalediscount($product)
	{
	     $percent=0;
         $specialPrice = number_format($product->getFinalPrice(), 2);
		 $regularPrice = number_format($product->getPrice(), 2);
         $percent = 100 - ($specialPrice * 100 / $regularPrice);
         if($percent>0)
         {
           $percent=intval($percent);
         }
        return $percent;
	}
	
	protected function _nowIsBetween($fromDate, $toDate)
	{
		if ($fromDate)
		{
			$fromDate = strtotime($fromDate);
			$toDate = strtotime($toDate);
			$now = strtotime(Mage::app()->getLocale()->date()->setTime('00:00:00')->toString(Varien_Date::DATETIME_INTERNAL_FORMAT));
			
			if ($toDate)
			{
				if ($fromDate <= $now && $now <= $toDate)
					return true;
			}
			else
			{
				if ($fromDate <= $now)
					return true;
			}
		}
		
		return false;
   }

     public function getPromotion($product){
		$promo = array();   $protion_type=''; $promotion_final='';$percent_final=0;
		$customerGroupId = 0;
		$catalogRuleProducts = Mage::getModel("catalogrule/rule_product_price")->getCollection()
								->addFieldToFilter('main_table.website_id',Mage::app()->getWebsite()->getId())

								->addFieldToFilter('main_table.customer_group_id',$customerGroupId);

		$catalogRuleProducts->getSelect()->where('main_table.product_id = ?', $product->getId());

		$tableName = Mage::getModel('catalogrule/rule_product_price')->getResource()->getTable('catalogrule/rule_product');
		$catalogRuleProducts->getSelect()
			->from(array('rule_product' => $tableName), 'rule_id')
			->where ('rule_product.product_id = main_table.product_id ')
			->where('rule_product.customer_group_id = ?',$customerGroupId)
			->where('rule_product.website_id = ?',Mage::app()->getWebsite()->getId());


		if(!$catalogRuleProducts->getSize()){
        }
        else
        {

		foreach($catalogRuleProducts as $catalogRule)
        {

                $store_id = Mage::app()->getStore()->getStoreId();
                $webs_id = Mage::app()->getWebsite()->getId(); 

                #Mage::log(__FILE__." :: getPromotion(): store_id=$store_id, webs_id=$webs_id");

		$rule = Mage::getModel('catalogrule/rule')->load($catalogRule->getRuleId());
		$oldPrice = Mage::app()->getHelper('tax')->getPrice($product, $product->getPrice(), true, null, null, null, $store_id, null) ;
		$newPrice = Mage::app()->getHelper('tax')->getPrice($product, $catalogRule->getRulePrice(), true, null, null, null, $store_id, null) ;

        $fromDate = date ('d/m/Y');
  		if($rule->getFromDate())
          {
           $fromDate = $rule->getFromDate();
  		  }

        $toDate = "";
  		if($rule->getToDate())
        {
          $toDate = $rule->getToDate();
        }


       if($rule->getSimpleAction() == 'by_percent' || $rule->getSimpleAction() == 'to_percent'){
	   $percent_final = $rule->getDiscountAmount();
	   }
       else
       {
	   $percent = 100 - ($newPrice * 100 / $oldPrice);
	   $percent_final = $percent;
	   }

       $protion_type = $rule->getpromotion_type() == 'NULL' ? '' : $rule->getpromotion_type();

				break;
			}
		}
       $promo['percent']=  intVal($percent_final);
       $promo['type']=  $protion_type;
      // echo "<pre>";print_r($promo);
		return $promo;
	}
}
