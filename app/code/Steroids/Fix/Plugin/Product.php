<?php
namespace Steroids\Fix\Plugin;

class Product
{               
    public function afterIsSaleable(\Magento\Catalog\Model\Product $product, $isSaleable)
    {           
            return false;

    }

}