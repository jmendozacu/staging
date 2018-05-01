<?php
/*
 * 1997-2012 Quadra Informatique
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0) that is available
 * through the world-wide-web at this URL: http://www.opensource.org/licenses/OSL-3.0
 * If you are unable to obtain it through the world-wide-web, please send an email
 * to ecommerce@quadra-informatique.fr so we can send you a copy immediately.
 *
 *  @author Quadra Informatique <ecommerce@quadra-informatique.fr>
 *  @copyright 1997-2012 Quadra Informatique
 *  @version Release: $Revision: 2.0.4 $
 *  @license http://www.opensource.org/licenses/OSL-3.0  Open Software License (OSL 3.0)
 */

class Quadra_Cybermutforeign_Model_Payment extends Mage_Payment_Model_Method_Abstract
{
    protected $_code  = 'cybermutforeign_payment';
    protected $_formBlockType = 'cybermutforeign/form';

    // Cybermutforeign return codes of payment
    const RETURN_CODE_ACCEPTED      = 'paiement';
    const RETURN_CODE_TEST_ACCEPTED = 'payetest';
    const RETURN_CODE_ERROR         = 'Annulation';
   

    // Payment configuration
    protected $_isGateway               = false;
    protected $_canAuthorize            = true;
    protected $_canCapture              = true;
    protected $_canCapturePartial       = false;
    protected $_canRefund               = false;
    protected $_canVoid                 = false;
    protected $_canUseInternal          = false;
    protected $_canUseCheckout          = true;
    protected $_canUseForMultishipping  = true;

    // Order instance
    protected $_order = null;

    /**
     *  Return CyberMut protocol version
     *
     *  @param    none
     *  @return	  string Protocol version
     */
    protected function getVersion()
    {
        if (!$version = $this->getConfigData('version')) {
            $version = '1.2open';
        }

        return $version;
    }

    /**
     *  Returns Target URL
     *
     *  @return	  string Target URL
     */
    public function getCybermutforeignUrl()
    {
        $url = '';
        switch ($this->getConfigData('bank')) {
            default:
            case 'mutuel':
                $url = $this->getConfigData('test_mode') ? 'https://paiement.creditmutuel.fr/test/paiement.cgi' : 'https://paiement.creditmutuel.fr/paiement.cgi';
                break;
            case 'cic':
                $url = $this->getConfigData('test_mode') ? 'https://ssl.paiement.cic-banques.fr/test/paiement.cgi' : 'https://ssl.paiement.cic-banques.fr/paiement.cgi';
                break;
            case 'obc':
                $url = $this->getConfigData('test_mode') ? 'https://ssl.paiement.banque-obc.fr/test/paiement.cgi' : 'https://ssl.paiement.banque-obc.fr/paiement.cgi';
                break;
        }
        return $url;
    }

    /**
     *  Return back URL
     *
     *  @return	  string URL
     */
    protected function getReturnURL()
    {
        return $this->getErrorURL();
    }

    /**
     *  Return URL for Cybermutforeign success response
     *
     *  @return	  string URL
     */
    protected function getSuccessURL()
    {
        return Mage::getUrl('cybermutforeign/payment/success', array('_secure' => true));
    }

    /**
     *  Return URL for Cybermutforeign failure response
     *
     *  @return	  string URL
     */
    protected function getErrorURL()
    {
        return Mage::getUrl('cybermutforeign/payment/error', array('_secure' => true));
    }

    /**
     *  Return URL for Cybermutforeign notify response
     *
     *  @return	  string URL
     */
    protected function getNotifyURL()
    {
        return Mage::getUrl('cybermutforeign/payment/notify', array('_secure' => true));
    }

    /**
     * Get quote model
     *
     * @return Mage_Sales_Model_Quote
     */
    public function getQuote() {
        if (!$this->_quote) {
            $quoteId = Mage::getSingleton('checkout/session')->getLastQuoteId();
            $this->_quote = Mage::getModel('sales/quote')->load($quoteId);
        }
        return $this->_quote;
    }

    /**
     * Get real order ids
     *
     * @return string
     */
    public function getOrderList()
    {
        if ($this->getQuote()->getIsMultiShipping())
            return Mage::getSingleton('checkout/session')->getRealOrderIds();
        else
            return $this->getOrder()->getRealOrderId();
    }

    /**
     * Capture payment
     *
     * @param   Varien_Object $orderPayment
     * @return  Mage_Payment_Model_Abstract
     */
    public function capture(Varien_Object $payment, $amount)
    {
        $payment->setStatus(self::STATUS_APPROVED)
                ->setLastTransId($this->getTransactionId());

        return $this;
    }

