<?php

namespace FondOfSpryker\Yves\GoogleTagManagerProductConnector\Dependency;

use Codeception\Test\Unit;
use FondOfSpryker\Client\TaxProductConnector\TaxProductConnectorClientInterface;
use Generated\Shared\Transfer\ProductAbstractTransfer;

class GoogleTagManagerProductConnectorToTaxProductConnectorBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Client\TaxProductConnector\TaxProductConnectorClientInterface
     */
    protected $taxProductConnectorClientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductAbstractTransfer
     */
    protected $productAbstractTransferMock;

    /**
     * @var GoogleTagManagerProductConnectorToTaxProductConnectorInterface
     */
    protected $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->taxProductConnectorClientMock = $this->getMockBuilder(TaxProductConnectorClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productAbstractTransferMock = $this->getMockBuilder(ProductAbstractTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new GoogleTagManagerProductConnectorToTaxProductConnectorBridge($this->taxProductConnectorClientMock);
    }

    /**
     * @return void
     */
    public function testGetNetPriceForProduct(): void
    {
        $this->taxProductConnectorClientMock->expects($this->atLeastOnce())
            ->method('getNetPriceForProduct')
            ->willReturn($this->productAbstractTransferMock);

        $this->bridge->getNetPriceForProduct($this->productAbstractTransferMock);
    }

    /**
     * @return void
     */
    public function testGetTaxAmountForProduct(): void
    {
        $this->taxProductConnectorClientMock->expects($this->atLeastOnce())
            ->method('getTaxAmountForProduct')
            ->willReturn($this->productAbstractTransferMock);

        $this->bridge->getTaxAmountForProduct($this->productAbstractTransferMock);
    }
}
