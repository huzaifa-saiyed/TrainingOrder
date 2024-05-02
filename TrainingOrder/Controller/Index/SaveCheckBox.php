<?php

namespace Kitchen\TrainingOrder\Controller\Index;

class SaveCheckBox extends \Magento\Framework\App\Action\Action
{
    protected $resultJsonFactory;
    protected $quoteFactory;
    // protected $customerSession;
    protected $cartManagementInterface;
    protected $quoteRepository;
    protected $checkoutSession;
  

    public function __construct(
        // \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Quote\Model\QuoteFactory $quoteFactory,
        \Magento\Quote\Api\CartManagementInterface $cartManagementInterface,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
    ) {
        parent::__construct($context);
        // $this->customerSession = $customerSession;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->quoteFactory = $quoteFactory;
        $this->checkoutSession = $checkoutSession;
        $this->cartManagementInterface = $cartManagementInterface;
        $this->quoteRepository = $quoteRepository;
    }

    public function execute()   
    {
        $result = $this->resultJsonFactory->create();

        try {
            $residentialType = '';
            $liftgateType = '';
            $deliveryType = '';

            $jsonData = $this->getRequest()->getContent();
            $data = json_decode($jsonData, true);

            if (!isset($data['residential']) || !isset($data['liftgate']) || !isset($data['delivery'])) {
                throw new LocalizedException(__('Required parameter "residential-liftgate-delivery" is missing.'));
            }
            $residentialType = $data['residential'];
            $liftgateType = $data['liftgate'];
            $deliveryType = $data['delivery'];

            $quotes = $this->checkoutSession->getQuote();
            $quotes->setResidential($residentialType);
            $quotes->setLiftgate($liftgateType);
            $quotes->setDelivery($deliveryType);
            $quotes->save();
        } catch (\Throwable $e) {
            return $result->setData(['success' => false, 'message' => $e->getMessage()]);
        }
       
        // $customer = $this->customerSession->getCustomerDataObject();

        // $quoteId = $this->cartManagementInterface->createEmptyCartForCustomer($customer->getId());

        // $quotes = $this->quoteRepository->getActive($quoteId);


        // $quotes->setResidential($residentialType);
        // $quotes->setLiftgate($liftgateType);
        // $quotes->setDelivery($deliveryType);
            
        // $this->quoteRepository->save($quotes);

        return $result->setData([
            'ID:' => $quotes->getId(),
            'Resi' => $residentialType, 
            'Lift' => $liftgateType, 
            'Deli' => $deliveryType, 
            'message' => 'Active quote save, updated'
        ]);
    }
}
