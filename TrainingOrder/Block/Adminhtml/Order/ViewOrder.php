<?php
/**
* Copyright © Magento, Inc. All rights reserved.
* See COPYING.txt for license details.
*/
namespace Kitchen\TrainingOrder\Block\Adminhtml\Order;
 
/**
* Adminhtml order abstract block
*
* @api
* @author      Magento Core Team <core@magentocommerce.com>
* @since 100.0.2
*/
class ViewOrder extends \Magento\Sales\Block\Adminhtml\Order\AbstractOrder
{
    
    public function getShippingTypes()
    {
        $order = $this->getOrder();
        if ($order) {
            return $order->getShippingTypes();
        }
        return null;
    
    }
 
    public function getResidential()
    {
        $order = $this->getOrder();
        if ($order) {
            return $order->getResidential();
        }
        return null;
    
    }
    public function getLiftgate()
    {
        $order = $this->getOrder();
        if ($order) {
            return $order->getLiftgate();
        }
        return null;
    
    }
    public function getDelivery()
    {
        $order = $this->getOrder();
        if ($order) {
            return $order->getDelivery();
        }
        return null;
    
    }
}
 