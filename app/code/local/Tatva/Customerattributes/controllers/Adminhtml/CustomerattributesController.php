<?php

class Tatva_Customerattributes_Adminhtml_CustomerattributesController extends Mage_Adminhtml_Controller_Action
{
    protected $_entityTypeId;

    public function preDispatch()
    {
        parent::preDispatch();
        $this->_entityTypeId = Mage::getModel('eav/entity')->setType('customer')->getTypeId();
    }
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('customer/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));

		return $this;
	}
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

    public function newAction() {
		$this->_forward('edit');
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('attribute_id');
		$model = Mage::getModel('catalog/resource_eav_attribute')
            ->setEntityTypeId($this->_entityTypeId);

		if ($id) {
            $model->load($id);
             
            if (! $model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('customerattributes')->__('This attribute no longer exists'));
                $this->_redirect('*/*/');
                return;
            }

            // entity type check
            if ($model->getEntityTypeId() != $this->_entityTypeId) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('customerattributes')->__('This attribute cannot be edited.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        // set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getAttributeData(true);
        if (! empty($data)) {
            $model->addData($data);
        }
			Mage::register('entity_attribute', $model);
		   //	Mage::register('customerattributes_data', $model);

			$this->loadLayout();

            $this->_title($id ? $model->getName() : $this->__('New Attribute'));
			$this->_setActiveMenu('customer/items');

            $item = $id ? Mage::helper('catalog')->__('Edit Customer Attribute')
                    : Mage::helper('catalog')->__('New Customer Attribute');

            $this->_addBreadcrumb($item, $item);

		   /*	$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));*/

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->getLayout()->getBlock('attribute_edit_js')
            ->setIsPopup((bool)$this->getRequest()->getParam('popup'));

			/*$this->_addContent($this->getLayout()->createBlock('customerattributes/adminhtml_customerattributes_edit'))
				->_addLeft($this->getLayout()->createBlock('customerattributes/adminhtml_customerattributes_edit_tabs'));*/
             
			$this->renderLayout();
	   //else {
//			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('customerattributes')->__('Item does not exist'));
//			$this->_redirect('*/*/');
//		}
	}

    public function validateAction()
    {
        $response = new Varien_Object();
        $response->setError(false);

        $attributeCode  = $this->getRequest()->getParam('attribute_code');
        $attributeId    = $this->getRequest()->getParam('attribute_id');
        $attribute = Mage::getModel('catalog/resource_eav_attribute')
            ->loadByCode($this->_entityTypeId, $attributeCode);

        if ($attribute->getId() && !$attributeId) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('customerattributes')->__('Attribute with the same code already exists'));
            $this->_initLayoutMessages('adminhtml/session');
            $response->setError(true);
            $response->setMessage($this->getLayout()->getMessagesBlock()->getGroupedHtml());
        }

