<?php

class MDN_DropShipping_Block_Widget_Grid_Column_Renderer_DropShippableAction extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    public function render(Varien_Object $order) {
    
        $html = '';
        $html .= '<button style="margin-top: 3px;" onclick="applyDropShippableAction('.$order->getId().');" class="scalable save" type="button"><span>'.$this->__('Apply').'</span></button>';
        return $html;
        
    }

}