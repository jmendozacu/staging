<?php

class Autocompleteplus_Autosuggest_Model_Renderer_Catalog_Product extends Autocompleteplus_Autosuggest_Model_Renderer_Abstract
{
    protected $_standardImageFields = array('image', 'small_image', 'thumbnail');
    protected $_useAttributes;
    protected $_attributes;
    protected $_xmlGenerator;
    protected $_categories;
    protected $_configurableAttributes;
    protected $_configurableChildren;
    protected $_configurableChildrenIds;
    protected $_saleable;
    protected $_simpleProductIds;
    protected $_xmlElement;
    protected $_productAttributes;
    protected $_product;
    protected $_rootCategoryId;
    protected $_outputHelper;

    public function setXmlElement(&$xmlGenerator)
    {
        $this->_xmlElement = $xmlGenerator;
        return $this;
    }

    public function getXmlElement()
    {
        return $this->_xmlElement;
    }

    public function setProduct($product)
    {
        $this->_product = $product;
        return $this;
    }

    public function getProduct()
    {
        return $this->_product;
    }

    public function getImageField()
    {
        if (!$this->_imageField) {
            $this->_imageField = Mage::getStoreConfig('autocompleteplus/config/imagefield');
        }
        return $this->_imageField;
    }

    public function canUseAttributes()
    {
        if (!$this->_useAttributes) {
            $this->_useAttributes = Mage::getStoreConfigFlag('autocompleteplus/config/attributes');
        }
        return $this->_useAttributes;
    }

    public function getRootCategoryId()
    {
        if (!$this->_rootCategoryId) {
            $this->_rootCategoryId = Mage::app()->getStore($this->getStoreId())->getRootCategoryId();
        }
        return $this->_rootCategoryId;
    }

    public function getSaleable()
    {
        return !!$this->_saleable;
    }

    public function getConfigurableChildren()
    {
        return $this->getProduct()->getTypeInstance()->getUsedProducts();
    }

    public function getConfigurableChildrenIds()
    {
        $configurableChildrenIds = array();
        foreach ($this->getConfigurableChildren() as $child) {
            $configurableChildrenIds[] = $child->getId();
            if ($this->getProduct()->isInStock()) {
                if (method_exists($child, 'isSaleable') && !$child->isSaleable()) {
                    // the simple product is probably disabled (because its in stock)
                    continue;
                }
                $this->_saleable = true;
            }
        }

        return $configurableChildrenIds;
    }

    public function getProductCollection($new = false)
    {
        if (!$this->_productCollection) {
            $this->_productCollection = Mage::getModel('catalog/product')->getCollection();
        }

        if ($new === true) {
            return Mage::getModel('catalog/product')->getCollection();
        }

        return $this->_productCollection;
    }

    public function getCategoryMap()
    {
        if (!$this->_categories) {
            $categoryMap = array();
            $categories = Mage::getModel('catalog/category')->getCollection();

            foreach ($categories as $category) {
                $categoryMap[] = new Varien_Object(array(
                    'id' => $category->getId(),
                    'path' => $category->getPath(),
                    'parent_id' => $category->getParentId(),
                ));
            }
            $this->_categories = $categoryMap;
        }
        return $this->_categories;
    }

    public function getSimpleProductsPriceOfConfigurable()
    {
        $simple_products_price = array();
        $pricesByAttributeValues = array();
        $attributes = $this->getProduct()->getTypeInstance(true)->getConfigurableAttributes($this->getProduct());
        $basePrice = $this->getProduct()->getFinalPrice();
        $items = $attributes->getItems();
        if (is_array($items)) {
            foreach ($items as $attribute) {
                $prices = $attribute->getPrices();
                if (is_array($prices)) {
                    foreach ($prices as $price) {
                        if ($price['is_percent']) { //if the price is specified in percents
                            $pricesByAttributeValues[$price['value_index']] = (float) $price['pricing_value'] * $basePrice / 100;
                        } else { //if the price is absolute value
                            $pricesByAttributeValues[$price['value_index']] = (float) $price['pricing_value'];
                        }
                    }
                }
            }
        }

        foreach ($this->getConfigurableChildren() as $sProduct) {
            $totalPrice = $basePrice;
            foreach ($attributes as $attribute) {
                $value = $sProduct->getData($attribute->getProductAttribute()->getAttributeCode());
                if (isset($pricesByAttributeValues[$value])) {
                    $totalPrice += $pricesByAttributeValues[$value];
                }
            }
            $simple_products_price[$sProduct->getId()] = $totalPrice;
        }

        return $simple_products_price;
    }