        $this->getResponse()->setBody($response->toJson());
    }

    protected function _filterPostData($data)
    {
        if ($data) {
            /** @var $helperCatalog Mage_Catalog_Helper_Data */
            $helperCatalog = Mage::helper('catalog');
            //labels
            foreach ($data['frontend_label'] as & $value) {
                if ($value) {
                    $value = $helperCatalog->stripTags($value);
                }
            }
        }
        return $data;
    }

    public function saveAction()
    {
        $data = $this->getRequest()->getPost();
		
        if ($data) {
            /** @var $session Mage_Admin_Model_Session */
            $session = Mage::getSingleton('adminhtml/session');

            $redirectBack   = $this->getRequest()->getParam('back', false);
            /* @var $model Mage_Catalog_Model_Entity_Attribute */
            $model = Mage::getModel('catalog/resource_eav_attribute');
            /* @var $helper Mage_Catalog_Helper_Product */
            $helper = Mage::helper('catalog/product');

            $id = $this->getRequest()->getParam('attribute_id');

            //validate attribute_code
            if (isset($data['attribute_code'])) {
                $validatorAttrCode = new Zend_Validate_Regex(array('pattern' => '/^[a-z][a-z_0-9]{1,254}$/'));
                if (!$validatorAttrCode->isValid($data['attribute_code'])) {
                    $session->addError(
                        Mage::helper('customerattributes')->__('Attribute code is invalid. Please use only letters (a-z), numbers (0-9) or underscore(_) in this field, first character should be a letter.')
                    );
                    $this->_redirect('*/*/edit', array('attribute_id' => $id, '_current' => true));
                    return;
                }
            }


            //validate frontend_input
            if (isset($data['frontend_input'])) {
                /** @var $validatorInputType Mage_Eav_Model_Adminhtml_System_Config_Source_Inputtype_Validator */
                $validatorInputType = Mage::getModel('eav/adminhtml_system_config_source_inputtype_validator');
                if (!$validatorInputType->isValid($data['frontend_input'])) {
                    foreach ($validatorInputType->getMessages() as $message) {
                        $session->addError($message);
                    }
                    $this->_redirect('*/*/edit', array('attribute_id' => $id, '_current' => true));
                    return;
                }
            }

            if ($id) {
                $model->load($id);

                if (!$model->getId()) {
                    $session->addError(
                        Mage::helper('customerattributes')->__('This Attribute no longer exists'));
                    $this->_redirect('*/*/');
                    return;
                }

                // entity type check
                if ($model->getEntityTypeId() != $this->_entityTypeId) {
                    $session->addError(
                        Mage::helper('customerattributes')->__('This attribute cannot be updated.'));
                    $session->setAttributeData($data);
                    $this->_redirect('*/*/');
                    return;
                }

                $data['attribute_code'] = $model->getAttributeCode();
                $data['is_user_defined'] = $model->getIsUserDefined();
                $data['frontend_input'] = $model->getFrontendInput();
            } else {
                /**
                * @todo add to helper and specify all relations for properties
                */
                $data['source_model'] = $helper->getAttributeSourceModelByInputType($data['frontend_input']);
                $data['backend_model'] = $helper->getAttributeBackendModelByInputType($data['frontend_input']);
            }

           // echo "<pre>";print_r($data);die;
                $data['visible_on_front'] = 1;
            if (!isset($data['is_configurable'])) {
                $data['is_configurable'] = 0;
            }
            if (!isset($data['is_filterable'])) {
                $data['is_filterable'] = 0;
            }
            if (!isset($data['is_filterable_in_search'])) {
                $data['is_filterable_in_search'] = 0;
            }

            if (is_null($model->getIsUserDefined()) || $model->getIsUserDefined() != 0) {
                $data['backend_type'] = $model->getBackendTypeByInput($data['frontend_input']);
            }

            $defaultValueField = $model->getDefaultValueByInput($data['frontend_input']);
            if ($defaultValueField) {
                $data['default_value'] = $this->getRequest()->getParam($defaultValueField);
            }

            if(!isset($data['apply_to'])) {
                $data['apply_to'] = array();
            }
			$flag = 0;
            //filter
            $data = $this->_filterPostData($data);
            $model->addData($data);

            if (!$id) {
                $model->setEntityTypeId($this->_entityTypeId);
                $model->setIsUserDefined(1);
				$flag = 1;
            }


            if ($this->getRequest()->getParam('set') && $this->getRequest()->getParam('group')) {
                // For creating product attribute on product page we need specify attribute set and group
                $model->setAttributeSetId($this->getRequest()->getParam('set'));
                $model->setAttributeGroupId($this->getRequest()->getParam('group'));
            }

            try {
                //echo "<pre>";print_r($data);die;
                $model->save();
                if($data['frontend_input'] == 'media_image')
                {
                    $model->setFrontendInput('image');
                    $model->save();
                }
				
                if(isset($data['used_in_forms']))
                {
				  	$use_in_froms = implode(',',$customer); 
                       Mage::getSingleton('eav/config')
                        ->getAttribute('customer', $data['attribute_code'])
                        ->setData('used_in_forms', $data['used_in_forms'])
                        ->save();	   
                }
				else
				{
					Mage::getSingleton('eav/config')
                        ->getAttribute('customer', $data['attribute_code'])
                        ->setData('used_in_forms', array())
                        ->save();
				}


                $session->addSuccess(
                    Mage::helper('customerattributes')->__('The customer attribute has been saved.'));
				
				if($flag == 1)
				{
					Mage::getResourceModel("customerattributes/customerattributes")->makeNewQuoteAttr($data['attribute_code']);
				}

                /**
                 * Clear translation cache because attribute labels are stored in translation
                 */
                Mage::app()->cleanCache(array(Mage_Core_Model_Translate::CACHE_TAG));
                $session->setAttributeData(false);
                if ($this->getRequest()->getParam('popup')) {
                    $this->_redirect('customerattributes/adminhtml_product/addAttribute', array(
                        'id'       => $this->getRequest()->getParam('product'),
                        'attribute'=> $model->getId(),
                        '_current' => true
                    ));
                } elseif ($redirectBack) {
                    $this->_redirect('*/*/edit', array('attribute_id' => $model->getId(),'_current'=>true));
                } else {
                    $this->_redirect('*/*/', array());
                }
                return;
            } catch (Exception $e) {
                $session->addError($e->getMessage());
                $session->setAttributeData($data);
                $this->_redirect('*/*/edit', array('attribute_id' => $id, '_current' => true));
                return;
            }
        }
	   
        $this->_redirect('*/*/');
    }
 
 /*	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {

			if(isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
				try {

					$uploader = new Varien_File_Uploader('filename');


	           		$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
					$uploader->setAllowRenameFiles(false);


					$uploader->setFilesDispersion(false);


					$path = Mage::getBaseDir('media') . DS ;
					$uploader->save($path, $_FILES['filename']['name'] );

				} catch (Exception $e) {

		        }


	  			$data['filename'] = $_FILES['filename']['name'];
			}


			$model = Mage::getModel('customerattributes/customerattributes');
			$model->setData($data)
				->setId($this->getRequest()->getParam('attribute_id'));

			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}

				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('customerattributes')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {*/
			  //		$this->_redirect('*/*/edit', array('attribute_id' => $model->getId()));
				   /*	return;
				}*/
			 //	$this->_redirect('*/*/');
				/*return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);*/
           //     $this->_redirect('*/*/edit', array('attribute_id' => $this->getRequest()->getParam('attribute_id')));
                /*return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('customerattributes')->__('Unable to find item to save'));*/
        //$this->_redirect('*/*/');
  /*	}   */

	public function deleteAction() {

        if ($id = $this->getRequest()->getParam('attribute_id')) {
            $model = Mage::getModel('catalog/resource_eav_attribute');

            // entity type check
            $model->load($id);
            if ($model->getEntityTypeId() != $this->_entityTypeId) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('customerattributes')->__('This attribute cannot be deleted.'));
                $this->_redirect('*/*/');
                return;
            }

            try {
                if($model->getIsUserDefined())
				{   
					Mage::getResourceModel("customerattributes/customerattributes")->deleteQuoteAttr($model->getAttributeCode());   					
			   		$model->delete();			
				}
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('customerattributes')->__('The product attribute has been deleted.'));
                $this->_redirect('*/*/');
                return;
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('attribute_id' => $this->getRequest()->getParam('attribute_id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('customerattributes')->__('Unable to find an attribute to delete.'));
        $this->_redirect('*/*/');


	}

    public function exportCsvAction()
    {
        $fileName   = 'customerattributes.csv';
        $content    = $this->getLayout()->createBlock('customerattributes/adminhtml_customerattributes_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'customerattributes.xml';
        $content    = $this->getLayout()->createBlock('customerattributes/adminhtml_customerattributes_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
}