    /**
     * Validate payment method information object
     *
     * @param   Varien_Object $info
     * @return  Mage_Payment_Model_Abstract
     */
    public function validate()
    {
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        $quote->setCustomerNoteNotify(false);
        parent::validate();
    }

    /**
     *  Form block description
     *
     *  @return	 object
     */
    public function createFormBlock($name)
    {
        $block = $this->getLayout()->createBlock('cybermutforeign/form_payment', $name);
        $block->setMethod($this->_code);
        $block->setPayment($this->getPayment());

        return $block;
    }

    /**
     *  Return Order Place Redirect URL
     *
     *  @return	  string Order Redirect URL
     */
    public function getOrderPlaceRedirectUrl()
    {
        Mage::getSingleton('checkout/session')->setIsMultishipping(false);

        return Mage::getUrl('cybermutforeign/payment/redirect');
    }

    public function getAmount() {
        if ($this->getQuote()->getIsMultiShipping()) {
            $amount = $this->getQuote()->getBaseGrandTotal();
        } else {
            $amount = $this->getOrder()->getBaseGrandTotal();
        }

        return sprintf('%.2f', $amount);
    }

    /**
     *  Return Standard Checkout Form Fields for request to Cybermutforeign
     *
     *  @return	  array Array of hidden form fields
     */
    public function getStandardCheckoutFormFields()
    {
        $session = Mage::getSingleton('checkout/session');

        $order = $this->getOrder();
        if (!($order instanceof Mage_Sales_Model_Order)) {
            Mage::throwException($this->_getHelper()->__('Cannot retrieve order object'));
        }

        $oder_id = $this->getOrderList();
        $description = $this->getConfigData('description') ? $this->getConfigData('description') : Mage::helper('cybermutforeign')->__('Order %s', $oder_id);

        $fields = array(
            'version' => $this->getVersion(),
            'TPE' => $this->getConfigData('tpe_no'),
            'date' => date('d/m/Y:H:i:s'),
            'montant' => $this->getAmount() . $order->getBaseCurrencyCode(),
            'reference' => $oder_id,
            'texte-libre' => $oder_id,
            'lgue' => $this->_getLanguageCode(),
            'societe' => $this->getConfigData('site_code'),
            'url_retour' => Mage::getUrl(),
            'url_retour_ok' => $this->getSuccessURL(),
            'url_retour_err' => $this->getErrorURL(),
            'bouton' => 'ButtonLabel'
        );

        if (((int) $this->getVersion()) >= 3) {
            $fields['mail'] = $order->getCustomerEmail();
        }

        $fields['MAC'] = $this->_getMAC($fields);

        $fields = $this->getSplitCheckoutFormFields($fields);

        return $fields;
    }

    /**
     *  Return Split Checkout Form Fields for request to Cybermutforeign
     *
     *  @return	  array Array of hidden form fields
     */
    public function getSplitCheckoutFormFields($fields)
    {
        if ($this->getConfigData('several_times_payment')) {
            $nbTerms = $this->getQuote()->getPayment()->getNbrech();

            if ($nbTerms > 1) {
                $amount = $this->getAmount();

                $fields['nbrech'] = $nbTerms;

                $terms = array(
                    'montantech1' => round($amount/$nbTerms, 2),
                    'dateech1' => date('d/m/Y'));

                for ($i=2; $i<$nbTerms+1; $i++) {
                    $terms['montantech'.$i] = $terms['montantech1'];
                    $dateech = '+ '.($i-1).' month';
                    $terms['dateech'.$i] = date('d/m/Y', strtotime($dateech));
                }

                if ($terms['montantech1']*$nbTerms != $amount) {
                    $result = $terms['montantech1']*($nbTerms-1);
                    $terms['montantech1'] = $amount-$result;
                }

                $fields = array_merge($fields, $terms);
            }
        }

        return $fields;
    }

