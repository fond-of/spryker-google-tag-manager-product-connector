<?php

namespace FondOfSpryker\Yves\GoogleTagManagerProductConnector\Dependency;

use FondOfSpryker\Client\TaxProductConnector\TaxProductConnectorClientInterface;
use Generated\Shared\Transfer\ProductAbstractTransfer;

class GoogleTagManagerProductConnectorToTaxProductConnectorBridge implements GoogleTagManagerProductConnectorToTaxProductConnectorInterface
{
    /**
     * @var \FondOfSpryker\Client\TaxProductConnector\TaxProductConnectorClientInterface
     */
    protected $taxProductConnectorClient;

    /**
     * @param \FondOfSpryker\Client\TaxProductConnector\TaxProductConnectorClientInterface $taxProductConnectorClient
     */
    public function __construct(TaxProductConnectorClientInterface $taxProductConnectorClient)
    {
        $this->taxProductConnectorClient = $taxProductConnectorClient;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function getNetPriceForProduct(ProductAbstractTransfer $productAbstractTransfer): ProductAbstractTransfer
    {
        return $this->taxProductConnectorClient->getNetPriceForProduct($productAbstractTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function getTaxAmountForProduct(ProductAbstractTransfer $productTransfer): ProductAbstractTransfer
    {
        return $this->taxProductConnectorClient->getTaxAmountForProduct($productTransfer);
    }
}
