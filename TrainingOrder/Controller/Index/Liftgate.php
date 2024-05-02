<?php
 
namespace Kitchen\TrainingOrder\Controller\Index;
 
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Quote\Model\QuoteRepository;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Quote\Api\CartManagementInterface;
 
class Liftgate extends Action
{
    protected $quoteRepository;
    protected $resultJsonFactory;
    protected $checkoutSession;
    protected $customerSession;
    protected $cartManagementInterface;
 
    public function __construct(
        Context $context,
        QuoteRepository $quoteRepository,
        JsonFactory $resultJsonFactory,
        CheckoutSession $checkoutSession,
        CustomerSession $customerSession,
        CartManagementInterface $cartManagementInterface
    ) {
        parent::__construct($context);
        $this->quoteRepository = $quoteRepository;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->checkoutSession = $checkoutSession;
        $this->customerSession = $customerSession;
        $this->cartManagementInterface = $cartManagementInterface;
    }
 
    public function execute()   
    {
        $result = $this->resultJsonFactory->create();

        try {
            $liftgateType = '';
            $jsonData = $this->getRequest()->getContent();
            $data = json_decode($jsonData, true);
            if (!isset($data['liftgate'])) {
                throw new LocalizedException(__('Required parameter "liftgate" is missing.'));
            }

            $liftgateType = $data['liftgate'];

            $quotes = $this->checkoutSession->getQuote();
            $quotes->setLiftgate($liftgateType);
            $quotes->save();
 
        } catch (\Exception $e) {
            return $result->setData(['success' => false, 'message' => $e->getMessage()]);
        }
 
        return $result->setData([
            'ID:' => $quotes->getId(),
            'liftgateType' => $liftgateType,
            'message' => 'Active liftgateType save, updated'
        ]);
    }
}
 