    /**
     *  Return vars to pur in the URL
     *  Fabrication des données GET au cas où la transmission Cybermutforeign -> serveur Magento n'a pas fonctionnée
     *
     *  @param	  array
     *  @return	  String
     */
    protected function _getUrlVars($code_retour)
    {
        $order = $this->getOrder();
        $session = Mage::getSingleton('checkout/session');

        $oorder_id = $order->getRealOrderId();
        $description = $this->getConfigData('description') ? $this->getConfigData('description') : Mage::helper('cybermutforeign')->__('Order %s', $oorder_id);

        $get['retourPLUS'] = "--no-option";
        $get['TPE'] = $this->getConfigData('tpe_no');
        $get['date'] = date('d/m/Y:H:i:s');
        $get['montant'] = sprintf('%.2f', $order->getBaseGrandTotal()) . $order->getBaseCurrencyCode();
        $get['reference'] = $oorder_id;
        $get['texte-libre'] = $oorder_id;
        $get['code-retour'] = $code_retour;

        return "?MAC=" . $this->getResponseMAC($get)
                . "&TPE=" . $this->getConfigData('tpe_no')
                . "&date=" . date('d/m/Y:H:i:s')
                . "&montant=" . sprintf('%.2f', $order->getBaseGrandTotal()) . $order->getBaseCurrencyCode()
                . "&reference=" . $order->getRealOrderId()
                . "&texte-libre=" . $oorder_id
                . "&code-retour=" . $code_retour
                . "&retourPLUS=--no-option";
    }

    /**
     *  Prepare string for MAC generation
     *
     *  @param    none
     *  @return	  string MAC string
     */
    protected function _getMAC($data)
    {
    	if (((int) $this->getVersion()) >= 3) {
            $string = sprintf('%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*', $data['TPE'], $data['date'], $data['montant'], $data['reference'], $data['texte-libre'], $data['version'], $data['lgue'], $data['societe'], $data['mail'], "", "", "", "", "", "", "", "", "");
        } else {
            $string = sprintf('%s*%s*%s*%s*%s*%s*%s*%s*', $data['TPE'], $data['date'], $data['montant'], $data['reference'], $data['texte-libre'], $data['version'], $data['lgue'], $data['societe']);
        }

        return $this->_CMCIC_hmac($string);
    }

    /**
     *  Return MAC string on basis of Cybermutforeign response data
     *
     *  @param    none
     *  @return	  string MAC
     */
    public function getResponseMAC($data)
    {
    	if (((int) $this->getVersion()) >= 3) {
            if (!array_key_exists('numauto', $data)) {
                $data['numauto'] = "";
            }
            if (!array_key_exists('motifrefus', $data)) {
                $data['motifrefus'] = "";
            }
            if (!array_key_exists('originecb', $data)) {
                $data['originecb'] = "";
            }
            if (!array_key_exists('bincb', $data)) {
                $data['bincb'] = "";
            }
            if (!array_key_exists('hpancb', $data)) {
                $data['hpancb'] = "";
            }
            if (!array_key_exists('ipclient', $data)) {
                $data['ipclient'] = "";
            }
            if (!array_key_exists('originetr', $data)) {
                $data['originetr'] = "";
            }
            if (!array_key_exists('veres', $data)) {
                $data['veres'] = "";
            }
            if (!array_key_exists('pares', $data)) {
                $data['pares'] = "";
            }

            $string = sprintf('%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*', $data['TPE'], $data['date'], $data['montant'], $data['reference'], $data['texte-libre'], '3.0', $data['code-retour'], $data['cvx'], $data['vld'], $data['brand'], $data['status3ds'], $data['numauto'], $data['motifrefus'], $data['originecb'], $data['bincb'], $data['hpancb'], $data['ipclient'], $data['originetr'], $data['veres'], $data['pares']);
        } else {
            $string = sprintf('%s%s+%s+%s+%s+%s+%s+%s+', $data['retourPLUS'], $data['TPE'], $data['date'], $data['montant'], $data['reference'], $data['texte-libre'], $this->getVersion(), $data['code-retour']);
        }

        return strtoupper($this->_CMCIC_hmac($string));
    }

    /**
     *  Return SHA key
     *
     *  @param    none
     *  @return	  string SHA key
     */
    protected function _getSHAKey()
    {
        return $this->getConfigData('sha_key');
    }

    /**
     *  Return merchant key
     *
     *  @param    none
     *  @return	  string Merchant key
     */
    protected function _getKey()
    {
        return $this->getConfigData('key');
    }

    /**
     *  Return encrypted key
     *
     *  @param    none
     *  @return	  string encrypted key
     */
    /*protected function _getKeyEncrypted()
    {
        $key = $this->getConfigData('key_encrypted');
        $key = Mage::helper('core')->decrypt($key);

        $avant_dernier_tranforme = (ord(substr($key, strlen($key) - 2, 1)) - 23);
        $key = substr($key, 0, strlen($key) - 2) . chr($avant_dernier_tranforme) . substr($key, strlen($key) - 1, 1);

        return pack("H*", $key);
    }*/

