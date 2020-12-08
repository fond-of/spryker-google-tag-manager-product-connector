<?php

namespace FondOfSpryker\Yves\GoogleTagManagerProductConnector\Expander;

use Codeception\Test\Unit;
use FondOfSpryker\Shared\GoogleTagManagerProductConnector\GoogleTagManagerProductConnectorConstants as ModuleConstants;
use FondOfSpryker\Yves\GoogleTagManagerProductConnector\Dependency\GoogleTagManagerProductConnectorToTaxProductConnectorInterface;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductViewTransfer;
use Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface;

class DataLayerExpanderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface
     */
    protected $moneyPluginMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Yves\GoogleTagManagerProductConnector\Dependency\GoogleTagManagerProductConnectorToTaxProductConnectorInterface
     */
    protected $taxProductConnectorClientMock;

    /**
     * @var DataLayerExpanderInterface
     */
    protected $expander;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductViewTransfer
     */
    protected $productViewTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductAbstractTransfer
     */
    protected $productAbstractTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->moneyPluginMock = $this->getMockBuilder(MoneyPluginInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->taxProductConnectorClientMock = $this->getMockBuilder(GoogleTagManagerProductConnectorToTaxProductConnectorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productViewTransferMock = $this->getMockBuilder(ProductViewTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productAbstractTransferMock = $this->getMockBuilder(ProductAbstractTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->expander = new DataLayerExpander($this->moneyPluginMock, $this->taxProductConnectorClientMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->productViewTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn('PRODUCT_NAME');

        $this->productViewTransferMock->expects($this->atLeastOnce())
            ->method('getPrice')
            ->willReturn(3999);

        $this->moneyPluginMock->expects($this->atLeastOnce())
            ->method('convertIntegerToDecimal')
            ->willReturn(39.99);

        $this->taxProductConnectorClientMock->expects($this->atLeastOnce())
            ->method('getNetPriceForProduct')
            ->with($this->productAbstractTransferMock)
            ->willReturn($this->productAbstractTransferMock);

        $this->taxProductConnectorClientMock->expects($this->atLeastOnce())
            ->method('getTaxAmountForProduct')
            ->with($this->productAbstractTransferMock)
            ->willReturn($this->productAbstractTransferMock);

        $this->productAbstractTransferMock->expects($this->atLeastOnce())
            ->method('getTaxRate')
            ->willReturn(16);

        $this->productAbstractTransferMock->expects($this->atLeastOnce())
            ->method('getNetPrice')
            ->willReturn(3999);

        $result = $this->expander->expand('pageType', [
            ModuleConstants::PARAM_PRODUCT => $this->productViewTransferMock,
            ModuleConstants::PARAM_PRODUCT_ABSTRACT => $this->productAbstractTransferMock,
        ], []);

        $this->assertArrayHasKey(ModuleConstants::FIELD_ID, $result);
        $this->assertArrayHasKey(ModuleConstants::FIELD_NAME, $result);
        $this->assertArrayHasKey(ModuleConstants::FIELD_SKU, $result);
        $this->assertArrayHasKey(ModuleConstants::FIELD_PRICE, $result);
        $this->assertArrayHasKey(ModuleConstants::FIELD_PRICE_EXCLUDING_TAX, $result);
        $this->assertArrayHasKey(ModuleConstants::FIELD_TAX_RATE, $result);
        $this->assertArrayHasKey(ModuleConstants::FIELD_TAX_AMOUNT, $result);
    }
}
