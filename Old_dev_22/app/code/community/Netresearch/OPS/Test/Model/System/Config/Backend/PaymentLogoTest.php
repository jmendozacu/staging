<?php
/**
 * Netresearch OPS
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to
 * newer versions in the future.
 *
 * PHP version 5
 *
 * @category  OPS
 * @package   Netresearch_OPS
 * @author    Benjamin Heuer <benjamin.heuer@netresearch.de>
 * @copyright 2016 Netresearch GmbH & Co. KG
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.netresearch.de/
 */

/**
 * Netresearch_OPS_Test_Block_System_Config_PaymentLogoTest
 *
 * @category OPS
 * @package  Netresearch_OPS
 * @author   Benjamin Heuer <benjamin.heuer@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class Netresearch_OPS_Test_Model_System_Config_Backend_PaymentLogoTest
    extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @test
     */
    public function toOptionArray()
    {
        /** @var Netresearch_Ops_Model_System_Config_Backend_PaymentLogo $optionModel */
        $optionModel = Mage::getModel('ops/system_config_backend_paymentLogo');

        $result = $optionModel->toOptionArray();

        $this->assertInternalType('array', $result);
        $this->assertArrayHasKey('value', $result[0]);
    }

}