    protected function _getKeyEncrypted()
    {
        $key = $this->getConfigData('key_encrypted');
        $key = Mage::helper('core')->decrypt($key);

        $hexStrKey = substr($key, 0, 38);
        $hexFinal = "" . substr($key, 38, 2) . "00";

        $cca0 = ord($hexFinal);

        if ($cca0 > 70 && $cca0 < 97) {
            $hexStrKey .= chr($cca0 - 23) . substr($hexFinal, 1, 1);
        } else {
            if (substr($hexFinal, 1, 1) == "M") {
                $hexStrKey .= substr($hexFinal, 0, 1) . "0";
            } else {
                $hexStrKey .= substr($hexFinal, 0, 2);
            }
        }

        return pack("H*", $hexStrKey);
    }

    /**
     *  Select old and new system
     *
     *  @param    string
     *  @return	  string encrypted key
     */
    protected function _CMCIC_hmac($string)
    {
        if ($this->getConfigData('key_encrypted')) {
            return $this->_CMCIC_hmac_KeyEncrypted($string);
        } else {
            return $this->_CMCIC_hmac_KeyPassphrase($string);
        }
    }

    /**
     * Return MAC string for payment authentification
     * new system
     *
     *  @param    string
     *  @return	  string encrypted key
     */
    protected function _CMCIC_hmac_KeyEncrypted($string)
    {
    	$key = $this->_getKeyEncrypted();

        $length = 64; // block length for SHA1
        if (strlen($key) > $length) {
            $key = pack("H*", sha1($key));
        }

        $key = str_pad($key, $length, chr(0x00));
        $ipad = str_pad('', $length, chr(0x36));
        $opad = str_pad('', $length, chr(0x5c));
        $k_ipad = $key ^ $ipad;
        $k_opad = $key ^ $opad;

        return sha1($k_opad  . pack("H*",sha1($k_ipad . $string)));
    }

    /**
     * Return MAC string for payment authentification
     * old HMAC system
     *
     *  @param    string
     *  @return	  string encrypted key
     */
    protected function _CMCIC_hmac_KeyPassphrase($string)
    {
    	$pass = $this->_getSHAKey();
        $k1 = pack("H*", sha1($this->_getSHAKey()));
        $l1 = strlen($k1);
        $k2 = pack("H*", $this->_getKey());
        $l2 = strlen($k2);
        if ($l1 > $l2) {
            $k2 = str_pad($k2, $l1, chr(0x00));
        } elseif ($l2 > $l1) {
            $k1 = str_pad($k1, $l2, chr(0x00));
        }

        return strtolower($this->_hmacSHA1($k1 ^ $k2, $string));
    }

    /**
     *  Old HMAC SHA system
     *
     *  @param    string
     *  @return	  string encrypted key
     */
    protected function _hmacSHA1($key, $string)
    {
        $length = 64; // block length for SHA1
        if (strlen($key) > $length) {
            $key = pack("H*", sha1($key));
        }

        $key = str_pad($key, $length, chr(0x00));
        $ipad = str_pad('', $length, chr(0x36));
        $opad = str_pad('', $length, chr(0x5c));
        $k_ipad = $key ^ $ipad;
        $k_opad = $key ^ $opad;

        return sha1($k_opad  . pack("H*",sha1($k_ipad . $string)));
    }

    /**
     *  Return MAC string for payment authentification
     *
     *  @param    none
     *  @return	  string MAC
     */
     /* <FONCTION OBSOLETE>
    protected function _CMCIC_hmac($string)
    {
        $pass = $this->_getSHAKey();
        $k1 = pack("H*", sha1($this->_getSHAKey()));
        $l1 = strlen($k1);
        $k2 = pack("H*", $this->_getKey());
        $l2 = strlen($k2);
        if ($l1 > $l2) {
            $k2 = str_pad($k2, $l1, chr(0x00));
        } elseif ($l2 > $l1) {
            $k1 = str_pad($k1, $l2, chr(0x00));
        }

        return strtolower($this->_hmacSHA1($k1 ^ $k2, $string));
    }

    <FONCTION OBSOLETE> */

    /**
     *  MAC generation algorithm
     *
     *  @param    none
     *  @return	  string MAC
     */
    /* <FONCTION OBSOLETE>
    protected function _hmacSHA1($key, $string)
    {
        $length = 64; // block length for SHA1
        if (strlen($key) > $length) {
            $key = pack("H*", sha1($key));
        }

        $key = str_pad($key, $length, chr(0x00));
        $ipad = str_pad('', $length, chr(0x36));
        $opad = str_pad('', $length, chr(0x5c));
        $k_ipad = $key ^ $ipad;
        $k_opad = $key ^ $opad;

        return sha1($k_opad  . pack("H*",sha1($k_ipad . $string)));
    }

    </FONCTIONS OBSOLETES> */