    public function getCategoryPathsByProduct()
    {
        $productCategories = $this->getProduct()->getCategoryIds();
        $rootCategoryId = $this->getRootCategoryId();
        $paths = array_map(function ($category) use ($productCategories, $rootCategoryId) {
            if (in_array($category->getId(), $productCategories)) {
                $path = explode('/', $category->getPath());
                //we don't want the root category for the entire site
                array_shift($path);
                if ($rootCategoryId &&
                    is_array($path) &&
                    isset($path[0]) &&
                    $path[0] != $rootCategoryId
                ) {
                    return array();
                }
                //we want more specific categories first
                return implode(':', array_reverse($path));
            }
        }, $this->getCategoryMap());
        return array_filter($paths);
    }

    public function getConfigurableAttributes()
    {
        // Collect options applicable to the configurable product
        $productAttributeOptions = $this->getProduct()->getTypeInstance()->getConfigurableAttributesAsArray($this->getProduct());
        $configurableAttributes = array();

        foreach ($productAttributeOptions as $productAttribute) {
            $attributeFull = Mage::getModel('eav/config')->getAttribute('catalog_product', $productAttribute['attribute_code']);
            foreach ($productAttribute['values'] as $attribute) {
                $configurableAttributes[$productAttribute['store_label']]['values'][] = $attribute['store_label'];
            }
            $configurableAttributes[$productAttribute['store_label']]['is_filterable'] = $attributeFull['is_filterable'];
            $configurableAttributes[$productAttribute['store_label']]['frontend_input'] = $attributeFull['frontend_input'];
        }
        return $configurableAttributes;
    }

    public function getProductAttributes()
    {
        return $this->getProduct()->getTypeInstance()->getConfigurableAttributes($this->getProduct());
    }

    public function getPriceRange()
    {
        $pricesByAttributeValues = array();
        $attributes = $this->getProductAttributes();
        $basePrice = $this->getProduct()->getFinalPrice();
        $items = $attributes->getItems();
        $min_price = null;
        $max_price = null;
        $totalPrice = false;
        if (is_array($items)) {
            foreach ($items as $attribute) {
                $prices = $attribute->getPrices();
                if (is_array($prices)) {
                    foreach ($prices as $price) {
                        if ($price['is_percent']) { //if the price is specified in percents
                            $pricesByAttributeValues[$price['value_index']] = (float)$price['pricing_value'] * $basePrice / 100;
                        } else { //if the price is absolute value
                            $pricesByAttributeValues[$price['value_index']] = (float)$price['pricing_value'];
                        }
                    }
                }
            }
        }

        $simple = $this->getConfigurableChildren();
        foreach ($simple as $sProduct) {
            $totalPrice = $basePrice;
            foreach ($attributes as $attribute) {
                $value = $sProduct->getData($attribute->getProductAttribute()->getAttributeCode());
                if (isset($pricesByAttributeValues[$value])) {
                    $totalPrice += $pricesByAttributeValues[$value];
                }
            }
            if (!$min_price || $totalPrice < $min_price){
                $min_price = $totalPrice;
            }
            if (!$max_price || $totalPrice > $max_price){
                $max_price = $totalPrice;
            }
        }
        if (is_null($min_price)){
            $min_price = 0;
        }
        if (is_null($max_price)){
            $max_price = 0;
        }
        
        return array(
            'price_min' => $min_price,
            'price_max' => $max_price
        );
    }

