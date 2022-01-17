<?php

declare(strict_types=1);

namespace FoundationCommerce\ProductBlock\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Product implements ArgumentInterface 
{

        protected $productRepository; 
        protected $scopeConfig;
        
        public function __construct(
                ProductRepositoryInterface $productRepository,
                ScopeConfigInterface $scopeConfig
                )
        { 
               $this->productRepository = $productRepository;
               $this->scopeConfig = $scopeConfig;
        }

        private function getSkuFromAdmin() {
              
                return $this->scopeConfig->getValue(
                        'section_featured_product/group_featured_product/featured_sku',
                        ScopeInterface::SCOPE_STORE
                );
        }


        public function getProductDataUsingSku()
        {
                $sku = $this->getSkuFromAdmin();
                if($sku){
                         return $this->productRepository->get($this->getSkuFromAdmin());
                }
        }

}

?>