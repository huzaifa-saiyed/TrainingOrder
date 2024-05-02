<?php

namespace Kitchen\TrainingOrder\Controller\Index;

class DeleteQuote extends \Magento\Framework\App\Action\Action
{
    protected $resultJsonFactory;
    protected $quoteFactory;
    protected $checkoutSession;

    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Quote\Model\QuoteFactory $quoteFactory
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->checkoutSession = $checkoutSession;
        $this->quoteFactory = $quoteFactory;
    }

    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        $getQuote = $this->checkoutSession->getQuote();
        $isActive = (int) $getQuote->getIsActive();
        $quoteId = $getQuote->getId();

        $varOne = $this->quoteFactory->create();
        $varOne->load($quoteId);
        $varOne->setIsActive(0);
        $varOne->save();
        
        if ($quoteId) {
            // Active quote exists
            return $result->setData([
                'ID:' => $quoteId,
                'isActive' => $isActive, 
                'message' => 'Active quote exists'
            ]);
        } else {
            return $result->setData([
                'ID:' => $quoteId,
                'isActive' => $isActive, 
                'message' => 'Active quote does\'t exists'
            ]);
        }
    }
}
