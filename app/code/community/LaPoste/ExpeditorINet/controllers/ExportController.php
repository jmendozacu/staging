<?php
/**
 * LaPoste_ExpeditorINet
 * 
 * @category    LaPoste
 * @package     LaPoste_ExpeditorINet
 * @copyright   Copyright (c) 2010 La Poste
 * @author 	    Smile (http://www.smile.fr) & Jibé
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class LaPoste_ExpeditorINet_ExportController extends Mage_Adminhtml_Controller_Action
{

    /**
     * Constructor
     */
    protected function _construct()
    {        
        $this->setUsedModuleName('LaPoste_ExpeditorINet');
    }

    /**
     * Main action : show orders list
     */
    public function indexAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('sales/expeditorinet/export')
            ->_addContent($this->getLayout()->createBlock('expeditorinet/export_orders'))
            ->renderLayout();
    }

    /**
     * convert civlity in letters to a code for Expeditor
     * @param civility : string
     */
    private function getExpeditorCodeForCivility($civility)
    {
      if (strtolower($civility) == 'm.') {
	return 2;
      } elseif (strtolower($civility) == 'mme') {
	return 3;
      } elseif (strtolower($civility) == 'mlle') {
        return 4;
      } else {
        return 1;
      }
    }

    /**
     * Export Action
     * Generates a CSV file to download
     */
    public function exportAction()
    {
	    /* get the orders */
        $orderIds = $this->getRequest()->getPost('order_ids');

        /**
         * Get configuration
         */
        $separator = Mage::helper('expeditorinet')->getConfigurationFieldSeparator();
        $delimiter = Mage::helper('expeditorinet')->getConfigurationFieldDelimiter();
        if ($delimiter == 'simple_quote') {
            $delimiter = "'";
        } else if ($delimiter == 'double_quotes') {
            $delimiter = '"';
        }
        $lineBreak = Mage::helper('expeditorinet')->getConfigurationEndOfLineCharacter();
        if ($lineBreak == 'lf') {
            $lineBreak = "\n";
        } else if ($lineBreak == 'cr') {
            $lineBreak = "\r";
        } else if ($lineBreak == 'crlf') {
            $lineBreak = "\r\n";
        }
        $fileExtension = Mage::helper('expeditorinet')->getConfigurationFileExtension();
        $fileCharset = Mage::helper('expeditorinet')->getConfigurationFileCharset();

        /* So Colissimo product codes for Hors Domicile */
        $hd_productcodes = array (
           'BPR',
           'ACP',
           'CIT',
           'A2P',
           'MRL',
           'CDI'
        );
                
        /* set the filename */
        $filename   = 'orders_export_'.Mage::getSingleton('core/date')->date('Ymd_His').$fileExtension;

        /* get company commercial name */
        $commercialName = Mage::helper('expeditorinet')->getCompanyCommercialName();

        /* initialize the content variable */
        $content = '';

        if (!empty($orderIds)) {
            foreach ($orderIds as $orderId) {

	            /* get the order */
                $order = Mage::getModel('sales/order')->load($orderId);

                //if the product code is for Hors Domicile we should take the billing address
                if($order->getRelayId() != 0)
                 {
                	$address = $order->getBillingAddress();
                 }
                 else
                 {
                    $address = $order->getShippingAddress();
                 } 
				
				             
                /* real order id */
                $content = $this->_addFieldToCsv($content, $delimiter, $order->getRealOrderId()); //1
                $content .= $separator;
				$content = $this->_addFieldToCsv($content, $delimiter, $order->getRealOrderId()); //2
                $content .= $separator;
                /* customer first name */
                $content = $this->_addFieldToCsv($content, $delimiter, $address->getFirstname()); //3
                $content .= $separator;
                /* customer last name */
                $content = $this->_addFieldToCsv($content, $delimiter, $address->getLastname()); //4
                $content .= $separator;
                /* customer company */
                $content = $this->_addFieldToCsv($content, $delimiter, $address->getCompany());  //5
                $content .= $separator;
                /* street address, on 4 fields */
                $content = $this->_addFieldToCsv($content, $delimiter, $address->getStreet(1));  //6
                $content .= $separator;
                $content = $this->_addFieldToCsv($content, $delimiter, $address->getStreet(2));  //7
                $content .= $separator;
                $content = $this->_addFieldToCsv($content, $delimiter, $address->getStreet(3));  //8
                $content .= $separator;
                $content = $this->_addFieldToCsv($content, $delimiter, $address->getStreet(4));  //9
                $content .= $separator;
                /* postal code */
                $content = $this->_addFieldToCsv($content, $delimiter, $address->getPostcode()); //10
                $content .= $separator;
                /* city */
                $content = $this->_addFieldToCsv($content, $delimiter, $address->getCity());  //11
                $content .= $separator;
                /* country code */
                $content = $this->_addFieldToCsv($content, $delimiter, $address->getCountry()); //12
                $content .= $separator;
                /* telephone */
                /*$telephone = '';
                if ($order->getSocoPhoneNumber() != '' && $order->getSocoPhoneNumber() != null) {
                	$telephone = $order->getSocoPhoneNumber();
                } elseif ($address->getTelephone() != '' && $address->getTelephone() != null) {
                	$telephone = $address->getTelephone();
                }
                $content = $this->_addFieldToCsv($content, $delimiter, $telephone);
                $content .= $separator;*/
				
				/*telephone */
                $content = $this->_addFieldToCsv($content, $delimiter, $address->getTelephone()); //13
                $content .= $separator;

                /*mobile phone */
                $content = $this->_addFieldToCsv($content, $delimiter, $address->getMobilephone()); //14
                $content .= $separator;
                /* code produit */
                $content = $this->_addFieldToCsv($content, $delimiter, $order->getRelayCode()); //15
                $content .= $separator;    
                /* instruction de livraison */
				$_history = $order->getAllStatusHistory();
				
				foreach($_history as $_historyItem): 
				  if ( $_historyItem->getData('is_visible_on_front') == 1): 
			        $_buffer = $_historyItem->getData('comment'); 
				  endif; 
				endforeach;
                $content = $this->_addFieldToCsv($content, $delimiter, $_buffer ); //16
                $content .= $separator;
                /* civilite */
                $content = $this->_addFieldToCsv($content, $delimiter, $address->getPrefix());  //17
                $content .= $separator; 
               
                /* code porte 2 */
                $content = $this->_addFieldToCsv($content, $delimiter, $address->getDigitalToAccess()); //18
                $content .= $separator; 
				
				 $content = $this->_addFieldToCsv($content, $delimiter, ''); //19
                 $content .= $separator;                  
                /* Interphone */
                $content = $this->_addFieldToCsv($content, $delimiter, $address->getEntryPhone());  //20
                $content .= $separator; 
                /* Code point retrait */
                $content = $this->_addFieldToCsv($content, $delimiter, $order->getRelayId());  //21
                $content .= $separator;    
                /* E-mail de suivi socolissimo */
                $content = $this->_addFieldToCsv($content, $delimiter, $order->getCustomerEmail());  //22
                $content .= $separator;                                                   

                /* total weight */
                $total_weight = 0;
                $items = $order->getAllItems();
                foreach ($items as $item) {
                    $total_weight += $item['row_weight'];
                }
                $content = $this->_addFieldToCsv($content, $delimiter, $total_weight); //23
                $content .= $separator;

                /* company commercial name */
                $content = $this->_addFieldToCsv($content, $delimiter, "AZ BOUTIQUE FRANCE"); //24
                $content .= $lineBreak;
            }

            /* decode the content, depending on the charset */
            if ($fileCharset == 'ISO-8859-1') {
            	$content = utf8_decode($content);
            }

            /* pick file mime type, depending on the extension */
            if ($fileExtension == '.txt') {
            	$fileMimeType = 'text/plain';
            } else if ($fileExtension == '.csv') {
            	$fileMimeType = 'application/csv';
            } else {
            	// default
                $fileMimeType = 'text/plain';
            }

            /* download the file */
            return $this->_prepareDownloadResponse($filename, $content, $fileMimeType .'; charset="'. $fileCharset .'"');
        }
        else {
	        $this->_getSession()->addError($this->__('No Order has been selected'));
        }
    }

    /**
     * Add a new field to the csv file
     * @param csvContent : the current csv content
     * @param fieldDelimiter : the delimiter character
     * @param fieldContent : the content to add
     * @return : the concatenation of current content and content to add
     */
    private function _addFieldToCsv($csvContent, $fieldDelimiter, $fieldContent) {
	    return $csvContent . $fieldDelimiter . $fieldContent . $fieldDelimiter;
    }

}