    public function getSimpleProductParent()
    {
        return Mage::getModel('catalog/product_type_configurable')
                ->getParentIdsByChild($this->getProduct()->getId());
    }

    public function getOrdersPerProduct()
    {
        $productIds = implode(',', $this->getProductCollection()->getAllIds());
        $salesOrderItemCollection = Mage::getResourceModel('sales/order_item_collection');
        $salesOrderItemCollection->getSelect()->reset(Zend_Db_Select::COLUMNS)
            ->columns(array('product_id', array('qty_ordered' => 'SUM(qty_ordered)')))
            ->where(new Zend_Db_Expr('store_id = ' . $this->getStoreId()))
            ->where(new Zend_Db_Expr('product_id IN (' . $productIds . ')'))
            ->where(new Zend_Db_Expr('created_at BETWEEN NOW() - INTERVAL ' . $this->getMonthInterval() . ' MONTH AND NOW()'))
            ->group(array('product_id'));

        $products = array();

        foreach ($salesOrderItemCollection as $item) {
            $products[$item['product_id']] = (int)$item['qty_ordered'];
        }

        return $products;
    }

    public function getOrderCount()
    {
        $orderData = $this->getOrderData();
        return ($this->getOrderData() != null && array_key_exists($this->getProduct()->getId(), $orderData)) ? $orderData[$this->getProduct()->getId()] : 0;
    }

    public function getProductResource()
    {
        return Mage::getResourceSingleton('catalog/product');
    }

    /**
     * @TODO Refactor indentation/conditions
     */
    public function renderProductVariantXml($productXmlElem)
    {
        if ($this->canUseAttributes()) {
            if ($this->getProduct()->isConfigurable() && count($this->getConfigurableAttributes()) > 0) {
                $variants = array();
                foreach ($this->getConfigurableAttributes() as $attrName => $confAttrN) {
                    if (is_array($confAttrN) && array_key_exists('values', $confAttrN)) {
                        $variants[] = $attrName;
                        $values = implode(' , ', $confAttrN['values']);
                        $this->getXmlElement()->createChild('attribute', array(
                            'is_configurable' => 1,
                            'is_filterable' => $confAttrN['is_filterable'],
                            'name' => $attrName
                        ),
                            $values,
                            $productXmlElem
                        );
                    }
                }

                $simple_products_price = $this->getSimpleProductsPriceOfConfigurable();

                if (count($variants) > 0) {
                    $variantElem = $this->getXmlElement()->createChild('variants', false, false, $productXmlElem);
                    foreach ($this->getConfigurableChildren() as $child_product) {
                        if (!in_array($this->getProduct()->getStoreId(), $child_product->getStoreIds())) {
                            continue;
                        }

                        $is_variant_in_stock = ($child_product->getStockItem()->getIsInStock()) ? 1 : 0;

                        if (method_exists($child_product, 'isSaleable')) {
                            $is_variant_sellable = ($child_product->isSaleable()) ? 1 : 0;
                        } else {
                            $is_variant_sellable = '';
                        }

                        if (method_exists($child_product, 'getVisibility')) {
                            $is_variant_visible = ($child_product->getVisibility()) ? 1 : 0;
                        } else {
                            $is_variant_visible = '';
                        }

                        $variant_price = (array_key_exists($child_product->getId(), $simple_products_price)) ?
                            $simple_products_price[$child_product->getId()] : '';


                        $productVariation = $this->getXmlElement()->createChild('variant', array(
                            'id' => $child_product->getId(),
                            'type' => $child_product->getTypeID(),
                            'visibility' => $is_variant_visible,
                            'is_in_stock' => $is_variant_in_stock,
                            'is_seallable' => $is_variant_sellable,
                            'price' => $variant_price
                        ), false, $variantElem);

                        $this->getXmlElement()->createChild('name', false, $child_product->getName(), $productVariation);

                        $attributes = $child_product->getAttributes();
                        foreach ($attributes as $attribute) {
                            if (!$attribute['is_configurable'] || !in_array($attribute['store_label'], $variants)) {
                                continue;
                            }

                            if (!$attribute['store_label']){
                                // skip variant attribute without a name
                                continue;
                            }
                            
                            $this->getXmlElement()->createChild('variant_attribute', array(
                                'is_configurable' => 1,
                                'is_filterable' => $attribute->getIsFilterable(),
                                'name' => $attribute['store_label'],
                                'name_code' => $attribute->getId(),
                                'value_code' => $child_product->getData($attribute->getAttributeCode())
                            ), utf8_encode(htmlspecialchars($attribute->getFrontend()->getValue($child_product))), $productVariation
                            );
                        }
                    }
                }
            }
        }
    }

