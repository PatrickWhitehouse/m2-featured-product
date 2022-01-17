<?php

declare(strict_types=1);

namespace FoundationCommerce\ProductBlock\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;

class Product implements ArgumentInterface 
{

        protected $productRepository; 
        protected $scopeConfig;
        
        public function __construct(
                \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
                \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
                )
        { 
               $this->productRepository = $productRepository;
               $this->scopeConfig = $scopeConfig;
        }

        private function getSkuFromAdmin() {
                $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
                return $this->scopeConfig->getValue(
                        'section_featured_product/group_featured_product/featured_sku',
                        $storeScope
                );
        }


        public function getProductDataUsingSku()
        {
                $sku = $this->getSkuFromAdmin();
                if($sku){
                         return $this->productRepository->get($this->getSkuFromAdmin());
                } else {
                        return; 
                }
        }

}

?>