    /**
     * Return authorized languages by CyberMUT
     *
     * @param	none
     * @return	array
     */
    protected function _getAuthorizedLanguages()
    {
        $languages = array();

        foreach (Mage::getConfig()->getNode('global/payment/cybermutforeign_payment/languages')->asArray() as $data) {
            $languages[$data['code']] = $data['name'];
        }

        return $languages;
    }

    /**
     * Return language code to send to CyberMUT
     *
     * @param	none
     * @return	String
     */
    protected function _getLanguageCode()
    {
        // Store language
        $language = strtoupper(substr(Mage::getStoreConfig('general/locale/code'), 0, 2));

        // Authorized Languages
        $authorized_languages = $this->_getAuthorizedLanguages();

        if (count($authorized_languages) === 1) {
            $codes = array_keys($authorized_languages);
            return $codes[0];
        }

        if (array_key_exists($language, $authorized_languages)) {
            return $language;
        }

        // By default we use language selected in store admin
        return $this->getConfigData('language');
    }

    /**
     *  Transaction successful or not
     *
     *  @param    none
     *  @return	  boolean
     */
    public function isSuccessfulPayment($returnCode)
    {
        return in_array($returnCode, array(self::RETURN_CODE_ACCEPTED, self::RETURN_CODE_TEST_ACCEPTED));
    }

    /**
     *  Output success response and stop the script
     *
     *  @param    none
     *  @return	  void
     */
    public function generateSuccessResponse()
    {
        die($this->getSuccessResponse());
    }

    /**
     *  Output failure response and stop the script
     *
     *  @param    none
     *  @return	  void
     */
    public function generateErrorResponse()
    {
        die($this->getErrorResponse());
    }

    /**
     *  Return response for Cybermutforeign success payment
     *
     *  @param    none
     *  @return	  string Success response string
     */
    public function getSuccessResponse()
    {
    	if (((int) $this->getVersion()) >= 3) {
            $response = array(
                'version=2',
                'cdr=0'
            );
        } else {
            $response = array(
                'Pragma: no-cache',
                'Content-type : text/plain',
                'Version: 1',
                'OK'
            );
        }

        return implode("\n", $response) . "\n";
    }

    /**
     *  Return response for Cybermutforeign failure payment
     *
     *  @param    none
     *  @return	  string Failure response string
     */
    public function getErrorResponse()
    {
    	if (((int) $this->getVersion()) >= 3) {
            $response = array(
                'version=2',
                'cdr=1'
            );
        } else {
            $response = array(
                'Pragma: no-cache',
                'Content-type : text/plain',
                'Version: 1',
                'Document falsifie'
            );
        }

        return implode("\n", $response) . "\n";
    }

    public function getSuccessfulPaymentMessage($postData)
    {
        $msg = Mage::helper('cybermutforeign')->__('Payment accepted by Cybermutforeign');

        if (((int) $this->getVersion()) >= 3 && array_key_exists('numauto', $postData)) {
            $msg .= "<br />" . Mage::helper('cybermutforeign')->__('Number of authorization: %s', $postData['numauto']);
            $msg .= "<br />" . Mage::helper('cybermutforeign')->__('Was the visual cryptogram seized: %s', $postData['cvx']);
            $msg .= "<br />" . Mage::helper('cybermutforeign')->__('Validity of the card: %s', $postData['vld']);
            $msg .= "<br />" . Mage::helper('cybermutforeign')->__('Type of the card: %s', $postData['brand']);
        }

        return $msg;
    }

    public function getRefusedPaymentMessage($postData)
    {
        $msg = Mage::helper('cybermutforeign')->__('Payment refused by Cybermutforeign');

        if (((int) $this->getVersion()) >= 3 && array_key_exists('motifrefus', $postData)) {
            $msg .= "<br />" . Mage::helper('cybermutforeign')->__('Motive for refusal: %s', $postData['motifrefus']);
            $msg .= "<br />" . Mage::helper('cybermutforeign')->__('Was the visual cryptogram seized: %s', $postData['cvx']);
            $msg .= "<br />" . Mage::helper('cybermutforeign')->__('Validity of the card: %s', $postData['vld']);
            $msg .= "<br />" . Mage::helper('cybermutforeign')->__('Type of the card: %s', $postData['brand']);
        }

        return $msg;
    }
}