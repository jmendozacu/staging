<?php
/**
 * Magento ArtsOnIt Advanced Smtp
 *
 * @category   ArtsOnIt
 * @package    Mage_AdvanceSmtp
 * @copyright  Copyright (c) 2008 ArtsOn.IT(http://www.ArtsOn.it)
 * @author     Calore Luca Erico (l.calore@ArtsOn.it)
 */
require_once 'class.phpmailer.php';
class Mage_Advancedsmtp_Model_Email extends Mage_Core_Model_Email
{


 public function send()
    {

    	if (!Mage::getStoreConfig('advancedsmtp/settings/enabled'))
		{
			return parent::send();
		}

        if (Mage::getStoreConfigFlag('system/smtp/disable')) {
            return $this;
        }

        $mail = new Zend_Mail();

        if (strtolower($this->getType()) == 'html') {
            $mail->setBodyHtml($this->getBody());
        }
        else {
            $mail->setBodyText($this->getBody());
        }

        $mail->setFrom($this->getFromEmail(), $this->getFromName())
            ->addTo($this->getToEmail(), $this->getToName())
            ->setSubject($this->getSubject());

        	$transport = Mage::helper('advancedsmtp')->getTransport();


        $mail->send($transport);

        return $this;
    }
}