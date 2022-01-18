<?php

declare(strict_types=1);

namespace FoundationCommerce\ProductBlock\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Directory\Model\CurrencyFactory;
use \Magento\Framework\Exception\NoSuchEntityException;

class Product implements ArgumentInterface 
{

        private $productRepository; 
        private $scopeConfig;
        private $scopeConfigInterface;
        private $currencyCode;
        
        public function __construct(
                ProductRepositoryInterface $productRepository,
                ScopeConfigInterface $scopeConfig,
                StoreManagerInterface $scopeConfigInterface,
                CurrencyFactory $currencyFactory
                )
        { 
               $this->productRepository = $productRepository;
               $this->scopeConfig = $scopeConfig;
               $this->scopeConfigInterface = $scopeConfigInterface;
               $this->currencyCode = $currencyFactory->create();
        }

        // Return sku passed into the admin field

        private function getSkuFromAdmin() 
        {
              
                return $this->scopeConfig->getValue(
                        'section_featured_product/group_featured_product/featured_sku',
                        ScopeInterface::SCOPE_STORE
                );
        }

        // If SKU is present in the admin field, this returns the product data

        public function getProductDataUsingSku()
        {
                $sku = $this->getSkuFromAdmin();
                if(!$sku){
                        return false;        
                }

                // Try catch incase sku is invalid and doesn't return a product
                try {
                        return $this->productRepository->get($this->getSkuFromAdmin());
                } 
                catch(NoSuchEntityException $exception) {
                        return false;
                }
        }

        // Returns the store currency symbol, then echoed infront of the price

        public function getCurrencySymbol()
        {
                $currentCurrency = $this->scopeConfigInterface->getStore()->getCurrentCurrencyCode();
                $currency = $this->currencyCode->load($currentCurrency);
                return $currency->getCurrencySymbol();
        }

}

?>