    public function renderProductAttributeXml($attr, $productXmlElem)
    {
        if ($this->canUseAttributes()) {
            $action = $attr->getAttributeCode();
            $is_filterable = $attr->getIsFilterable();
            $attribute_label = $attr->getFrontendLabel();
            $attrValue = null;
            $_helper=$this->_getOutputHelper();

            switch ($attr->getFrontendInput()) {
                case 'select':
                    $attrValue = method_exists($this->getProduct(), 'getAttributeText') ?
                        $_helper->productAttribute($this->getProduct(),$this->getProduct()->getAttributeText($action),$action)
                        : $this->getProduct()->getData($action);
                    break;
                case 'textarea':
                case 'price':
                case 'text':
                    $attrValue = $this->getProduct()->getData($action);
                    break;
                case 'multiselect':
                    $attrValue = $this->getProduct()->getResource()
                        ->getAttribute($action)->getFrontend()->getValue($this->getProduct());
                    break;
            }

            if ($attrValue) {
                $attributeElem = $this->getXmlElement()->createChild('attribute', array(
                    'is_filterable' => $is_filterable,
                    'name' => $attr->getAttributeCode()
                ), false, $productXmlElem);

                $this->getXmlElement()->createChild('attribute_values', false,
                    $attrValue, $attributeElem);
                $this->getXmlElement()->createChild('attribute_label', false,
                    $attribute_label, $attributeElem);
            }
        }
    }

