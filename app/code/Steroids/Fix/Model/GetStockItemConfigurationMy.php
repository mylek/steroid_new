<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Steroids\Fix\Model;

use \Magento\InventoryApi\Model\IsProductAssignedToStockInterface;
use \Magento\InventoryCatalogApi\Api\DefaultStockProviderInterface;
use \Magento\InventoryConfigurationApi\Api\GetStockItemConfigurationInterface;
use \Magento\InventoryConfigurationApi\Api\Data\StockItemConfigurationInterface;
use \Magento\InventoryConfigurationApi\Exception\SkuIsNotAssignedToStockException;
use \Magento\InventoryConfigurationApi\Model\IsSourceItemManagementAllowedForSkuInterface;
use \Magento\Setup\Module\Di\Code\Generator\Interceptor;
use \Magento\Framework\ObjectManager\Factory\AbstractFactory;
use \Magento\InventoryConfiguration\Model\GetLegacyStockItem;
use \Magento\InventoryConfiguration\Model\StockItemConfigurationFactory;

/**
 * @inheritdoc
 */
class GetStockItemConfigurationMy implements GetStockItemConfigurationInterface
{
    /**
     * @var GetLegacyStockItem
     */
    private $getLegacyStockItem;

    /**
     * @var StockItemConfigurationFactory
     */
    private $stockItemConfigurationFactory;

    /**
     * @var IsProductAssignedToStockInterface
     */
    private $isProductAssignedToStock;

    /**
     * @var DefaultStockProviderInterface
     */
    private $defaultStockProvider;

    /**
     * @var IsSourceItemManagementAllowedForSkuInterface
     */
    private $isSourceItemManagementAllowedForSku;

    /**
     * @param GetLegacyStockItem $getLegacyStockItem
     * @param StockItemConfigurationFactory $stockItemConfigurationFactory
     * @param IsProductAssignedToStockInterface $isProductAssignedToStock
     * @param DefaultStockProviderInterface $defaultStockProvider
     * @param IsSourceItemManagementAllowedForSkuInterface $isSourceItemManagementAllowedForSku
     */
    public function __construct(
        GetLegacyStockItem $getLegacyStockItem,
        StockItemConfigurationFactory $stockItemConfigurationFactory,
        IsProductAssignedToStockInterface $isProductAssignedToStock,
        DefaultStockProviderInterface $defaultStockProvider,
        IsSourceItemManagementAllowedForSkuInterface $isSourceItemManagementAllowedForSku
    ) {
        $this->getLegacyStockItem = $getLegacyStockItem;
        $this->stockItemConfigurationFactory = $stockItemConfigurationFactory;
        $this->isProductAssignedToStock = $isProductAssignedToStock;
        $this->defaultStockProvider = $defaultStockProvider;
        $this->isSourceItemManagementAllowedForSku = $isSourceItemManagementAllowedForSku;
    }

    /**
     * @inheritdoc
     */
    public function execute(string $sku, int $stockId): StockItemConfigurationInterface
    {
        return $this->stockItemConfigurationFactory->create(
            [
                'stockItem' => $this->getLegacyStockItem->execute($sku)
            ]
        );
    }
}
