<?php
 
namespace Kitchen\TrainingOrder\Plugin;
 
class DefaultConfigProviderPlugin
{
    protected $cacheTypeList;
    protected $checkoutSession;
 
    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
    ) {
        $this->cacheTypeList = $cacheTypeList;
        $this->checkoutSession   = $checkoutSession;
    }
 
    public function afterGetConfig(
 
        \Magento\Checkout\Model\DefaultConfigProvider $subject,
    
        $output
    
      ) {
    
        $quote = $this->checkoutSession->getQuote();
 
        $shipping = $quote->getShippingTypes();
        $output['shipping_type'] = $shipping;
 
      
 
        $output['residential'] = (int) $quote->getResidential();
        $output['liftgate'] = (int) $quote->getLiftgate();
        $output['delivery'] = (int) $quote->getDelivery();
    
 
        return $output;
    
      }
}
 