<?php
/**
 * Mirasvit
 *
 * This source file is subject to the Mirasvit Software License, which is available at http://mirasvit.com/license/.
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 * If you wish to customize this module for your needs
 * Please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Mirasvit
 * @package   Trigger Email Suite
 * @version   1.0.1
 * @revision  168
 * @copyright Copyright (C) 2014 Mirasvit (http://mirasvit.com/)
 */


class Mirasvit_EmailReport_Block_Adminhtml_Recipient_Single extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller     = 'adminhtml_recipient_single';
        $this->_blockGroup     = 'emailreport';
        $this->_headerText     = Mage::helper('emaildesign')->__('Single recipient');
        
        parent::__construct();

        $this->_removeButton('add');
    }
}