    public function renderXml()
    {
        $categories = $this->getCategoryPathsByProduct();
        $saleable = $this->getProduct()->isSalable() ? 1 : 0;

        if ($this->getProduct()->isConfigurable()) {
            $priceRange = $this->getPriceRange();
        } elseif ($this->getProduct()->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_SIMPLE) {
            $priceRange = array('price_min' => 0, 'price_max' => 0);
        } else {
            $priceRange = array('price_min' => 0, 'price_max' => 0);
        }

        $productElement = $this->getXmlElement()->createChild('product', array(
            'price_min' =>  ($priceRange['price_min']),
            'price_max' =>  ($priceRange['price_max']),
            'store' =>  ($this->getStoreId()),
            'store_id'  =>  ($this->getStoreId()),
            'storeid'   =>  ($this->getStoreId()),
            'id'    =>  ($this->getProduct()->getId()),
            'type'  =>  ($this->getProduct()->getTypeId()),
            'currency'  =>  ($this->getCurrency()),
            'visibility'    =>  ($this->getProduct()->getVisibility()),
            'price' =>  ($this->getProduct()->getFinalPrice()),
            'url'   =>  (Mage::helper('catalog/product')->getProductUrl($this->getProduct()->getId())),
            'thumbs'    =>   utf8_encode(htmlspecialchars((Mage::helper('catalog/image')->init($this->getProduct(), $this->getImageField())))),
            'base_image'    =>  utf8_encode(htmlspecialchars((Mage::getModel('catalog/product_media_config')->getMediaUrl($this->getProduct()->getImage())))),
            'selleable' =>  ($saleable),
            'action'    =>  ($this->getAction()),
            'get_by_id_status'  =>  1,
            'last_updated'  =>  ($this->getProduct()->getUpdatedAt()),
            'updatedate'    =>  ($this->getUpdateDate()),
            'get_by_id_status'  =>  intval($this->getGetByIdStatus())
        ));
//Mage::getResourceModel('catalog/product')->getAttributeRawValue($this->getProduct()->getId(), 'description', $this->getStoreId());
        $productRating = $this->getProduct()->getRatingSummary();
        $this->getXmlElement()->createChild('description', false,
            $this->getProduct()->getDescription(), $productElement);
        $this->getXmlElement()->createChild('short', false,
            $this->getProduct()->getShortDescription(), $productElement);
        $this->getXmlElement()->createChild('name', false,
            $this->getProduct()->getName(), $productElement);
        $this->getXmlElement()->createChild('sku', false,
            $this->getProduct()->getSku(), $productElement);
        
        $this->getXmlElement()->createChild('url_additional', false,
                $this->_getAdditionalProductUrl(), $productElement);
        
        if ($productRating) {
            $this->getXmlElement()->createChild('review', false, $productRating->getRatingSummary(),
                $productElement);
            $this->getXmlElement()->createChild('reviews_count', false,
                $productRating->getReviewsCount(), $productElement);
        }

        $newFromDate = $this->getProduct()->getNewsFromDate();
        $newToDate = $this->getProduct()->getNewsToDate();
        if ($newFromDate) {
            $this->getXmlElement()->createChild('newfrom', false,
                Mage::getModel('core/date')->timestamp($newFromDate), $productElement);
            if ($newToDate) {
                $this->getXmlElement()->createChild('newto', false,
                    Mage::getModel('core/date')->timestamp($newToDate), $productElement);
            }
        }

        $this->getXmlElement()->createChild('purchase_popularity', false,
            $this->getOrderCount(), $productElement);
        $this->getXmlElement()->createChild('product_status', false,
            (($this->getProduct()->getStatus() == Mage_Catalog_Model_Product_Status::STATUS_ENABLED) ? 1 : 0), $productElement);
        $this->getXmlElement()->createChild('creation_date', false,
            Mage::getModel('core/date')->timestamp($this->getProduct()->getCreatedAt()), $productElement);
        $this->getXmlElement()->createChild('updated_date', false,
            Mage::getModel('core/date')->timestamp($this->getProduct()->getUpdatedAt()), $productElement);

        if ($this->canUseAttributes()) {
            foreach ($this->getAttributes() as $attr) {
                $this->renderProductAttributeXml($attr, $productElement);
            }
        }

        if ($this->getProduct()->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_SIMPLE) {
            $this->getXmlElement()->createChild('product_parents', false,
                implode(',', $this->getSimpleProductParent()), $productElement);
        }

        if ($this->getProduct()->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE) {
            $this->getXmlElement()->createChild('simpleproducts', false,
                implode(',', $this->getConfigurableChildrenIds()), $productElement);
            $this->renderProductVariantXml($productElement);
        }

        $this->getXmlElement()->createChild('categories', false,
            implode(';', $categories), $productElement);
        
        $this->getXmlElement()->createChild('meta_title', false,
                $this->getProduct()->getMetaTitle(), $productElement);
        $this->getXmlElement()->createChild('meta_description', false,
                $this->getProduct()->getMetaDescription(), $productElement);

    }

    protected function _getOutputHelper()
    {

        if($this->_outputHelper==null){
            $this->_outputHelper = Mage::helper('catalog/output');
        }

        return $this->_outputHelper;
    }
    
    public function _getAdditionalProductUrl()
    {
        $is_get_url_path_supported = true;
        if (method_exists('Mage' , 'getVersionInfo')){  // getUrlPath is not supported on EE 1.13... & 1.14...
            $edition_info = Mage::getVersionInfo();
            if ($edition_info['major'] == 1 && $edition_info['minor'] >= 13){
                $is_get_url_path_supported = false;
            }
        }
        
        if (method_exists($this->getProduct(), 'getUrlPath') && $is_get_url_path_supported){
            $product_url = $this->getProduct()->getUrlPath();
            if ($product_url != ''){
                $product_url = Mage::getUrl($product_url);
                return $product_url;
            }
        }
        return '';
    }
}
