<?php
 
namespace Kitchen\TrainingOrder\Controller\Index;
 
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Quote\Model\QuoteRepository;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Quote\Api\CartManagementInterface;
 
class Delivery extends Action
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
            $deliveryType = '';
            $jsonData = $this->getRequest()->getContent();
            $data = json_decode($jsonData, true);
            if (!isset($data['delivery'])) {
                throw new LocalizedException(__('Required parameter "delivery" is missing.'));
            }

            $deliveryType = $data['delivery'];
            $quotes = $this->checkoutSession->getQuote();
            $quotes->setDelivery($deliveryType);
            $quotes->save();
        } catch (\Throwable $e) {
            return $result->setData(['success' => false, 'message' => $e->getMessage()]);
        }
 
 
        // $customer = $this->customerSession->getCustomerDataObject();
 
        // $quoteId = $this->cartManagementInterface->createEmptyCartForCustomer($customer->getId());
 
        // $quotes = $this->quoteRepository->getActive($quoteId);
 
        // if ($deliveryType == "1") {
        //     $quotes->setDelivery($deliveryType);
        // }
 
        // $this->quoteRepository->save($quotes);
 
        return $result->setData([
            'ID:' => $quotes->getId(),
            'deliveryType' => $deliveryType,
            'message' => 'Active deliveryType save, updated'
        ]);
    }
}
 