<?php

/*
 * @author     M2E Pro Developers Team
 * @copyright  2011-2015 ESS-UA [M2E Pro]
 * @license    Commercial use is forbidden
 */

class Ess_M2ePro_Block_Adminhtml_Ebay_Template_Synchronization_Edit_Form_Tabs_Schedule
    extends Ess_M2ePro_Block_Adminhtml_Ebay_Template_Synchronization_Edit_Form_Data
{
    //########################################

    public function __construct()
    {
        parent::__construct();

        // Initialization block
        // ---------------------------------------
        $this->setId('ebayTemplateSynchronizationEditFormTabsSchedule');
        // ---------------------------------------

        $this->setTemplate('M2ePro/ebay/template/synchronization/form/tabs/schedule.phtml');
    }

    //########################################

    public function getFormData()
    {
        $data = parent::getFormData();

        // ---------------------------------------
        if (!empty($data['schedule_interval_settings']) && is_string($data['schedule_interval_settings'])) {

            $scheduleIntervalSettings = Mage::helper('M2ePro')->jsonDecode($data['schedule_interval_settings']);
            unset($data['schedule_interval_settings']);

            if (isset($scheduleIntervalSettings['mode'])) {
                $data['schedule_interval_settings']['mode'] = $scheduleIntervalSettings['mode'];
            }

            if (isset($scheduleIntervalSettings['date_from'])) {
                $data['schedule_interval_settings']['date_from'] =
                    Mage::helper('M2ePro')->gmtDateToTimezone($scheduleIntervalSettings['date_from'],false,'Y-m-d');
            }

            if (isset($scheduleIntervalSettings['date_to'])) {
                $data['schedule_interval_settings']['date_to'] =
                    Mage::helper('M2ePro')->gmtDateToTimezone($scheduleIntervalSettings['date_to'],false,'Y-m-d');
            }
        } else {
            unset($data['schedule_interval_settings']);
        }
        // ---------------------------------------

        // ---------------------------------------
        if (!empty($data['schedule_week_settings']) && is_string($data['schedule_week_settings'])) {

            $scheduleWeekSettings = Mage::helper('M2ePro')->jsonDecode($data['schedule_week_settings']);
            unset($data['schedule_week_settings']);

            $parsedSettings = array();
            foreach ($scheduleWeekSettings as $day => $scheduleDaySettings) {

                $fromTimestamp = strtotime($scheduleDaySettings['time_from']);
                $toTimestamp   = strtotime($scheduleDaySettings['time_to']);

                $parsedSettings[$day] = array(
                    'hours_from'   => date('g', $fromTimestamp),
                    'minutes_from' => date('i', $fromTimestamp),
                    'appm_from'    => date('a', $fromTimestamp),

                    'hours_to'   => date('g', $toTimestamp),
                    'minutes_to' => date('i', $toTimestamp),
                    'appm_to'    => date('a', $toTimestamp),
                );
            }

            $data['schedule_week_settings'] = $parsedSettings;
        } else {
            unset($data['schedule_week_settings']);
        }
        // ---------------------------------------

        return $data;
    }

    //########################################

    public function getDefault()
    {
        $default = Mage::helper('M2ePro/View_Ebay')->isSimpleMode()
            ? Mage::getSingleton('M2ePro/Ebay_Template_Synchronization')->getScheduleDefaultSettingsSimpleMode()
            : Mage::getSingleton('M2ePro/Ebay_Template_Synchronization')->getScheduleDefaultSettingsAdvancedMode();

        $helper = Mage::helper('M2ePro');
        $default['schedule_interval_settings'] = $helper->jsonDecode($default['schedule_interval_settings']);
        $default['schedule_week_settings'] = $helper->jsonDecode($default['schedule_week_settings']);

        return $default;
    }

    //########################################

    public function isDayExistInWeekSettingsArray($day, $weekSettings)
    {
        $daysInSettingsArray = array_keys($weekSettings);
        return in_array(strtolower($day), $daysInSettingsArray);
    }

    //########################################
}